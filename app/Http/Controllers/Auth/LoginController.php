<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'user/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $apiData = $response->json();
        
            if (isset($apiData['message']['token'])) {
                $token = $apiData['message']['token'];

                session(['api_token' => $token]);
        
                return redirect()->intended('/dashboard');
            }
        } else {
            $responseData = $response->json();
            $errorMessage = $responseData['error'] ?? 'Erro desconhecido ao tentar fazer login. Por favor, tente novamente mais tarde.';
        
            return back()->withErrors([
                'email' => $errorMessage,   
            ]);
        }
    }
}
