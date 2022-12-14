<?php

namespace App\Console\Commands\Helpers;

use App\Models\Repositories\Log;

class ReadLogInterfaceFromUrl extends ReadLog
{
    public function getLogContentAndInsertToDatabase()
    {
        $response = \Http::get($this->getLog());
        if ($response->status() != 200) {
            foreach ($response->json()['data'] as $errorsKey => $errorsValue) {
                if (is_array($errorsValue)) {
                    foreach ($errorsValue as $value) {
                        $this->setError($value);
                    }
                }
            }
        } else {
            $responseJson = $response->json();
            $count = $responseJson['count'];
            if ($count > 0) {
                foreach ($responseJson['logs'] as $singleResponse) {
                    $insertedLog = Log::insertNewLog([
                        'serviceName' => $singleResponse['serviceName'],
                        'statusCode' => $singleResponse['statusCode'],
                        'startDate' => $singleResponse['startDate'],
                        'endDate' => $singleResponse['endDate'],
                    ]);
                    if ($insertedLog) {
                        $this->incrementInsertedRowCount();
                    }
                }
            }
        }
    }
}
