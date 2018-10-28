<?php

namespace Coffeedesk\Scheduler\Storage;

use Coffeedesk\Scheduler\Execution;

interface ExecutionStorage {

    /**
     * @param string $identifier
     * @return Execution|null
     */
    public function get($identifier);

    /**
     * @param Execution $execution
     */
    public function set(Execution $execution);
}
