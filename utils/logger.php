<?php
require_once __DIR__ . '/../interfaces/IObserver.php';

# Both Structural Design Pattern: Singleton and Behavioral Design Pattern: Observer
class Logger implements IObserver
{
    private static $instance = null;
    private $logFile;

    private function __construct()
    {
        $this->logFile = __DIR__ . "/../logs/app.log";

        // create the logs folder if it doesn't exist
        if (!is_dir(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0755, true);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function log($level, $message)
    {
        $timestamp = date("Y-m-d H:i:s");
        $entry = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents($this->logFile, $entry, FILE_APPEND | LOCK_EX);
    }

    public function update($event, $data)
    {
        $this->log("INFO", "Event: $event | Data: $data");
    }
}
