<?php

namespace App\Console\Commands\Helpers;

use App\Models\Repositories\Log;

class ReadLogInterfaceFromFile extends ReadLog
{
    public function getLogContentAndInsertToDatabase()
    {
        $content = fopen(\Storage:: disk('local')->path('logs/' . $this->getLog()), 'r');
        while (!feof($content)) {
            $line = trim(fgets($content));
            $splitLine = preg_split('/\s+/', $line);
            if (count($splitLine) == 7) {
                $insertedLog = Log::insertNewLog($this->prepareInputData($splitLine));
                if ($insertedLog) {
                    $this->incrementInsertedRowCount();
                }
            }
        }
        fclose($content);
    }
}
