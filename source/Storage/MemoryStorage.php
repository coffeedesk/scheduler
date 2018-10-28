<?php

namespace Coffeedesk\Scheduler\Storage;

use Coffeedesk\Scheduler\Execution;

class MemoryStorage implements ExecutionStorage {

    /** @var array */
    protected $_entries;

    public function __construct() {
        $this->_entries = [];
    }

    public function get($identifier) {
        if (!isset($this->_entries[$identifier])) {
            return null;
        }
        return $this->_entries[$identifier];
    }

    public function set(Execution $execution) {
        $this->_entries[$execution->getTaskIdentifier()] = $execution;
    }

}
