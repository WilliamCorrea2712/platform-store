<?php

namespace App\Http\Controllers;

use App\Utils\ApiRequest;
use App\Http\Controllers\CategoryController;

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
                return view('product', ['id' => $data['id']]);
            case 'brand':
                return view('brand', ['id' => $data['id']]);
            case 'category':
                $categoryController = new CategoryController($apiRequest);
                return $categoryController->show($data['id']);
            default:
                return abort(404);
        }
    }
}
