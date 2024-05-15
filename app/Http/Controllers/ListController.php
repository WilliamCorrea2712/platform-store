<?php

namespace App\Http\Controllers;

use App\Utils\ApiRequest;

class ListController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function show($id)
    {
        $response = $this->apiRequest->sendRequest('get', 'product/getAllProductLists', [], ['id' => $id]);

        if ($response->successful()) {
            $data = $response->json();
        
            if (isset($data['message']['product_lists'])) {
                $productsList = $data['message']['product_lists'];
        
                foreach ($productsList as $products) {
                    $productsList = json_decode($products['products']);
                    $nameList = $products['name'];
                }
            } else {
                $error = 'Erro desconhecido ao tentar recuperar produtos.';
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produtos.';
        }

        $products = []; 
        $error = '';

        if($productsList){
            $response = $this->apiRequest->sendRequest('get', 'product/getProducts', [], ['id' => $productsList] );
            
            if ($response->successful()) {
                $apiData = $response->json();

                if (isset($apiData['message']['products'])) {
                    $products = $apiData['message']['products'];
                } else {
                    $error = 'Erro desconhecido ao tentar recuperar produtos.';
                }
            } else {
                $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produtos.';
            }
        } else {
            $error = "Não há produtos nesta lista!";
        }

        return view('list', ['products' => $products, 'nameList' => $nameList, 'error' => $error]);
    }
}
