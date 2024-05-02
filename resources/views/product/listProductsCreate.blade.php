@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-6 title">{{ __('Cadastrar') }}</h1>
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
                    <form action="{{ route('storeListProducts') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Nome:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="sort_order">{{ __('Ordem:') }}</label>
                                    <select class="form-control" id="sort_order" name="sort_order">
                                        <option value="name">Nome</option>
                                        <option value="randon">Aleatório</option>
                                        <option value="date">Data</option>
                                        <option value="price_asc">Preço (Menor para Maior)</option>
                                        <option value="price_desc">Preço (Maior para Menor)</option>
                                        <option value="sort_order">Ordem</option>
                                    </select>
                                </div>                                
                                <div class="form-group col-md-3">
                                    <label for="status">{{ __('Status:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1">{{ __('Habilitado') }}</option>
                                        <option value="0">{{ __('Desabilitado') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">                                
                                <div class="form-group col-md-12">
                                    <label for="products">{{ __('Produtos(s):') }}</label>
                                    <select class="form-control" id="products" name="products[]" multiple>
                                        <option value="">{{ __('Selecione os produtos') }}</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>                                                                                               
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('Salvar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
