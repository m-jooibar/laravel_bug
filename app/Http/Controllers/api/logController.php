<?php

namespace App\Http\Controllers\api;

use App\Helpers\LogFilter;
use App\Http\Controllers\Controller;
use App\Models\Repositories\Log;
use Illuminate\Http\Request;

class logController extends Controller
{
    public function getLogs(Request $request): \Illuminate\Http\JsonResponse
    {
        $filters = (new LogFilter($request->all()))->filters();
        if ($filters['error']) {
            return response()->json($filters, 401);
        }

        $logs = Log::getLog($filters['data']);
        return response()->json(['count' => sizeof($logs), 'logs' => $logs], 200);
    }
}
