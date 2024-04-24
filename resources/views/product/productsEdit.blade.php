
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Editar') }}
            <button type="button" class="btn btn-primary submit-form float-right" data-form-id="productForm">{{ __('Salvar') }}</button>
            @if(isset($products[0]['id']))
                <button type="button" class="btn btn-danger delete-product float-right" data-product-id="{{ $products[0]['id'] }}">Deletar</button>                                       
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
                    @if(isset($products[0]['id']))
                        <div class="card-header font-weight-bold">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active tab-color" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" aria-selected="true">Dados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-color" id="stock-tab" data-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="false">Estoque</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link tab-color" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Imagens</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                    <form id="productForm" action="{{ route('updateProduct', ['id' => $products[0]['id']]) }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="name">{{ __('Nome:') }} <span class="text-danger">{{ __('*') }}</span></label>
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
                                                    <label for="price">{{ __('Preço:') }} <span class="text-danger">{{ __('*') }}</span></label>
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
                                                    <label for="height">{{ __('Altura:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                                    <input type="text" class="form-control" id="height" name="height" value="{{ $products[0]['height'] }}">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="width">{{ __('Largura:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                                    <input type="text" class="form-control" id="width" name="width" value="{{ $products[0]['width'] }}">
                                                </div> 
                                                <div class="form-group col-md-2">
                                                    <label for="length">{{ __('Comprimento:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                                    <input type="text" class="form-control" id="length" name="length" value="{{ $products[0]['length'] }}">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="sku">{{ __('SKU:') }}</label>
                                                    <input type="text" class="form-control" id="sku" name="sku" value="{{ $products[0]['sku'] }}">
                                                </div>  
                                                <div class="form-group col-md-2">
                                                    <label for="weight">{{ __('Peso:') }} <span class="text-danger">{{ __('*') }}</span></label>
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
                                        </div>
                                    </form>                                    
                                </div>
                                <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="stock-tab">                                    
                                    <form id="stockForm" class="highlighted-form">
                                        <div class="stock-section"></div>
                                        <button type="button" id="saveStockBtn" data-product-id="{{ $products[0]['id'] }}" class="btn btn-success">{{ _('Salvar Estoque') }}</button>
                                    </form> 
                                    <button id="addStockBtn" class="btn btn-primary">{{ _('Adicionar Grade') }}</button>                                                                     
                                    <div class="table-responsive">
                                        @if($products[0]['stock'])
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">{{ _('Atributo') }}</th>
                                                        <th class="align-middle">{{ _('Variação') }}</th>
                                                        <th class="align-middle">{{ _('Quantidade') }}</th>
                                                        <th class="align-middle text-center">{{ _('Reservado') }}</th>
                                                        <th class="align-middle">{{ _('Add/Desc') }}</th>
                                                        <th class="align-middle">{{ _('Valor') }}</th>
                                                        <th class="align-middle">{{ _('Ações') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php  
                                                        $color = true;
                                                        $attribute_id = null; 
                                                        $stockSId = []; 
                                                    @endphp
                                                    @foreach ($products[0]['stock'] as $stock)                                                                                                             
                                                        @if ($stock['parent_attribute_id'] === null)

                                                            @php 
                                                                $color = !$color; 
                                                                $attribute_id = $stock['attribute_id']; 

                                                                if (!isset($stockSId[$attribute_id])) {
                                                                    $stockSId[$attribute_id] = [];
                                                                }
                                                                
                                                                $stockSId[$attribute_id][] = $stock['stock_id']; 
                                                            @endphp

                                                            <tr class="{{ $color ? 'even-row' : 'odd-row' }} main-item">
                                                                <td class="col-2 align-middle">{{ $stock['name'] }}</td>
                                                                <td class="col-3 align-middle">{{ $stock['value'] }}</td>
                                                                <td class="col-2 align-middle">
                                                                    <input type="number" class="form-control" value="{{ $stock['quantity'] }}" @disabled(true)>
                                                                </td>
                                                                <td class="col-1 align-middle"></td>
                                                                <td class="col-1 align-middle"></td>
                                                                <td class="col-2 align-middle"></td>
                                                                <td class="col-1 align-middle">
                                                                    <button class="btn btn-danger btn-sm delete-stock" 
                                                                    data-stock-id="{{ json_encode($stockSId[$attribute_id]) }}" 
                                                                    data-product-id="{{ $products[0]['id'] }}" 
                                                                    data-attribute-id="{{ $stock['attribute_id'] }}">
                                                                    {{ _('Excluir')  }}
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @if($stockSId[$attribute_id] === $stock['parent_attribute_id'])
                                                                @php $stockSId[$attribute_id] = [$stock['stock_id']]; @endphp
                                                            @else
                                                                @php $stockSId[$attribute_id][] = $stock['stock_id']; @endphp
                                                            @endif
                                                            <tr class="{{ $color ? 'even-row' : 'odd-row' }}">
                                                                <td class="col-2 align-middle"></td>
                                                                <td class="col-3 align-middle">{{ $stock['value'] }}</td>
                                                                <td class="col-2 align-middle">
                                                                    <input type="number" class="form-control" value="{{ $stock['quantity'] }}">
                                                                </td>
                                                                <td class="col-1 align-middle text-center">{{ $stock['stock_cart'] }}</td>
                                                                <td class="col-1 align-middle">
                                                                    <select class="form-control">
                                                                        <option value="+">{{ _('+') }}</option>
                                                                        <option value="-">{{ _('-') }}</option>
                                                                    </select>
                                                                </td>
                                                                <td class="col-2 align-middle"><input type="number" class="form-control" value="{{ $stock['additional_value'] ?? '' }}"></td>
                                                                <td class="col-1 align-middle">
                                                                    <button class="btn btn-danger btn-sm delete-stock" 
                                                                    data-stock-id="[{{ $stock['stock_id'] }}]" 
                                                                    data-product-id="{{ $products[0]['id'] }}" 
                                                                    data-attribute-id="{{ $stock['attribute_id'] }}">
                                                                    {{ _('Excluir')  }}
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-info" role="alert">{{ __('Não há estoque para este produto!') }}</div> 
                                        @endif
                                    </div>
                                </div>                                                                                                                                                                                                                    
                                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                    <div class="container">
                                        <div id="message-api" class="alert alert-warning" role="alert" style="display: none"></div>
                                        <div class="container-fluid imagesProduct">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary btn-lg btn-block" data-product-id="{{ $products[0]['id'] }}" id="selectImagesBtn">{{ _('Selecionar Imagens') }}</button>
                                                </div>
                                            </div>
                                            <div id="imagePreview" class="mt-4" style="display: none;">                                            
                                                <div id="previewContainer" class="row mt-3"></div>
                                            </div>
                                            <div id="selectedImagesMsg" class="mt-3" style="display: none;"></div>
                                        </div>                                        
                                        <div class="table-responsive mt-4">
                                            @if($products[0]['images'])
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ _('Imagens do Produto') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($products[0]['images'] as $image)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center image-item">
                                                                        <div class="preview-images mr-3">
                                                                            @php
                                                                                $imageUrl = env('API_IMAGE_URL') . $image['image_url'];
                                                                                $imagePath = str_replace('\\', '/', $imageUrl);
                                                                            @endphp
                                                                            <img src="{{ $imagePath }}" alt="{{ $image['image_name'] }}" class="img-thumbnail" />
                                                                        </div>
                                                                        <button type="button" class="btn btn-danger delete-image" data-image-id="{{ $image['image_id'] }}" data-product-id="{{ $products[0]['id'] }}">{{ _('Excluir') }}</button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                                                                       
                                                </table>
                                            @else
                                                <div class="alert alert-info" role="alert">{{ _('Não há imagens para este produto!') }}</div> 
                                            @endif
                                        </div>
                                    </div>                                                                        
                                </div>                                                                                                
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            {{ __('Produto não encontrado!') }}
                            <a href="{{ route('getProducts') }}" class="btn btn-primary float-right">{{ __('Voltar') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection