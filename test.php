<?php

require 'vendor/autoload.php';


$adapter = new \Gaufrette\Adapter\Local(__DIR__);
$filesystem = new \Gaufrette\Filesystem($adapter);
$storage = new Coffeedesk\Scheduler\Storage\FileStorage($filesystem, 'tmp/scheduler-storage.json');

$logger = new \Psr\Log\NullLogger();
$scheduler = new \Coffeedesk\Scheduler\Scheduler($storage, $logger);

$task = new \Coffeedesk\Scheduler\Task(
    'every-hour-job',
    new Coffeedesk\Scheduler\Matcher\IntervalMatcher(60 * 60),
    new Coffeedesk\Scheduler\Workload\ClosureWorkload(function () {
        echo 'Am running every hour';
    })
);

$scheduler->addTask($task);
$scheduler->run();
