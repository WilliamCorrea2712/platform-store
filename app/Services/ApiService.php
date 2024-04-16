<?php

namespace App\Services;

class ApiService
{
    protected $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function getApiUrl()
    {
        return $this->apiUrl;
    }
}

?>