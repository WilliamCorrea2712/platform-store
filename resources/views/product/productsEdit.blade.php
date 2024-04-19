
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Editar Produto') }}</h1>
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
                    <div class="card-header font-weight-bold">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active tab-color" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" aria-selected="true">Dados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-color" id="estoque-tab" data-toggle="tab" href="#estoque" role="tab" aria-controls="estoque" aria-selected="false">Estoque</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-color" id="imagens-tab" data-toggle="tab" href="#imagens" role="tab" aria-controls="imagens" aria-selected="false">Imagens</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                <form action="{{ route('updateProduct', ['id' => $products[0]['id']]) }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">{{ __('Nome:') }}</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $products[0]['name'] }}" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="sort_order">{{ __('Ordem:') }}</label>
                                                <input type="text" class="form-control" id="sort_order" name="sort_order" value="{{ $products[0]['sort_order'] }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="status">{{ __('Status:') }}</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="1" {{ $products[0]['status'] == 1 ? 'selected' : '' }}>{{ __('Habilitado') }}</option>
                                                    <option value="0" {{ $products[0]['status'] == 0 ? 'selected' : '' }}>{{ __('Desabilitado') }}</option>
                                                </select>
                                            </div>                                                                
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="price">{{ __('Preço:') }}</label>
                                                <input type="text" class="form-control" id="price" name="price" value="{{ $products[0]['price'] }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="cost_price">{{ __('Preço de Custo:') }}</label>
                                                <input type="text" class="form-control" id="cost_price" name="cost_price" value="{{ $products[0]['cost_price'] }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="brand_id">{{ __('Marca:') }}</label>
                                                <select class="form-control" id="brand_id" name="brand_id">
                                                    <option value="">{{ __('Selecione uma marca') }}</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand['id'] }}" @if($products[0]['brand_id'] == $brand['id']) selected @endif>{{ $brand['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                 
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="height">{{ __('Altura:') }}</label>
                                                <input type="text" class="form-control" id="height" name="height" value="{{ $products[0]['height'] }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="width">{{ __('Largura:') }}</label>
                                                <input type="text" class="form-control" id="width" name="width" value="{{ $products[0]['width'] }}">
                                            </div> 
                                            <div class="form-group col-md-2">
                                                <label for="length">{{ __('Comprimento:') }}</label>
                                                <input type="text" class="form-control" id="length" name="length" value="{{ $products[0]['length'] }}">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="sku">{{ __('SKU:') }}</label>
                                                <input type="text" class="form-control" id="sku" name="sku" value="{{ $products[0]['sku'] }}">
                                            </div>  
                                            <div class="form-group col-md-2">
                                                <label for="weight">{{ __('Peso:') }}</label>
                                                <input type="text" class="form-control" id="weight" name="weight" value="{{ $products[0]['weight'] }}">
                                            </div>                                                                                       
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="category_id">{{ __('Categoria(s):') }}</label>
                                                <select class="form-control" id="category_id" name="category_id[]" multiple>
                                                    <option value="">{{ __('Selecione uma ou mais categorias') }}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category['id'] }}" @if(in_array($category['id'], $products[0]['categories'])) selected @endif>{{ $category['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="form-row">                                 
                                            <div class="form-group col-md-6">
                                                <label for="description_resume">{{ __('Descrição Resumida:') }}</label>
                                                <input type="text" class="form-control" id="description_resume" name="description_resume" value="{{ $products[0]['description_resume'] }}">
                                            </div>  
                                            <div class="form-group col-md-6">
                                                <label for="tags">{{ __('Tags:') }}</label>
                                                <input type="text" class="form-control" id="tags" name="tags" value="{{ $products[0]['tags'] }}">
                                            </div>                                                                                         
                                        </div>  
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="description">{{ __('Descrição:') }}</label>
                                                <textarea class="form-control ckeditor" id="description" name="description">{{ $products[0]['description'] }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="meta_description">{{ __('Meta Descrição:') }}</label>
                                                <input type="text" class="form-control" id="meta_description" name="meta_description" value="{{ $products[0]['meta_description'] }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="meta_title">{{ __('Meta Título:') }}</label>
                                                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $products[0]['meta_title'] }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="meta_keyword">{{ __('Meta Palavra-chave:') }}</label>
                                                <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" value="{{ $products[0]['meta_keyword'] }}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="estoque" role="tabpanel" aria-labelledby="estoque-tab">
                                <!-- Conteúdo da tab de Estoque -->
                            </div>
                            <div class="tab-pane fade" id="imagens" role="tabpanel" aria-labelledby="imagens-tab">
                                <!-- Conteúdo da tab de Imagens -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
