<?php

namespace App\Console\Commands\Helpers;

use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class ReadLog
{
    private string $log;
    private int $insertedRow = 0;
    private array $errors = [];

    public function __construct($log)
    {
        $this->log = $log;
    }

    public function incrementInsertedRowCount()
    {
        $this->insertedRow++;
    }

    public function getLog(): string
    {
        return $this->log;
    }

    public function getInsertedRow(): string
    {
        return $this->insertedRow;
    }

    public function setError($error)
    {
        $this->errors[] = $error;
    }

    #[Pure] public function getResultMessage()
    {
        if (sizeof($this->errors) > 0) {
            $result = implode("\n", $this->errors);
        } else {
            $result = $this->getInsertedRow() . " row inserted in database now.";
        }
        return $result;
    }


    #[ArrayShape(['serviceName' => "mixed", 'statusCode' => "mixed", 'startDate' => "string", 'endDate' => "string"])] public function prepareInputData($data)
    {
        return [
            'serviceName' => $data[1],
            'statusCode' => $data[2],
            'startDate' => Carbon::parse($data[3] . " " . $data[4])->toDateTimeString(),
            'endDate' => Carbon::parse($data[5] . " " . $data[6])->toDateTimeString(),
        ];
    }

    public abstract function getLogContentAndInsertToDatabase();

    public function execute(): string
    {
        $this->getLogContentAndInsertToDatabase();
        return $this->getResultMessage();
    }
}
