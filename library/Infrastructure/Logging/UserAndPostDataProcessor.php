<?php

namespace Library\Infrastructure\Logging;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class UserAndPostDataProcessor implements ProcessorInterface {

    /**
     * @var array|\ArrayAccess
     */
    protected $postData;

    /**
     * @var array|\ArrayAccess
     */
    protected $rawPost;

    private $serverData;

    public function __construct() {
        $this->serverData = &$_SERVER;
        $this->postData = &$_POST;
        $contents = file_get_contents('php://input');
        if ($contents !== false) {
            $this->rawPost = json_decode($contents, true);
        }
    }

    /**
     * Process the log record by injecting POST data if available.
     *
     * @param LogRecord $record
     * @return LogRecord
     */
    public function __invoke(LogRecord $record): LogRecord {
        if (!isset($this->serverData['REQUEST_URI'])) {
            return $record;
        }

        // Create a copy of the existing extra data.
        $newExtra = $record->extra;

        $newExtra["postParams"] = $this->postData ?? null;
        $newExtra["rawPostParams"] = $this->rawPost ?? null;

        // Return a new record with the modified extra data.
        return $record->with(extra: $newExtra);
    }
}
