<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $apiUrlProducts = config('api.url') . 'product/getProducts';
        $apiUrlCustomers = config('api.url') . 'account/getCustomers';
        $apiToken = config('api.token');

        $responseProducts = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrlProducts);

        $products = [];
        $errorProducts = '';

        if ($responseProducts->successful()) {
            $apiDataProducts = $responseProducts->json();

            if (isset($apiDataProducts['message']['products'])) {
                $products = $apiDataProducts['message']['products'];
            }
        } else {
            $errorProducts = $responseProducts->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produtos.';
        }

        $responseCustomers = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrlCustomers);

        $customers = [];
        $errorCustomers = '';
        $sexM = 0;
        $sexF = 0;
        $personF = 0;
        $personJ = 0;
        $stateCustomers = [];

        if ($responseCustomers->successful()) {
            $apiDataCustomers = $responseCustomers->json();

            if (isset($apiDataCustomers['message']['customers'])) {
                $customers = $apiDataCustomers['message']['customers'];

                foreach ($customers as $customer) {
                    if ($customer['sex'] === 'M') {
                        $sexM++;
                    } else {
                        $sexF++;
                    }
                    if ($customer['type_person'] === 'fisica') {
                        $personF++;
                    } else {
                        $personJ++;
                    }

                    if (isset($customer['state'])) {
                        $state = $customer['state'];
                        $stateCustomers[$state] = isset($stateCustomers[$state]) ? $stateCustomers[$state] + 1 : 1;
                    }
                }
            }
        } else {
            $errorCustomers = $responseCustomers->json()['error'] ?? 'Erro desconhecido ao tentar recuperar clientes.';
        }

        $totalProducts = count($products);
        $metaProducts = 300;
        $percentAchieved = ($totalProducts / $metaProducts) * 100;

        return view('dashboard', compact('products', 'customers', 'percentAchieved', 'errorProducts', 'errorCustomers', 'stateCustomers', 'sexM', 'sexF', 'personF', 'personJ'));
    }
}
