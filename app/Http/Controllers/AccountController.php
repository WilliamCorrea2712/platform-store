<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Utils\ApiRequest;

class AccountController extends Controller
{
    protected $apiRequest;

    public function __construct(ApiRequest $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

    function account()
    {
        $customer_id = session()->get('customer_id');

        $response = $this->apiRequest->sendRequest('get', 'account/getCustomers', [], ['id' => $customer_id]);
        $message = $response->json()['message'] ?? null;

        if ($message && isset($message['customers'])) {
            $data = $message['customers'];
            $addresses = $message['customers'][$customer_id]['addresses'];
        } else {
            $data = [];
            $addresses = [];
        }

        return view('account.account', ['data' => $data, 'addresses' => $addresses]);
    }

    function deleteAddress(Request $request){
        $addressId = $request->input('address_id');
        $errors = []; 

        $response = $this->apiRequest->sendRequest('delete', 'account/deleteAddress', ['address_id' => $addressId]);

        if (!$response->successful()) {
            $errorResponse = $response->json();
            if (isset($errorResponse['message'])) {
                $errors[] = $errorResponse['message'];
            } else {
                $errors[] = 'Erro desconhecido ao excluir o endereço.';
            }
        }

        if (!empty($errors)) {
            return redirect()->route('account')->with(['errors' => $errors]);
        } else {
            return redirect()->route('account')->with('success', 'Endereço excluido com sucesso!');
        }  
    }

    function addAddress(Request $request){

        $customer_id = session()->get('customer_id');
        
        if ($request->input('street')) {
            $streets = $request->input('street');
            $cities = $request->input('city');
            $states = $request->input('state');
            $zipCodes = $request->input('zip_code');
            $nameAddresses = $request->input('nameAddress');
            $numbers = $request->input('number');
            $countries = $request->input('country');
            
            foreach ($streets as $key => $street) {
                $addressId = $request->input('address_id')[$key] ?? null;
        
                $requestData = [
                    'street' => $street,
                    'city' => $cities[$key],
                    'state' => $states[$key],
                    'zip_code' => $zipCodes[$key],
                    'name' => $nameAddresses[$key],
                    'number' => $numbers[$key],
                    'country' => $countries[$key],
                ];
        
                if ($addressId) {
                    $requestData['address_id'] = $addressId;
                    $response = $this->apiRequest->sendRequest('patch', 'account/editAddress', $requestData);
                } else {
                    $requestData['customer_id'] = $customer_id;
                    $response = $this->apiRequest->sendRequest('post', 'account/addAddress', $requestData);
                }
                 
            }                                
        }  
        
        if ($response->failed()) {
            return response()->json(['error' => $response->body()], $response->status());
        } else {
            return redirect()->route('account')->with('success', 'Endereço adicionado com sucesso!');
        } 
    }

    function editCustomer(Request $request, $id){

        $data = [
            'customer_id' => $id,
            'name' => $request->input('name') ? $request->input('name') : '',
            'phone_number' => $request->input('phone_number') ? $request->input('phone_number') : '',
            'birth_date' => $request->input('birth_date') ? $request->input('birth_date') : '',
            'cnpj_cpf' => $request->input('cnpj_cpf') ? $request->input('cnpj_cpf') : '',
            'rg_ie' => $request->input('rg_ie') ? $request->input('rg_ie') : '',
            'type_person' => $request->input('type_person') ? $request->input('type_person') : '',
            'sex' => $request->input('sex') ? $request->input('sex') : '',
        ];
    
        $response = $this->apiRequest->sendRequest('patch', 'account/editCustomer', $data);

        if ($response->failed()) {
            return response()->json(['error' => $response->body()], $response->status());
        } else {
            return response()->json(['success' => true], 200);
        } 
    }

    function editPassword(Request $request){
        $customer_id = session()->get('customer_id');

        $data = [
            'customer_id' => $customer_id,
            'password' => $request->input('password') ? $request->input('password') : '',
            'confirmPassword' => $request->input('confirmPassword') ? $request->input('confirmPassword') : '',
        ];

        $response = $this->apiRequest->sendRequest('patch', 'account/editCustomer', $data);

        if ($response->failed()) {
            return response()->json(['error' => $response->body()], $response->status());
        } else {
            return response()->json(['success' => true], 200);
        } 
    }
}
