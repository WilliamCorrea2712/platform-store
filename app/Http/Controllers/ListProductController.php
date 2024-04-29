<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Helpers\HelperController;

class ListProductController extends Controller
{
    public function getListProduct()
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getAllProductLists');

        $listProducts = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['product_lists'])) {
                $listProducts = $apiData['message']['product_lists'];
            } else {
                $listProducts = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar lista de produtos.';
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $ListProductsForPage = array_slice($listProducts, $startIndex, $perPage);
        $total = count($listProducts);
        $paginator = new LengthAwarePaginator(
            $ListProductsForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('getListProduct')]
        );

        return view('product.ListProducts', compact('paginator', 'error'));
    }

    public function create()
    {
        $helperController = new HelperController();
        $products = $helperController->getAllProducts();

        $error = '';

        return view('product.listProductsCreate', compact('products', 'error'));  
    }

    public function storeListProducts(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'product/addProductList', [
            'name' => $request->input('name')?$request->input('name'):'',
            'products' => $request->input('products')?$request->input('products'):'',
            'sort_order' => $request->input('sort_order')?$request->input('sort_order'):'',
            'status' => $request->input('status')?$request->input('status'):0,
        ]);

        if ($response->successful()) {
            return redirect()->route('getListProduct')->with('success', $response->json()['message'] ?? 'Lista de Produtos criada com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar lista de produtos.';
            return redirect()->route('createListProducts')->with('error', $errorMessage);
        }     
    }

    public function edit($id){
        $apiUrl = config('api.url');
        $apiToken = config('api.token');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getAllProductLists&id=' . $id);
    
        $listProducts = [];
        $products = [];
        $error = '';
    
        if ($response->successful()) {
            $apiData = $response->json();
    
            if (isset($apiData['message']['product_lists'])) {
                $listProducts = $apiData['message']['product_lists'];

                $helperController = new HelperController();
                $products = $helperController->getAllProducts();
            } else {
                $products = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar lista de produto.';
        }

        return view('product.listProductsEdit', compact('listProducts', 'products', 'error'));  
    }

    public function update(Request $request, $id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'product/editProductList', [
            'list_id' => $id,
            'name' => $request->input('name'),
            'products' => $request->input('products'),
            'sort_order' => $request->input('sort_order'),
            'status' => $request->input('status'),
        ]);

        if ($response->successful()) {
            return redirect()->route('editListProduct', ['id' => $id])->with('success', $response->json()['message'] ?? 'Lista de Produto atualizada com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro ao atualizar lista de produto.';
            return redirect()->route('editListProduct', ['id' => $id])->with(['error' => $errorMessage, 'listProducts' => 
            [['list_id' => $id, 'name' => $request->name, 'products' => $request->products, 'sort_order' => $request->sort_order, 
            'status' => $request->status]]]);
        }
    }

    public function deleteListProduct(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('list_id');
        $errors = []; 

        $responseListProduct = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'product/deleteProductList', [
            'list_id' => $id,
        ]);

        if (!$responseListProduct->successful()) {
            $errorResponse = $responseListProduct->json();
            if (isset($errorResponse['error'])) {
                $errors[] = $errorResponse['error'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir a Lista de Produtos.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('editListProduct', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return response()->json(['success' => true]);            
        }        
    }
}
