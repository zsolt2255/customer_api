<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseConnectionTest extends TestCase
{
    /**
     * @return void
     */
    public function testMaxConnections(): void
    {
        // GIVEN
        $maxConnections = DB::select(DB::raw("SELECT @@global.max_connections as max_connections"));
        $maxConnectionsValue = $maxConnections[0]->max_connections;
        $exceededConnections = 0;
        $connections = [];

        // WHEN
        for ($i = 1; $i <= $maxConnectionsValue; $i++) {
            try {
                $connections[] = DB::connection('mysql')->getPdo();
                DB::disconnect('mysql');
                User::all();
                $exceededConnections++;
            } catch (\Exception $exception) {
                $this->fail("Max connections test failed: {$exception->getMessage()}");
            }
        }

        // THEN
        $this->assertArrayHasKey(0, $connections);
        $this->assertInstanceOf('PDO', $connections[0]);
        $this->assertTrue(true);
        $this->assertEquals($maxConnectionsValue, $exceededConnections);
    }

    /**
     * @return void
     */
    public function testMaxConnectionsFailed(): void
    {
        // GIVEN
        $maxConnections = DB::select(DB::raw("SELECT @@global.max_connections as max_connections"));
        $maxConnectionsValue = $maxConnections[0]->max_connections;
        $maxConnectionsValue += 10;
        $exceededConnections = 0;
        $connections = [];

        // WHEN
        for ($i = 1; $i <= $maxConnectionsValue; $i++) {
            try {
                $connections[] = DB::connection('mysql')->getPdo();
                DB::disconnect('mysql');
                User::all();
                $exceededConnections++;
            } catch (\Exception $exception) {
                // $this->fail("Max connections test failed: {$exception->getMessage()}");
            }
        }

        // THEN
        $this->assertArrayHasKey(0, $connections);
        $this->assertInstanceOf('PDO', $connections[0]);
        $this->assertTrue(true);
        $this->assertNotEquals($maxConnectionsValue, $exceededConnections);
    }
}
