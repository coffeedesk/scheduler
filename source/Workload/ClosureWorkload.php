<?php

namespace Coffeedesk\Scheduler\Workload;

class ClosureWorkload implements Workload {

    /** @var \Closure */
    private $_closure;

    /**
     * @param \Closure $closure
     */
    public function __construct(\Closure $closure) {
        $this->_closure = $closure;
    }

    public function run(\DateTime $lastRuntime = null, \DateTime $currentRuntime) {
        return call_user_func($this->_closure, $lastRuntime, $currentRuntime);
    }

}
