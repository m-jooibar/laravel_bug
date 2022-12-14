<?php

namespace App\Models\Repositories;

class Log
{

    public static function insertNewLog($data)
    {
        return \App\Models\log::create($data);
    }

    public static function getLog(array $conditions)
    {
        return \App\Models\log::where($conditions)->get()->toArray();
    }
}
