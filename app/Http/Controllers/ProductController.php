<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Helpers\HelperController;
use Illuminate\Support\Facades\Log;
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

    public function update(Request $request, $id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'product/editProduct', [
            'product_id' => $id,
            'brand_id' => $request->input('brand_id'),
            'categories' => $request->input('category_id'),
            'price' => $request->input('price'),
            'cost_price' => $request->input('cost_price'),
            'weight' => $request->input('weight'),
            'length' => $request->input('length'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'sku' => $request->input('sku'),
            'minimum' => $request->input('minimum'),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'tags' => $request->input('tags'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),
            'description_resume' => $request->input('description_resume'),
        ]);

        if ($response->successful()) {
            return redirect()->route('editProduct', ['id' => $id])->with('success', $response->json()['message'] ?? 'Produto atualizado com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro ao atualizar produto.';
            return redirect()->route('editProduct', ['id' => $id])->with(['error' => $errorMessage, 'products' => 
            [['id' => $id, 'brand_id' => $request->brand_id, 'category_id' => $request->category_id, 'price' => $request->price, 
            'cost_price' => $request->cost_price, 'weight' => $request->weight, 'length' => $request->length, 
            'width' => $request->width, 'height' => $request->height, 'sku' => $request->sku, 'minimum' => $request->minimum, 
            'status' => $request->status, 'name' => $request->name, 'description' => $request->description, 
            'tags' => $request->tags, 'meta_title' => $request->meta_title, 'meta_description' => $request->meta_description, 
            'meta_keyword' => $request->meta_keyword, 'description_resume' => $request->description_resume]]]);
        }
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

    public function addStock(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $stockData = $request->input('stockData');
        $id = $request->input('productId');

        $responseStock = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'product/addStockOptions', $stockData);

        if ($responseStock->failed()) {
            return response()->json(['error' => $responseStock->body()], $responseStock->status());
        } else {
            return response()->json(['success' => true], 200);
        }     
    }
}
