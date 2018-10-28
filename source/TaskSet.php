<?php

namespace Coffeedesk\Scheduler;

class TaskSet {

    /** @var Task[] */
    private $_tasks;

    /**
     * @param Task[]|null $tasks
     */
    public function __construct(array $tasks = null) {
        $this->_tasks = [];
        foreach ((array) $tasks as $task) {
            $this->addTask($task);
        }
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task) {
        $this->_tasks[] = $task;
    }

    /**
     * @return Task[]
     */
    public function getTasks() {
        return $this->_tasks;
    }

}
