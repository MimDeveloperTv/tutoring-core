<?php

namespace App\Actions;

namespace App\Actions;

use App\Actions\Pipelines\DomainDatabasePipe;
use App\Actions\Pipelines\DomainEnvironmentPipe;
use App\Actions\Pipelines\DomainMigrationPipe;
use App\DataTransferObjects\DomainDTO;
use Illuminate\Pipeline\Pipeline;

class MigrationDomainAction
{
    private array $messages = [];
    private int $status = 200;

    public function __construct()
    {
    }

    public function execute(): array
    {
        $content = [
            'messages' => $this->messages,
            'status' => $this->status,
        ];

        $content = app(Pipeline::class)
            ->send($content)
            ->through([
                DomainMigrationPipe::class,
            ])
            ->thenReturn();

        return [
            'messages' => $content['messages'],
            'status' => $content['status'],
        ];
    }
}
