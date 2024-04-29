<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class SettingController extends Controller
{
    public function getSetting()
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl . 'config/getDynamicSetting');

        $error = '';
        $settings = [];

        if ($response->successful()) {
            $apiData = $response->json();

            if (isset($apiData['message']['settings'])) {
                $settings = $apiData['message']['settings'];
                $settings = collect($settings);
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar as configurações.';
        }

        return view('config.setting', compact('settings', 'error'));
    }

}
