@extends('layouts.app')
<script src="{{ asset('js/addAddress.js') }}"></script>

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Editar Cliente') }}
            <button type="submit" form="editForm" class="btn btn-primary float-right">{{ __('Salvar') }}</button>
        </h1>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    @if(session('errors'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('errors') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form id="editForm" action="{{ route('updateCustomer', ['id' => $customer['id']]) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="name">{{ __('Nome') }}:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $customer['name'] }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">{{ __('Email') }}:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $customer['email'] }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="phone_number">{{ __('Número de Telefone') }}:</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $customer['phone_number'] }}" required>
                                </div>
                            </div>
                            <div class="form-row">                                
                                <div class="form-group col-md-3">
                                    <label for="birth_date">{{ __('Data de Nascimento') }}:</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $customer['birth_date'] }}" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cnpj_cpf">{{ __('CNPJ/CPF') }}:</label>
                                    <input type="text" class="form-control" id="cnpj_cpf" name="cnpj_cpf" value="{{ $customer['cnpj_cpf'] }}" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="rg_ie">{{ __('RG/IE') }}:</label>
                                    <input type="text" class="form-control" id="rg_ie" name="rg_ie" value="{{ $customer['rg_ie'] }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="type_person">{{ __('Tipo de Pessoa') }}:</label>
                                    <select class="form-control" id="type_person" name="type_person" required>
                                        <option value="1" {{ $customer['type_person'] == '1' ? 'selected' : '' }}>{{ __('Física') }}</option>
                                        <option value="2" {{ $customer['type_person'] == '2' ? 'selected' : '' }}>{{ __('Jurídica') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sex">{{ __('Sexo') }}:</label>
                                    <select class="form-control" id="sex" name="sex" required>
                                        <option value="M" {{ $customer['sex'] == 'M' ? 'selected' : '' }}>{{ __('Masculino') }}</option>
                                        <option value="F" {{ $customer['sex'] == 'F' ? 'selected' : '' }}>{{ __('Feminino') }}</option>
                                        <option value="O" {{ $customer['sex'] == 'O' ? 'selected' : '' }}>{{ __('Outro') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="password">{{ __('Senha') }}:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="confirmPassword">{{ __('Confirme a Senha') }}:</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                            </div>
                            <hr>
                            <div class="addresses-section">
                                <h3>{{ __('Endereços') }}</h3>
                                @foreach($customer['addresses'] as $address)
                                    <div class="address border rounded p-3 mb-3">
                                        <input type="hidden" name="address_id[]" value="{{ $address['id'] }}">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="nameAddress">{{ __('Nome') }}:</label>
                                                <input type="text" class="form-control" name="nameAddress[]" value="{{ $address['nameAddress'] }}" required>
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="street">{{ __('Rua') }}:</label>
                                                <input type="text" class="form-control" name="street[]" value="{{ $address['street'] }}" required>
                                            </div>  
                                            <div class="form-group col-md-3">
                                                <label for="number">{{ __('Número') }}:</label>
                                                <input type="text" class="form-control" name="number[]" value="{{ $address['number'] }}" required>
                                            </div>                                          
                                        </div>
                                        <div class="form-row">                                            
                                            <div class="form-group col-md-3">
                                                <label for="city">{{ __('Cidade') }}:</label>
                                                <input type="text" class="form-control" name="city[]" value="{{ $address['city'] }}" required>
                                            </div>   
                                            <div class="form-group col-md-3">
                                                <label for="state">{{ __('Estado') }}:</label>
                                                <input type="text" class="form-control" name="state[]" value="{{ $address['state'] }}" required>
                                            </div>                                                                                                                             
                                            <div class="form-group col-md-3">
                                                <label for="zip_code">{{ __('CEP') }}:</label>
                                                <input type="text" class="form-control" name="zip_code[]" value="{{ $address['zip_code'] }}" required>
                                            </div>  
                                            <div class="form-group col-md-3">
                                                <label for="country">{{ __('País') }}:</label>
                                                <input type="text" class="form-control" name="country[]" value="{{ $address['country'] }}" required>
                                            </div>                                          
                                        </div>                                        
                                    </div>
                                @endforeach
                            </div>                        
                            <button type="button" class="btn btn-primary mt-3" id="addAddress">{{ __('Adicionar Endereço') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection