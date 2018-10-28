<?php

namespace Coffeedesk\Scheduler\Workload;

interface Workload {

    /**
     * @param \DateTime|null $lastRuntime
     * @param \DateTime      $currentRuntime
     * @return mixed
     */
    public function run(\DateTime $lastRuntime = null, \DateTime $currentRuntime);
}
