<?php

namespace Coffeedesk\Scheduler\Matcher;

interface Matcher {

    /**
     * @param int $lastRuntime
     * @param int $currentTime
     * @return boolean
     */
    public function shouldRun($lastRuntime, $currentTime);
}
