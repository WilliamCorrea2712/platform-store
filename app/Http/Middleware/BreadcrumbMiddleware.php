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
            'getProduct' => [
                ['label' => 'Produtos', 'route' => 'getProduct']
            ],
            'editProduct' => [
                ['label' => 'Produtos', 'route' => 'getProduct'],
                ['label' => 'Editar Produto', 'route' => 'editProduct', 'params' => true]
            ],
            'getUser' => [
                ['label' => 'Usuários', 'route' => 'getUser']
            ],
            'editUser' => [
                ['label' => 'Usuários', 'route' => 'getUser'],
                ['label' => 'Editar Usuário', 'route' => 'editUser', 'params' => true]
            ],
            'getCategory' => [
                ['label' => 'Categorias', 'route' => 'getCategory']
            ],
            'editCategory' => [
                ['label' => 'Categorias', 'route' => 'getCategory'],
                ['label' => 'Editar Categoria', 'route' => 'editCategory', 'params' => true]
            ],
            'getBrand' => [
                ['label' => 'Marcas', 'route' => 'getBrand']
            ],
            'editBrand' => [
                ['label' => 'Marcas', 'route' => 'getBrand'],
                ['label' => 'Editar Marca', 'route' => 'editBrand', 'params' => true]
            ],
            'getCustomer' => [
                ['label' => 'Clientes', 'route' => 'getCustomer']
            ],
            'editCustomer' => [
                ['label' => 'Clientes', 'route' => 'getCustomer'],
                ['label' => 'Editar Cliente', 'route' => 'editCustomer', 'params' => true]
            ],
            'getListProduct' => [
                ['label' => 'Lista de Produtos', 'route' => 'getListProduct']
            ],
            'editListProduct' => [
                ['label' => 'Lista de Produtos', 'route' => 'getListProduct'],
                ['label' => 'Editar Lista de Produtos', 'route' => 'editListProduct', 'params' => true]
            ],
            'getSetting' => [
                ['label' => 'Configurações', 'route' => 'getSetting']
            ],
        ];

        return $breadcrumbData[$routeName] ?? [];
    }
}
