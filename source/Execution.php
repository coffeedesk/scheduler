<?php

namespace Coffeedesk\Scheduler;

class Execution {

    /** @var string */
    private $_taskIdentifier;

    /** @var int */
    private $_lastRuntime;

    /**
     * @param string $taskIdentifier
     */
    public function __construct($taskIdentifier) {
        $this->_taskIdentifier = (string) $taskIdentifier;
    }

    /**
     * @return string
     */
    public function getTaskIdentifier() {
        return $this->_taskIdentifier;
    }

    /**
     * @return int|null
     */
    public function getLastRuntime() {
        return $this->_lastRuntime;
    }

    /**
     * @param int $lastRuntime
     */
    public function setLastRuntime($lastRuntime) {
        $this->_lastRuntime = $lastRuntime;
    }

}
