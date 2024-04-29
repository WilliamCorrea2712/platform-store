<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HelperController extends Controller
{

    public function getAllProducts()
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getProducts');

        if ($response->successful()) {
            $data = $response->json()['message']['products'] ?? [];

            if (is_array($data)) {
                $formattedProducts = [];

                foreach ($data as $product) {
                    $formattedProducts[] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                    ];
                }

                return $formattedProducts;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function getAllCategories()
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getCategories');

        if ($response->successful()) {
            $data = $response->json()['message']['categories'] ?? [];

            if (is_array($data)) {
                $formattedCategories = [];

                foreach ($data as $category) {
                    $formattedCategories[] = [
                        'id' => $category['id'],
                        'name' => $category['name'],
                    ];
                }

                return $formattedCategories;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function getAllBrands()
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getBrands');

        if ($response->successful()) {
            $data = $response->json()['message']['brands'] ?? [];

            if (is_array($data)) {
                $formattedBrands = [];

                foreach ($data as $brand) {
                    $formattedBrands[] = [
                        'id' => $brand['id'],
                        'name' => $brand['name'],
                    ];
                }

                return $formattedBrands;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}
