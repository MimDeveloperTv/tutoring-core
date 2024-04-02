<?php

namespace App\Actions;

namespace App\Actions;

use App\Actions\Pipelines\DomainDatabasePipe;
use App\Actions\Pipelines\DomainEnvironmentPipe;
use App\DataTransferObjects\DomainDTO;
use Illuminate\Pipeline\Pipeline;

class RegisterDomainAction
{
    private array $messages = [];
    private int $status = 200;

    public function __construct(
        public readonly DomainDTO $domainData,
        public readonly string    $domainPath = 'domains/',
        public readonly string    $baseEnvFileName = '/.env',
    )
    {
    }

    public function execute(): array
    {
        $content = [
            'domainData' => $this->domainData,
            'domainPath' => $this->domainPath,
            'baseEnvFileName' => $this->baseEnvFileName,
            'messages' => $this->messages,
            'status' => $this->status,
        ];

        $content = app(Pipeline::class)
            ->send($content)
            ->through([
                DomainEnvironmentPipe::class,
                DomainDatabasePipe::class,
            ])
            ->thenReturn();

        return [
            'messages' => $content['messages'],
            'status' => $content['status'],
        ];
    }
}
