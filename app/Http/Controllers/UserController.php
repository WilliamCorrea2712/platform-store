<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function getUsers()
    {
        $perPage = 8;
        $currentPage = request()->query('page', 1);

        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'user/getUsers');

        $users = [];
        $error = '';

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['users'])) {
                $users = $apiData['message']['users'];
            } else {
                $users = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar usuários.';
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $endIndex = $startIndex + $perPage;

        $usersForPage = array_slice($users, $startIndex, $perPage);
        $total = count($users);
        $paginator = new LengthAwarePaginator(
            $usersForPage,
            $total,
            $perPage,
            $currentPage,
            ['path' => route('getUser')]
        );

        return view('user.users', compact('paginator', 'error'));
    }

    public function create()
    {  
        $users = [];
        $error = '';

        return view('user.usersCreate', compact('users', 'error')); 
    }

    public function storeUser(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'user/addUser', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('getUser')->with('success', $response->json()['message'] ?? 'Usuário criado com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar usuário.';
            return redirect()->route('createUser')->with('error', $errorMessage);
        }
    }

    public function edit($id){
        $apiUrl = config('api.url');
        $apiToken = config('api.token');
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'user/getUsers&id=' . $id);
    
        $users = [];
        $error = '';
    
        if ($response->successful()) {
            $apiData = $response->json();
    
            if (isset($apiData['message']['users'])) {
                $users = $apiData['message']['users'];
            } else {
                $users = [];
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar usuários.';
        }
    
        return view('user.userEdit', compact('users', 'error'));  
    }
    

    public function update(Request $request, $id)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'user/editUser', [
            'id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('editUser', ['id' => $id])->with('success', $response->json()['message'] ?? 'Usuário atualizado com sucesso.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro ao atualizar usuário.';
            return redirect()->route('editUser', ['id' => $id])->with(['error' => $errorMessage, 'users' => [['id' => $id, 'name' => $request->name, 'email' => $request->email]]]);
        }
    }

    public function deleteUser(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('user_id');
        $errors = []; 

        $responseUser = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'user/deleteUser', [
            'user_id' => $id,
        ]);

        if (!$responseUser->successful()) {
            $errorResponse = $responseUser->json();
            if (isset($errorResponse['error'])) {
                $errors[] = $errorResponse['error'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir o Usuário.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('editUser', ['id' => $id])->with(['errors' => $errors]);
        } else {
            return response()->json(['success' => true]);            
        }        
    }
}
