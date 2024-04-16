<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function edit()
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'user/getUsers');

        $users = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['users'])) {
                $users = $apiData['message']['users'];
            } else {
                $users = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar usuários.';
        }

        return view('users', compact('users', 'error'));    
    }
}
