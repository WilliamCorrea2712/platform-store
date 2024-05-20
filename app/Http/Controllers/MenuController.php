<?php
namespace App\Http\Controllers;

use App\Utils\ApiRequest;

class MenuController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }
    
    public function index()
    {
        $response = $this->apiRequest->sendRequest('get', 'product/getCategories');

        $categories = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();
            
            if (isset($apiData['message']['categories'])) {
                $categories = $apiData['message']['categories'];
            } else {
                $error = 'Nenhuma categoria encontrada!';
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar categorias.';
        }

        return view('includes.menu', compact('categories', 'error'));
    }

    public function getSubcategories($id)
    {
        $response = $this->apiRequest->sendRequest('get', 'product/getCategories', [], ['parent_id' => $id]);

        if ($response->successful()) {
            $apiData = $response->json();
            if (isset($apiData['message']['categories'])) {
                $subCategories = $apiData['message']['categories'];
                $error = '';
            } else {
                $error = 'Nenhuma subcategoria encontrada.';
                $subCategories = [];
            }
        } else {
            $error = $response->json()['message'] ?? 'Erro desconhecido ao tentar recuperar subcategorias.';
            $subCategories = [];
        }

        return response()->json(['subcategories' => $subCategories, 'error' => $error]);
    }
}
