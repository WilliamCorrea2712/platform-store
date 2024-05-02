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
                $settings = collect($settings)->groupBy(function ($item) {
                    return strtolower($item['group_name']);
                });
            }
        } else {
            $error = $response->json()['error'] ?? 'Erro desconhecido ao tentar recuperar as configurações.';
        }

        return view('config.setting', compact('settings', 'error'));
    }

    public function addSetting(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $data = [
            'settings' => [
                [
                    'name' => $request->name ?: '',
                    'key' => $request->key ?: '',
                    'value' => $request->value ?: '',
                    'group_name' => $request->group_name ?: '',
                ]
            ]
        ];        

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->post($apiUrl . 'config/addDynamicSetting', $data);        

        if ($response->successful()) {
            return redirect()->route('getSetting')->with('success', $response->json()['message'] ?? 'Configuração adicionada com sucesso!.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao criar configuração.';
            return redirect()->route('getSetting')->with('error', $errorMessage);
        }
    }

    public function editSetting(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->setting_id;
        $value = $request->value;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->patch($apiUrl . 'config/editDynamicSetting', [
            'setting_id' => $id,
            'value' => $value
        ]);        

        if ($response->failed()) {
            return response()->json(['error' => $response->body()], $response->status());
        } else {
            return response()->json(['success' => true], 200);
        }  
    }

    public function deleteSetting(Request $request)
    {
        $apiUrl = config('api.url');
        $apiToken = config('api.token');

        $id = $request->input('id');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Accept' => 'application/json',
        ])->delete($apiUrl . 'config/deleteDynamicSetting', [
            'setting_id' => $id,
        ]);

        if ($response->successful()) {
            return redirect()->route('getSetting')->with('success', $response->json()['message'] ?? 'Configuração deletada com sucesso!.');
        } else {
            $errorMessage = $response->json()['error'] ?? 'Erro desconhecido ao deletar configuração.';
            return redirect()->route('getSetting')->with('error', $errorMessage);
        }
    }
}
