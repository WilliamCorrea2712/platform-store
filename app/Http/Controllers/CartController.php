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
        $session_id = session()->getId();

        if(session()->get('customer_id')){
            $customer_id = session()->get('customer_id');
        } else {
            $customer_id = null;
        }

        $response = $this->apiRequest->sendRequest('get', 'checkout/getProductsCart', [], [
            'customer_id' => $customer_id, 
            'session_id' => $session_id
        ]);

        $products = [];

        if ($response->successful()) {
            $data = $response->json();
            $products = $data['message'] ?? [];
        } else {
            $response->json()['message'] ?? 'Erro desconhecido ao obter produtos do carrinho.';
        }

        return view('checkout.cart', ['products' => $products]);
    }
}
