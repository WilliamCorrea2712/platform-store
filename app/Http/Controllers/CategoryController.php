<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Helpers\HelperController;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getCategories');

        $categories = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['categories'])) {
                $categories = $apiData['message']['categories'];
            } else {
                $categories = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar categorias.';
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $categoriesForPage = array_slice($categories, $startIndex, $perPage);
        $total = count($categories);
        $paginator = new LengthAwarePaginator(
            $categoriesForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('getCategories')]
        );

        return view('product.categories', compact('paginator', 'error'));
    }

    public function create()
    {
        $helperController = new HelperController();
        $categories = $helperController->getAllCategories();

        $error = '';

        return view('product.categoriesCreate', compact('categories', 'error'));  
    }


    public function storeCategory(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'product/addCategory', [
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'sort_order' => $request->input('sort_order'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'meta_description' => $request->input('meta_description'),
            'meta_title' => $request->input('meta_title'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);

        if ($response->successful()) {
            return redirect()->route('getCategories')->with('success', $response->json()['message'] ?? 'Categoria criada com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar categoria.';
            return redirect()->route('createCategory')->with('error', $errorMessage);
        }
    }

    public function edit($id){
        $apiUrl = config('api.url');
        $apiToken = config('api.token');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getCategories&id=' . $id);
    
        $categories = [];
        $categoriesFather = [];
        $error = '';
    
        if ($response->successful()) {
            $apiData = $response->json();
    
            if (isset($apiData['message']['categories'])) {
                $categories = $apiData['message']['categories'];

                $helperController = new HelperController();
                $categoriesFather = $helperController->getAllCategories();
            } else {
                $categories = [];
                $categoriesFather = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar categoria.';
        }

        return view('product.categoryEdit', compact('categories', 'categoriesFather', 'error'));  
    }
    
    public function update(Request $request, $id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'product/editCategory', [
            'category_id' => $id,
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'sort_order' => $request->input('sort_order'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'meta_description' => $request->input('meta_description'),
            'meta_title' => $request->input('meta_title'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);

        if ($response->successful()) {
            return redirect()->route('editCategory', ['id' => $id])->with('success', $response->json()['message'] ?? 'Categoria atualizada com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro ao atualizar categoria.';
            return redirect()->route('editCategory', ['id' => $id])->with(['error' => $errorMessage, 'categories' => 
            [['id' => $id, 'name' => $request->name, 'parent_id' => $request->parent_id, 'sort_order' => $request->sort_order, 
            'status' => $request->status, 'description' => $request->description, 'meta_description' => $request->meta_description, 
            'meta_title' => $request->meta_title, 'meta_keyword' => $request->meta_keyword]]]);
        }
    }

    public function deleteCategory(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('category_id');
        $errors = []; 

        $responseCategory = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'product/deleteCategory', [
            'category_id' => $id,
        ]);

        if (!$responseCategory->successful()) {
            $errorResponse = $responseCategory->json();
            if (isset($errorResponse['error'])) {
                $errors[] = $errorResponse['error'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir o Categoria.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('editCategory', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return response()->json(['success' => true]);            
        }        
    }
}
