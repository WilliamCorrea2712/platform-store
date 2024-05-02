@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Editar') }}
            <button type="button" class="btn btn-success submit-form float-right" data-form-id="productListForm">{{ __('Salvar') }}</button>
            @if(isset($listProducts[0]['id']))
                <button type="button" class="btn btn-danger delete-product-list float-right" data-list-id="{{ $listProducts[0]['id'] }}">{{ __('Deletar') }}</button>                                       
            @endif
        </h1>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(isset($listProducts[0]['id']))
                        <form id="productListForm" action="{{ route('updateListProduct', ['id' => $listProducts[0]['id']]) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">{{ __('Nome:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $listProducts[0]['name'] }}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sort_order">{{ __('Ordem:') }}</label>
                                        <input type="text" class="form-control" id="sort_order" name="sort_order" value="{{ $listProducts[0]['sort_order'] }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="status">{{ __('Status:') }}</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="1" {{ $listProducts[0]['status'] == 1 ? 'selected' : '' }}>{{ __('Habilitado') }}</option>
                                            <option value="0" {{ $listProducts[0]['status'] == 0 ? 'selected' : '' }}>{{ __('Desabilitado') }}</option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="products">{{ __('Produtos(s):') }}</label>
                                        <select class="form-control" id="products" name="products[]" multiple>
                                            <option value="">{{ __('Selecione os produtos') }}</option>
                                            @foreach($products as $product)
                                                @php
                                                    $selected = ($listProducts[0]['products'] && in_array($product['id'], json_decode($listProducts[0]['products'], true))) ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $product['id'] }}" {{ $selected }}>{{ $product['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info" role="alert">
                            {{ __('Lista de produtos não encontrada!') }}
                            <a href="{{ route('getListProduct') }}" class="btn btn-primary float-right">{{ __('Voltar') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
