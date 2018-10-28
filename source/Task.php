<?php

namespace Coffeedesk\Scheduler;

use Coffeedesk\Scheduler\Matcher\Matcher;
use Coffeedesk\Scheduler\Workload\Workload;

class Task {

    /** @var string */
    private $_identifier;

    /** @var Matcher */
    private $_matcher;

    /** @var Workload */
    private $_workload;

    public function __construct($identifier, Matcher $matcher, Workload $workload) {
        $this->_identifier = (string) $identifier;
        $this->_matcher = $matcher;
        $this->_workload = $workload;
    }

    /**
     * @return string
     */
    public function getIdentifier() {
        return $this->_identifier;
    }

    /**
     * @return Matcher
     */
    public function getMatcher() {
        return $this->_matcher;
    }

    /**
     * @return Workload
     */
    public function getWorkload() {
        return $this->_workload;
    }

}
