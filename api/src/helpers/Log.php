<?php

namespace MemoryCard\Helpers;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class Log {
    static private $logs = [];

    public static function init(string $logName): Logger
    {
        if (array_key_exists($logName, self::$logs)) {
            return self::$logs[$logName];
        }

        $logger = new Logger($logName);
        $logger->pushHandler(new StreamHandler(__DIR__.'/../../app.log', Level::Debug));

        self::$logs[$logName] = $logger;
        return $logger;
    }
}