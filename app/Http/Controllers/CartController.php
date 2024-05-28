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

    public function removeToCart(Request $request)
    {
        $data = [
            'id' => $request->input('id'),
            'product_id' => $request->input('product_id'),
            'attribute_id' => $request->input('attribute_id'),
            'session_id' => session()->getId()
        ];

        $response = $this->apiRequest->sendRequest('post', 'checkout/removeToCart', $data);

        if ($response->successful()) {
            return redirect('/cart')->with('success', 'Produto excluido do carrinho com sucesso');
        } else {
            $response->json()['message'] ?? 'Erro desconhecido ao excluir o produto do carrinho.';
        }
    }

    public function updateToCart(Request $request)
    {        
        $quantity = $request->input('quantity');
        $quantityCurrent = $request->input('quantityCurrent');

        echo session()->getId();

        if($quantity >= $quantityCurrent){
            $operation = 'subtract';
        } else {
            $operation = 'add';
        }

        $data = [
            'id' => $request->input('id'),
            'product_id' => $request->input('product_id'),
            'attribute_id' => $request->input('attribute_id'),
            'quantity' => $quantity,
            'operation' => $operation,
            'session_id' => session()->getId()
        ];

        $response = $this->apiRequest->sendRequest('post', 'checkout/updateQuantityToCart', $data);

        if ($response->successful()) {
            return redirect('/cart')->with('success', 'Quantidade atualizada com sucesso');
        } else {
            return response()->json(['error' => $response->body()], $response->status());
        }
    }
}
