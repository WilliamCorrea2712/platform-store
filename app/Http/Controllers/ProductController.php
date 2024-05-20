<?php

namespace App\Http\Controllers;

use App\Utils\ApiRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function show($id)
    {
        $response = $this->apiRequest->sendRequest('get', 'product/getProducts', [], ['id' => $id]);

        $message = $response->json()['message'] ?? null;

        if ($message && isset($message['products'])) {
            $product = $message['products'][0];
        } else {
            $product = null;
        }

        return view('product', ['product' => $product]);
    }

    public function addToCart(Request $request)
    {
        if(session()->get('customer_id')){
            $customer_id = session()->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $data = [
            'product_id' => $request->input('product_id'),
            'id' => $request->input('id'),
            'attribute_id' => $request->input('attribute_id'),
            'quantity' => 1,
            'operation' => 'subtract',
            'customer_id' => $customer_id
        ];

        $response = $this->apiRequest->sendRequest('post', 'checkout/addCart', $data);

        if ($response->successful()) {
            return redirect('/cart')->with('success', 'Produto adicionado ao carrinho com sucesso');
        } else {
            $errorMessage = $response->json()['message'] ?? 'Erro desconhecido ao criar cliente.';
            return response()->json(['error' => $errorMessage], $response->status());
        }
    }
}
