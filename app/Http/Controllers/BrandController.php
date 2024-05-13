<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Utils\ApiRequest;

class BrandController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function show($id)
    {
        $response = $this->apiRequest->sendRequest('get', 'product/getProductsBrand', [], ['id' => $id]);

        $message = $response->json()['message'] ?? null;

        if ($message && isset($message['products'])) {
            $products = $message['products']['products'];
            $brand_name = $message['products']['brand_name'];
        } else {
            $products = [];
            $brand_name = 'Produtos';
        }

        return view('brand', ['products' => $products, 'brand_name' => $brand_name]);
    }

}
