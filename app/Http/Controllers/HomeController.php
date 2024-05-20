<?php

namespace App\Http\Controllers;
use App\Utils\ApiRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function index(Request $request)
    {
        $bannerController = new BannerController();
        $banners = $bannerController->index();

        $productsList = array();
        $nameList = 'Produtos';

        $responseList = $this->apiRequest->sendRequest('get', 'product/getAllProductLists' );

        if ($responseList->successful()) {
            $data = $responseList->json();
        
            if (isset($data['message']['product_lists'])) {
                $productsList = $data['message']['product_lists'];
        
                foreach ($productsList as $products) {
                    if($products['name'] == 'Home'){
                        $productsList = json_decode($products['products']);
                        $nameList = $products['name'];
                    }
                }
            } else {
                $error = 'Erro desconhecido ao tentar recuperar produtos.';
            }
        } else {
            $error = $responseList->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produtos.';
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

        return view('home', compact('products', 'banners', 'nameList', 'error'));
    }
}
