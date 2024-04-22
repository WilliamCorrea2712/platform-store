<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Helpers\HelperController;

class ProductController extends Controller
{
    public function getProducts()
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getProducts');

        $products = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['products'])) {
                $products = $apiData['message']['products'];
            } else {
                $products = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produtos.';
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $productsForPage = array_slice($products, $startIndex, $perPage);
        $total = count($products);
        $paginator = new LengthAwarePaginator(
            $productsForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('getProducts')]
        );

        return view('product.products', compact('paginator', 'error'));
    }

    public function edit($id){
        $apiUrl = config('api.url');
        $apiToken = config('api.token');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getProducts&id=' . $id);
    
        $products = [];
        $categories = [];
        $brands = [];
        $error = '';
    
        if ($response->successful()) {
            $apiData = $response->json();
    
            if (isset($apiData['message']['products'])) {
                $products = $apiData['message']['products'];

                $helperController = new HelperController();
                $categories = $helperController->getAllCategories();
                $brands = $helperController->getAllBrands();
            } else {
                $categories = [];
                $brands = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar produto.';
        }

        return view('product.productsEdit', compact('products', 'categories', 'brands', 'error'));  
    }

    public function deleteProduct(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('product_id');
        $errors = []; 

        $responseProduct = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'user/deleteProduct', [
            'product_id' => $id,
        ]);

        if (!$responseProduct->successful()) {
            $errorResponse = $responseProduct->json();
            if (isset($errorResponse['error'])) {
                $errors[] = $errorResponse['error'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir o Produto.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('editProduct', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return response()->json(['success' => true]);            
        }        
    }

    public function deleteStock(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('stock_id');
        $product_id = $request->input('product_id');
        $attribute_id = $request->input('attribute_id');

        $errors = []; 

        $responseStock = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'product/deleteStockOptions', [
            'stock_id' => $id,
            'product_id' => $product_id,
            'attribute_id' => $attribute_id,
        ]);

        if (!$responseStock->successful()) {
            $errorResponse = $responseStock->json();
            if (isset($errorResponse['error'])) {
                $errors[] = $errorResponse['error'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir o Estoque.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('editProduct', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return response()->json(['success' => true]);            
        }        
    }
}
