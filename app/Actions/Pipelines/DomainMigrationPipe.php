<?php

namespace App\Actions\Pipelines;

use App\DataTransferObjects\DomainDTO;
use Closure;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DomainMigrationPipe
{
    public function handle($content, Closure $next)
    {
        $messages = $content['messages'];
        try {
            $this->migrateDatabase();
            $messages[] = 'Database migrate successfully.';
        } catch (\Exception $exception) {
            $messages[] = 'ERROR: ' . $exception->getMessage();
            $content['status'] = 500;
        }

        $content['messages'] = $messages;

        return $next($content);
    }

    private function migrateDatabase(): void
    {
        Artisan::call('migrate');
    }
}

