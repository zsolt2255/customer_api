<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DatabaseConnection
{
    /**
     * @param $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $maxConnections = DB::select(DB::raw("SELECT @@global.max_connections as max_connections"));
        $maxConnectionsValue = $maxConnections[0]->max_connections;

        if ($this->getCurrentConnections() >= $maxConnectionsValue) {
            return response()->json([
                'success' => false,
                'message' => 'Max connections exceeded',
            ], 503);
        }

        return $next($request);
    }

    /**
     * @return mixed
     */
    protected function getCurrentConnections(): mixed
    {
        $pdo = DB::connection('mysql')->getPdo();
        $query = "SHOW STATUS WHERE Variable_name = 'Threads_connected'";
        $result = $pdo->query($query)->fetch(\PDO::FETCH_ASSOC);

        return $result['Value'];
    }
}
