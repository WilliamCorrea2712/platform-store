<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class BreadcrumbMiddleware
{
    public function handle($request, Closure $next)
    {
        $breadcrumbs = $this->generateBreadcrumbs(Route::currentRouteName());

        view()->share('breadcrumbs', $breadcrumbs);

        return $next($request);
    }

    private function generateBreadcrumbs($routeName)
    {
        $breadcrumbs = collect();
        $breadcrumbData = $this->getBreadcrumbData($routeName);

        if (!empty($breadcrumbData)) {
            $breadcrumbs->push(['label' => 'Home', 'route' => 'dashboard']);
            foreach ($breadcrumbData as $data) {
                if ($data['label'] && $data['route']) {
                    $params = $data['params'] ?? null;
                    if ($params && Route::current()->parameter('id')) {
                        $params = ['id' => Route::current()->parameter('id')];
                    }
                    $breadcrumbs->push(['label' => $data['label'], 'route' => $data['route'], 'params' => $params]);
                }
            }
        }

        return $breadcrumbs;
    }

    private function getBreadcrumbData($routeName)
    {
        $breadcrumbData = [
            'dashboard' => [
                ['label' => 'Dashboard', 'route' => 'dashboard']
            ],
            'contact' => [
                ['label' => 'Contato', 'route' => 'contact']
            ],
            'about' => [
                ['label' => 'Sobre', 'route' => 'about']
            ],
            'getProduct' => [
                ['label' => 'Produtos', 'route' => 'getProduct']
            ],
            'editProduct' => [
                ['label' => 'Produtos', 'route' => 'getProduct'],
                ['label' => 'Editar', 'route' => 'editProduct', 'params' => true]
            ],
            'getUser' => [
                ['label' => 'Usuários', 'route' => 'getUser']
            ],
            'editUser' => [
                ['label' => 'Usuários', 'route' => 'getUser'],
                ['label' => 'Editar', 'route' => 'editUser', 'params' => true]
            ],
            'createUser' => [
                ['label' => 'Usuários', 'route' => 'getUser'],
                ['label' => 'Cadastrar', 'route' => 'createUser']
            ],  
            'getCategory' => [
                ['label' => 'Categorias', 'route' => 'getCategory']
            ],
            'editCategory' => [
                ['label' => 'Categorias', 'route' => 'getCategory'],
                ['label' => 'Editar', 'route' => 'editCategory', 'params' => true]
            ],
            'createCategories' => [
                ['label' => 'Categorias', 'route' => 'getCategory'],
                ['label' => 'Cadastrar', 'route' => 'createCategories']
            ],            
            'getBrand' => [
                ['label' => 'Marcas', 'route' => 'getBrand']
            ],
            'editBrand' => [
                ['label' => 'Marcas', 'route' => 'getBrand'],
                ['label' => 'Editar', 'route' => 'editBrand', 'params' => true]
            ],
            'createBrands' => [
                ['label' => 'Marcas', 'route' => 'getBrand'],
                ['label' => 'Cadastrar', 'route' => 'createBrands']
            ], 
            'getCustomer' => [
                ['label' => 'Clientes', 'route' => 'getCustomer']
            ],
            'editCustomer' => [
                ['label' => 'Clientes', 'route' => 'getCustomer'],
                ['label' => 'Editar', 'route' => 'editCustomer', 'params' => true]
            ],
            'createCustomer' => [
                ['label' => 'Clientes', 'route' => 'getCustomer'],
                ['label' => 'Cadastrar', 'route' => 'createCustomer']
            ], 
            'getListProduct' => [
                ['label' => 'Lista de Produtos', 'route' => 'getListProduct']
            ],
            'editListProduct' => [
                ['label' => 'Lista de Produtos', 'route' => 'getListProduct'],
                ['label' => 'Editar', 'route' => 'editListProduct', 'params' => true]
            ],
            'createListProducts' => [
                ['label' => 'Lista de Produtos', 'route' => 'getListProduct'],
                ['label' => 'Cadastrar', 'route' => 'createListProducts']
            ], 
            'getSetting' => [
                ['label' => 'Configurações', 'route' => 'getSetting']
            ],
        ];

        return $breadcrumbData[$routeName] ?? [];
    }
}
