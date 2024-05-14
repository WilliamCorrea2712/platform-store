<?php

namespace App\Http\Controllers;

use App\Utils\ApiRequest;

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

}
