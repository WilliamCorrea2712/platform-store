<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            $data = $message['products'];
        } else {
            $data = [];
        }

        $category_name = 'Nome da Categoria';

        return view('category', ['products' => $data, 'category_name' => $category_name]);
    }

}
