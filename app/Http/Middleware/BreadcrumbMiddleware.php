<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class BreadcrumbMiddleware
{
    private $breadcrumbLabels = [
        'dashboard' => 'Home',
        'getProducts' => 'Produtos',
        'editProduct' => 'Editar Produto',
        'createProduct' => 'Cadastrar Produto',
        'getCategories' => 'Categorias',
        'editCategory' => 'Editar Categoria',
        'createCategories' => 'Cadastrar Categoria',
        'getBrands' => 'Marcas',
        'editBrand' => 'Editar Marca',
        'createBrands' => 'Cadastrar Marca',
        'getUser' => 'Usuários',
        'editUser' => 'Editar Usuário',
        'createUser' => 'Cadastrar Usuário',
        'getCustomer' => 'Clientes',
        'editCustomer' => 'Editar Cliente',
        'createCustomer' => 'Cadastrar Cliente',
    ];

    public function handle($request, Closure $next)
    {
        $breadcrumbs = collect();
        $breadcrumbs->push(['route' => 'dashboard', 'label' => 'Home']);
        
        $route = Route::current();

        $routeName = $route->getName();

        $label = $this->breadcrumbLabels[$routeName] ?? '';

        $params = $this->getRouteParameters($route);

        $breadcrumbs->push(['route' => $routeName, 'label' => $label, 'params' => $params]);

        view()->share('breadcrumbs', $breadcrumbs);

        return $next($request);
    }

    private function getRouteParameters($route)
    {
        if (isset($route->parameters['id'])) {
            return ['id' => $route->parameters['id']];
        }
        
        return [];
    }
}
