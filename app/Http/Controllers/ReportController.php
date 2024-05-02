<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function getReportCustomer(Request $request)
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $error = '';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'account/getCustomers');

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

        $filteredCustomers = $this->applyFiltersCustomer($customers, $request->all());

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $customersForPage = array_slice($filteredCustomers, $startIndex, $perPage);
        $total = count($filteredCustomers);
        $paginator = new LengthAwarePaginator(
            $customersForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('reports.customer')]
        );

        return view('reports.customer', compact('paginator', 'error'));
    }

    private function applyFiltersCustomer($customers, $filters)
    {
        $filteredCustomers = [];
    
        foreach ($customers as $customer) {
            if (isset($filters['name']) && stripos($customer['name'], $filters['name']) === false) {
                continue;
            }
            if (isset($filters['email']) && stripos($customer['email'], $filters['email']) === false) {
                continue;
            }
            if (isset($filters['phone_number']) && stripos($customer['phone_number'], $filters['phone_number']) === false) {
                continue;
            }
            if (isset($filters['cnpj_cpf']) && stripos($customer['cnpj_cpf'], $filters['cnpj_cpf']) === false) {
                continue;
            }
    
            $filteredCustomers[] = $customer;
        }
        
        return $filteredCustomers;
    }

    public function getReportProduct(Request $request)
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $error = '';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getProducts');

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['products'])) {
                $products = $apiData['message']['products'];
            } else {
                $products = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produtos.';
        }

        $filteredProducts = $this->applyFiltersProduct($products, $request->all());

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $productsForPage = array_slice($filteredProducts, $startIndex, $perPage);
        $total = count($filteredProducts);
        $paginator = new LengthAwarePaginator(
            $productsForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('reports.customer')]
        );

        return view('reports.product', compact('paginator', 'error'));
    }

    private function applyFiltersProduct($products, $filters)
    {
        $filteredProducts = [];
    
        foreach ($products as $product) {
            if (isset($filters['name']) && stripos($product['name'], $filters['name']) === false) {
                continue;
            }
            if (isset($filters['price']) && stripos($product['price'], $filters['price']) === false) {
                continue;
            }
            if (isset($filters['sku']) && stripos($product['sku'], $filters['sku']) === false) {
                continue;
            }
            if (isset($filters['description']) && stripos($product['description'], $filters['description']) === false) {
                continue;
            }
    
            $filteredProducts[] = $product;
        }
        
        return $filteredProducts;
    }
}
