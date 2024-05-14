<?php

namespace App\Http\Controllers;

use App\Utils\ApiRequest;

class CategoryController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function show($id)
    {
        $response = $this->apiRequest->sendRequest('get', 'product/getProductsCategory', [], ['id' => $id]);

        $message = $response->json()['message'] ?? null;

        if ($message && isset($message['products'])) {
            $products = $message['products']['products'];
            $category_name = $message['products']['category_name'];
        } else {
            $products = [];
            $category_name = 'Produtos';
        }

        return view('category', ['products' => $products, 'category_name' => $category_name]);
    }

}
