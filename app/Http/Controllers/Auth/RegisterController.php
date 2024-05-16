<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\ApiRequest;

class RegisterController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    function register()
    {
        $customers = [];
        $error = '';        
        
        return view('account.register', compact('customers', 'error'));
    }

    function create(Request $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'cnpj_cpf' => $request->cnpj_cpf,
            'rg_ie' => $request->rg_ie,
            'type_person' => $request->type_person == 1 ? 'fisica' : 'juridica',
            'sex' => $request->sex,
            'password' => $request->password,
            'confirmPassword' => $request->confirmPassword,
        ];

        $response = $this->apiRequest->sendRequest('post', 'account/addCustomer', $data);

        if ($response->successful()) {
            return redirect()->route('account')->with('success', $response->json()['message'] ?? 'Cliente cadastrado com sucesso.');
        } else {
            $errorMessage = $response->json()['message'] ?? 'Erro desconhecido ao criar cliente.';
            return redirect()->route('register')->with('error', $errorMessage);
        }
    }
}
