<?php

namespace App\Http\Controllers;

class BannerController extends Controller
{
    public function index()
    {
        $banners = [
            ['image' => 'images/banners/banner1.jpg'],
            ['image' => 'images/banners/banner2.jpg'],
            ['image' => 'images/banners/banner3.jpg'],
        ];

        return $banners;
    }
}
