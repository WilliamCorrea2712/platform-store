<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandController extends Controller
{
    public function getBrand()
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getBrands');

        $brands = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['brands'])) {
                $brands = $apiData['message']['brands'];
            } else {
                $brands = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar marcas.';
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $brandsForPage = array_slice($brands, $startIndex, $perPage);
        $total = count($brands);
        $paginator = new LengthAwarePaginator(
            $brandsForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('getBrand')]
        );

        return view('product.brands', compact('paginator', 'error'));
    }

    public function create()
    {  
        $brands = [];
        $error = '';

        return view('product.brandsCreate', compact('brands', 'error')); 
    }

    public function storeBrand(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'product/addBrand', [
            'name' => $request->input('name'),
            'sort_order' => $request->input('sort_order'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'meta_description' => $request->input('meta_description'),
            'meta_title' => $request->input('meta_title'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);

        if ($response->successful()) {
            return redirect()->route('getBrand')->with('success', $response->json()['message'] ?? 'Marca criada com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar marca.';
            return redirect()->route('createBrand')->with('error', $errorMessage);
        }
    }

    public function edit($id){
        $apiUrl = config('api.url');
        $apiToken = config('api.token');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'product/getBrands&id=' . $id);
    
        $brands = [];
        $error = '';
    
        if ($response->successful()) {
            $apiData = $response->json();
    
            if (isset($apiData['message']['brands'])) {
                $brands = $apiData['message']['brands'];
            } else {
                $brands = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar marca.';
        }

        return view('product.brandEdit', compact('brands', 'error'));  
    }    

    public function update(Request $request, $id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'product/editBrand', [
            'brand_id' => $id,
            'name' => $request->input('name'),
            'sort_order' => $request->input('sort_order'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'meta_description' => $request->input('meta_description'),
            'meta_title' => $request->input('meta_title'),
            'meta_keyword' => $request->input('meta_keyword'),
        ]);

        if ($response->successful()) {
            return redirect()->route('editBrand', ['id' => $id])->with('success', $response->json()['message'] ?? 'Marca atualizada com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro ao atualizar marca.';
            return redirect()->route('editBrand', ['id' => $id])->with(['error' => $errorMessage, 'brands' => 
            [['id' => $id, 'name' => $request->name, 'sort_order' => $request->sort_order, 
            'status' => $request->status, 'description' => $request->description, 'meta_description' => $request->meta_description, 
            'meta_title' => $request->meta_title, 'meta_keyword' => $request->meta_keyword]]]);
        }
    }

    public function deleteBrand(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('brand_id');
        $errors = []; 

        $responseBrand = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'product/deleteBrand', [
            'brand_id' => $id,
        ]);

        if (!$responseBrand->successful()) {
            $errorResponse = $responseBrand->json();
            if (isset($errorResponse['error'])) {
                $errors[] = $errorResponse['error'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir o Marca.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('editBrand', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return response()->json(['success' => true]);            
        }        
    }
}
