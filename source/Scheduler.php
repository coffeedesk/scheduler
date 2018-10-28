<?php

namespace Coffeedesk\Scheduler;

use \Exception;
use Coffeedesk\Scheduler\Matcher\Matcher;
use Coffeedesk\Scheduler\Storage\ExecutionStorage;
use Coffeedesk\Scheduler\Workload\ClosureWorkload;
use Psr\Log\LoggerInterface;

class Scheduler {

    /** @var Task[] */
    private $_tasks;

    /** @var ExecutionStorage */
    private $_storage;

    /** @var LoggerInterface */
    private $_logger;

    /**
     * @param ExecutionStorage $storage
     * @param LoggerInterface  $logger
     */
    public function __construct(ExecutionStorage $storage, LoggerInterface $logger) {
        $this->_storage = $storage;
        $this->_logger = $logger;
        $this->_tasks = [];
    }

    /**
     * @param string   $identifier
     * @param Matcher  $matcher
     * @param \Closure $workload
     * @throws Exception
     */
    public function register($identifier, Matcher $matcher, \Closure $workload) {
        $task = new Task($identifier, $matcher, new ClosureWorkload($workload));
        $this->addTask($task);
    }

    /**
     * @param TaskSet $taskSet
     * @throws Exception
     */
    public function registerTaskSet(TaskSet $taskSet) {
        foreach ($taskSet->getTasks() as $task) {
            $this->addTask($task);
        }
    }

    /**
     * @param Task $task
     * @throws Exception
     */
    public function addTask(Task $task) {
        if (isset($this->_tasks[$task->getIdentifier()])) {
            throw new Exception("Task `{$task->getIdentifier()}` already registered");
        }
        $this->_tasks[$task->getIdentifier()] = $task;
    }

    public function run() {
        foreach ($this->_tasks as $task) {
            $execution = $this->_storage->get($task->getIdentifier());
            if (!$execution) {
                $execution = new Execution($task->getIdentifier());
            }
            $currentTime = time();
            if ($task->getMatcher()->shouldRun($execution->getLastRuntime(), $currentTime)) {
                $this->_logger->debug("Scheduler: Running {$execution->getTaskIdentifier()}");

                $currentDateTime = (new \DateTime())->setTimestamp($currentTime);
                $lastRunDateTime = $execution->getLastRuntime() ? (new \DateTime())->setTimestamp($execution->getLastRuntime()) : null;
                try {
                    $task->getWorkload()->run($lastRunDateTime, $currentDateTime);
                } catch (Exception $exception) {
                    $this->_logger->error('Scheduler task failed', [
                        'exception' => $exception,
                    ]);
                    continue;
                }
                $execution->setLastRuntime($currentTime);
                $this->_storage->set($execution);
            }
        }
    }
}
