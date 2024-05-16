<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\ApiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $response = $this->apiRequest->sendRequest('post', 'account/login', $data);

        if ($response->successful()) {
            $apiData = $response->json();
        
            if (isset($apiData['message']['token'])) {
                $token = $apiData['message']['token'];
                $customer_id = $apiData['message']['customer_id'];

                session(['api_token' => $token]);
                session(['customer_id' => $customer_id]);
        
                return redirect()->intended('/account');
            }
        } else {
            $errorMessage = $response->json() ?? 'Erro desconhecido ao tentar fazer login. Por favor, tente novamente mais tarde.';
        
            return back()->withErrors([
                'email' => $errorMessage,   
            ]);
        }
    }

    public function logout(Request $request)
    {
        Session::forget('api_token');
        Auth::logout();
        return redirect()->route('login');
    }
}
