<?php

namespace App\Http\Controllers;

use App\Utils\ApiRequest;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ListController;

class PageController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    public function show($slug, ApiRequest $apiRequest)
    {
        $response = $this->apiRequest->sendRequest('get', 'seo/getUrl', [], ['url' => $slug]);

        $data = $response->json()['message']['data'];

        switch ($data['key']) {
            case 'product':
                $ProductController = new ProductController($apiRequest);
                return $ProductController->show($data['id']);
            case 'brand':
                $brandController = new BrandController($apiRequest);
                return $brandController->show($data['id']);
            case 'category':
                $categoryController = new CategoryController($apiRequest);
                return $categoryController->show($data['id']);
            case 'list':
                $listController = new ListController($apiRequest);
                return $listController->show($data['id']);
            default:
                return abort(404);
        }
    }
}
