<?php

namespace App\Actions\Pipelines;

use App\DataTransferObjects\DomainDTO;
use Closure;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class  DomainDatabasePipe
{
    public function handle($content, Closure $next)
    {
        $domainData = $content['domainData'];
        $messages = $content['messages'];

        try {




            $this->createDatabase($domainData);
            $messages[] = 'Database created successfully.';
            $this->createDatabaseUser($domainData);
            $messages[] = "User '{$domainData->db_username}'@localhost created and granted access to '{$domainData->db_database}' database.";
            $this->createDatabaseConfig($domainData);

            $messages[] = 'Domain ' . ucfirst($domainData->domain) . ' registered successfully.';
        } catch (\Exception $exception) {
            $messages[] = 'ERROR: ' . $exception->getMessage();
            $content['status'] = 500;
        }

        $content['messages'] = $messages;

        return $next($content);
    }

    private function createDatabaseConfig(DomainDTO $domainData): void
    {
        config('database.connections.mysql.database' , $domainData->db_database);
        config('database.connections.mysql.username' , $domainData->db_username);
        config('database.connections.mysql.password' , $domainData->db_password);
        config('database.connections.'.$domainData->domain,[
            ...config('database.connections.mysql'),
            'database' => $domainData->db_database,
            'username' => $domainData->db_username,
            'password' => $domainData->db_password
        ]);
    }

    private function createDatabaseUser(DomainDTO $domainData): void
    {
        DB::statement("CREATE USER IF NOT EXISTS '{$domainData->db_username}'@'localhost' IDENTIFIED BY '{$domainData->db_password}'");
        DB::statement("GRANT ALL ON {$domainData->db_database}.* TO '{$domainData->db_username}'@'localhost'");
    }

    private function createDatabase(DomainDTO $domainData): void
    {
        DB::statement("CREATE DATABASE IF NOT EXISTS {$domainData->db_database}");
    }

    public function migrateDatabase(): void
    {
        Artisan::call('migrate:fresh');
    }
}

