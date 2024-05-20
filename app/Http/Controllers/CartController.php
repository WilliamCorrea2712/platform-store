<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ApiRequest;

class CartController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function showCart(Request $request)
    {
        $customer_id = session()->get('customer_id');

        $response = $this->apiRequest->sendRequest('get', 'checkout/getProductsCart', [], ['customer_id' => $customer_id]);

        $products = [];

        if ($response->successful()) {
            $data = $response->json();
            $products = $data['message'] ?? [];
        } else {
            $errorMessage = $response->json()['message'] ?? 'Erro desconhecido ao obter produtos do carrinho.';
            return response()->json(['error' => $errorMessage], $response->status());
        }

        return view('checkout.cart', ['products' => $products]);
    }
}
