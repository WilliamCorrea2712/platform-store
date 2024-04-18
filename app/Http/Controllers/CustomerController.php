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

        return view('account.customers', compact('paginator', 'error'));
    }

    public function create()
    {  
        $customers = [];
        $error = '';

        return view('account.customersCreate', compact('customers', 'error')); 
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
            'password' => $request->password,
            'confirmPassword' => $request->confirmPassword,
        ]);

        if ($response->successful()) {
            return redirect()->route('getCustomer')->with('success', $response->json()['message'] ?? 'Cliente cadastrado com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar cliente.';
            return redirect()->route('createCustomer')->with('error', $errorMessage);
        }
    }

    public function edit($id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'account/getCustomers&id=' . $id);

        $customer = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['customers'][$id])) {
                $customer = $apiData['message']['customers'][$id];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar o cliente.';
        }

        return view('account.customerEdit', compact('customer', 'error'));
    }

    public function update(Request $request, $id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $responseCustomer = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'account/editCustomer', [
            'customer_id' => $id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'cnpj_cpf' => $request->cnpj_cpf,
            'rg_ie' => $request->rg_ie,
            'type_person' => $request->type_person == 1 ? 'fisica' : 'juridica',
            'sex' => $request->sex,
            'password' => $request->password,
            'confirmPassword' => $request->confirmPassword,
        ]);

        if (isset($responseCustomer->json()['error'])) {
            return redirect()->route('editCustomer', ['id' => $id])->with(['errors' => $responseCustomer->json()['error']]);
        }

        $errors = [];

        foreach ($request->input('street') as $key => $street) {
            $addressId = $request->input('address_id')[$key];
            $responseAddress = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Accept' => 'application/json',
            ])->patch($apiUrl . 'account/editAddress', [
                'address_id' => $addressId,
                'street' => $street,
                'city' => $request->input('city')[$key],
                'state' => $request->input('state')[$key],
                'zip_code' => $request->input('zip_code')[$key],
                'name' => $request->input('nameAddress')[$key],
                'number' => $request->input('number')[$key],
                'country' => $request->input('country')[$key],
            ]);
            
            if (!$responseAddress->successful()) {
                $errors[] = $responseAddress['error'];
            }
        }
        
        if (!empty($errors)) {
            return redirect()->route('editCustomer', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return redirect()->route('editCustomer', ['id' => $id])->with('success', 'Cliente atualizado com sucesso!');
        }
    }    
}
