<?php

namespace App\Console\Commands\Helpers;

use Illuminate\Support\Facades\Validator;

class PrepareLog
{
    private string $log;

    public function __construct($log)
    {
        $this->log = $log;
    }

    public function getLogType()
    {
        if ((str_contains($this->log, 'www')) || str_contains($this->log, 'http')) {
            $urlValidator = Validator::make(['log' => $this->log], ['log' => 'url']);
            if (count($urlValidator->errors()->messages())) {
                return [
                    'error' => true,
                    'text' => $urlValidator->errors()->messages()['log'][0]
                ];
            }
            return [
                'error' => false,
                'text' => 'URL'
            ];
        } else {
            $isExistLogFile = \Storage:: disk('local')->exists('logs/' . $this->log);
            if (!$isExistLogFile) {
                return [
                    'error' => true,
                    'text' => 'log file is not exist'
                ];
            }
            return [
                'error' => false,
                'text' => 'FILE'
            ];
        }
    }

    public function execute()
    {
        $getLogType = $this->getLogType();
        if ($getLogType['error']) {
            return $getLogType['text'];
        }
        if ($getLogType['text'] == 'FILE') {
            $getLog = new ReadLogInterfaceFromFile($this->log);
        } elseif ($getLogType['text'] == 'URL') {
            $getLog = new ReadLogInterfaceFromUrl($this->log);
        }
        return $getLog->execute();
    }
}
