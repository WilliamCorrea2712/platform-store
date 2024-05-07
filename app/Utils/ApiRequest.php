<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class ApiRequest
{
    protected $apiUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('api.url');
        $this->apiToken = config('api.token');
    }

    public function sendRequest($method, $endpoint, $data = [], $params = [])
    {
        $request = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept' => 'application/json',
        ]);

        if (!empty($params)) {
            $endpoint .= '&' . http_build_query($params);
        }

        if (!empty($data)) {
            $request->withBody(json_encode($data), 'application/json');
        }

        $response = match (strtolower($method)) {
            'get' => $request->get($this->apiUrl . $endpoint),
            'post' => $request->post($this->apiUrl . $endpoint),
            'put' => $request->put($this->apiUrl . $endpoint),
            'patch' => $request->patch($this->apiUrl . $endpoint),
            'delete' => $request->delete($this->apiUrl . $endpoint),
            default => throw new \InvalidArgumentException("HTTP method {$method} not supported"),
        };

        return $response;
    }
}
