<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerController extends Controller
{
    public function getCustomers()
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'account/getCustomers');

        $customers = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['customers'])) {
                $customers = $apiData['message']['customers'];
            } else {
                $customers = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar clientes.';
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $customersForPage = array_slice($customers, $startIndex, $perPage);
        $total = count($customers);
        $paginator = new LengthAwarePaginator(
            $customersForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('getCustomer')]
        );

        return view('customers', compact('paginator', 'error'));
    }

    public function create()
    {  
        $customers = [];
        $error = '';

        return view('customersCreate', compact('customers', 'error')); 
    }

    public function storeCustomer(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'account/addCustomer', [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'cnpj_cpf' => $request->cnpj_cpf,
            'rg_ie' => $request->rg_ie,
            'type_person' => $request->type_person == 1 ? 'fisica' : 'juridica',
            'sex' => $request->sex,
        ]);

        if ($response->successful()) {
            return redirect()->route('getCustomer')->with('success', $response->json()['message'] ?? 'Cliente cadastrado com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar cliente.';
            return redirect()->route('createCustomer')->with('error', $errorMessage);
        }
    }
}
