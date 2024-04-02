<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function getConnection()
    {
                return response()->json([
                    'connection' => [
                        'host' => config('database.connections.collections.host'),
                        'port' => config('database.connections.collections.port'),
                        'database' => config('database.connections.collections.database'),
                        'username' => config('database.connections.collections.username'),
                        'password' => config('database.connections.collections.password'),
                    ]
                ]);
    }
}
