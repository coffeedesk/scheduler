<?php

namespace Coffeedesk\Scheduler\Matcher;

class IntervalMatcher implements Matcher {

    /** @var int */
    private $_interval;

    /**
     * @param int $interval
     */
    public function __construct($interval) {
        $this->_interval = (int) $interval;
    }

    public function shouldRun($lastRuntime, $currentTime) {
        if (!$lastRuntime) {
            return true;
        }
        return ($currentTime - $lastRuntime > $this->_interval);
    }
}
