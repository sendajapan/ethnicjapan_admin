<?php

namespace App\Services;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RZDatabaseService
{
    private static ?RZDatabaseService $instance = null;
    private Connection $connection;

    private function __construct()
    {
        $this->connection = DB::connection($this->createConnection());
    }

    public static function getInstance(): RZDatabaseService
    {
        if (self::$instance === null) {
            self::$instance = new RZDatabaseService();
        }

        return self::$instance;
    }

    private function createConnection(): string
    {
        config(['database.connections.karmen_db' => [
            'driver' => 'mysql',
            'host' => 'senda.us',
            'port' => '3306',
            'database' => 'karmen_24sep',
            'username' => 'sendajapan1',
            'password' => 'sulaiman007',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]]);

        return 'karmen_db';
    }

    public function getDataFromTable($tableName, $conditions = []): Collection
    {
        $query = $this->connection->table($tableName);

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->get();
    }

    public function runCustomQuery(string $query, array $bindings = []): Collection
    {
        return collect($this->connection->select($query, $bindings));
    }
}
