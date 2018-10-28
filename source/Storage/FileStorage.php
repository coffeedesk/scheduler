<?php

namespace Coffeedesk\Scheduler\Storage;

use Coffeedesk\Scheduler\Execution;
use Gaufrette\Filesystem;

class FileStorage extends MemoryStorage {

    /** @var Filesystem */
    private $_filesystem;

    /** @var string */
    private $_path;

    /**
     * @param Filesystem $filesystem
     * @param string     $path
     */
    public function __construct(Filesystem $filesystem, $path) {
        parent::__construct();
        $this->_filesystem = $filesystem;
        $this->_path = $path;
        $this->_loadEntriesFromFile();
    }

    public function set(Execution $execution) {
        parent::set($execution);
        $this->_saveEntriesToFile();
    }

    protected function _saveEntriesToFile() {
        $data = \Functional\map($this->_entries, function (Execution $execution) {
            return [
                'identifier'  => $execution->getTaskIdentifier(),
                'lastRuntime' => $execution->getLastRuntime(),
            ];
        });
        $contents = json_encode($data);
        $this->_filesystem->write($this->_path, $contents, true);
    }

    protected function _loadEntriesFromFile() {
        if ($this->_filesystem->has($this->_path)) {
            $contents = $this->_filesystem->read($this->_path);
            $data = json_decode($contents, true);
            $this->_entries = \Functional\map($data, function ($row) {
                $execution = new Execution($row['identifier']);
                $execution->setLastRuntime($row['lastRuntime']);
                return $execution;
            });
        }
    }
}
