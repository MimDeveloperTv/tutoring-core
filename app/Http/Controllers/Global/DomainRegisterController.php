<?php

namespace App\Http\Controllers\Global;

use App\Actions\MigrationDomainAction;
use App\Actions\RegisterDomainAction;
use App\DataTransferObjects\DomainDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DomainRegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $requestData = $request->only([
            'domain',
            'app_name',
            'db_database',
            'db_username',
            'db_password',
            'api_key',
        ]);

        $domainDTO = new DomainDTO(...$requestData);
        $domain = (new RegisterDomainAction($domainDTO))->execute();

        return response()->json([
            'messages' => $domain['messages']
        ], $domain['status']);
    }

    public function migrate()
    {

        $domain = (new MigrationDomainAction())->execute();
        return response()->json([
            'messages' => $domain['messages']
        ], $domain['status']);
    }
}
