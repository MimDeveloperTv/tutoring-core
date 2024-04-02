<?php

namespace App\Actions\Pipelines;

use App\DataTransferObjects\DomainDTO;
use Closure;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class DomainEnvironmentPipe
{
    public function handle($content, Closure $next)
    {
        $domainData = $content['domainData'];
        $domainPath = $content['domainPath'];
        $baseEnvFileName = $content['baseEnvFileName'];
        $messages = $content['messages'];

        try {
            $this->clearCaches();
            $this->createEnvFile($domainPath, $baseEnvFileName, $domainData->domain);
            $this->setDomainEnv($domainData, $domainPath);
            $messages[] = 'Environment file created successfully.';
        } catch (Exception $exception) {
            $messages[] = 'ERROR! Error when creating an environment file: ' . $exception->getMessage();
            $content['status'] = 500;
        }

        $content['messages'] = $messages;

        return $next($content);
    }

    private function clearCaches(): void
    {
        Artisan::call('optimize:clear');
    }

    private function createEnvFile($domainPath, $baseEnvFileName, $domain): void
    {
        $domainEnvPath = base_path($domainPath . '/.' . $domain);

        if (!File::isDirectory(dirname($domainEnvPath))) {
            File::makeDirectory(dirname($domainEnvPath), 0777, true, true);
        }

        File::copy(base_path($baseEnvFileName), $domainEnvPath);
    }

    private function setDomainEnv(DomainDTO $domainData, $domainPath): void
    {
        $domainEnvPath = base_path($domainPath . '/.' . $domainData->domain);

        $envData = collect(file($domainEnvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))
            ->map(function ($line) {
                [$key, $value] = explode("=", $line, 2);
                return [$key => $value];
            })
            ->filter()
            ->reduce(function ($carry, $item) {
                return array_merge($carry, $item);
            }, []);

        $envData = array_merge($envData, [
            'APP_NAME' => $domainData->app_name,
            'DB_DATABASE' => $domainData->db_database,
            'DB_USERNAME' => $domainData->db_username,
            'DB_PASSWORD' => $domainData->db_password,
            'IAM_API_KEY' => $domainData->api_key,
            'DB_CONNECTION' => 'collections'
        ]);

        $envContent = collect($envData)
            ->map(function ($value, $key) {
                return "$key=$value";
            })
            ->implode("\n");

        file_put_contents($domainEnvPath, $envContent);
    }
}
