@extends('layouts.app')

@section('content')
<div class="container product-content">
    @if($product)
        <h1 class="title">{{ $product['name'] }}</h1>
        <div class="row">
            <div class="col-md-6 description-images">
                @if (!empty($product['images']))
                    @php $firstImage = reset($product['images']); @endphp
                    @php
                        $imageUrl = env('API_IMAGE_URL') . $firstImage['image_url'];
                        $imagePath = str_replace('\\', '/', $imageUrl);
                    @endphp
                    <a href="{{ $product['url'] }}">
                        <img src="{{ $imagePath }}" class="card-img-top product-image mx-auto" id="mainImage" alt="Imagem do Produto">
                    </a>
                @else                            
                    <img src="{{ asset('images/placeholder.png') }}" class="card-img-top product-image mx-auto" id="mainImage" alt="Imagem do Produto">
                @endif    
                <div class="row mt-3">
                    @if (!empty($product['images']))
                        @foreach($product['images'] as $index => $image)
                            @php
                                $imageUrl = env('API_IMAGE_URL') . $image['image_url'];
                                $imagePath = str_replace('\\', '/', $imageUrl);
                            @endphp
                            <div class="imgs-thumbnail">
                                <img src="{{ $imagePath }}" class="img-thumbnail" alt="{{ $product['name'] }}" onclick="changeMainImage('{{ $imagePath }}')">
                            </div>
                        @endforeach
                    @endif
                </div>            
            </div>        
            <div class="col-md-6 description-data">
                <p class="description-price"><strong> {{ 'R$ ' . number_format($product['price'], 2, ',', '.') }}</strong></p>
                <p><strong>{{ __('SKU: ') }}</strong>{{ $product['sku'] }}</p>
                <p><strong>{{ _('Compra Minima: ') }}</strong> {{ $product['minimum'] }}</p>
                <p><strong>{{ _('Peso: ') }}</strong> {{ $product['weight'] }}</p> 
                <p><br /><strong>{{ __('Resumo ') }}</strong><br /> {{ $product['description_resume'] }}</p>
                <div class="stock-options">
                    <h3>{{ _('Escolha uma opção') }}</h3>
                    @foreach ($product['stock'] as $stock)
                        @if ($stock['parent_attribute_id'] === null)
                            <div class="stock-option" data-parent-id="{{ $stock['attribute_id'] }}" data-stock-id="{{ $stock['stock_id'] }}">
                                <div class="stock-label">{{ $stock['value'] }} ({{ $stock['quantity'] }})</div>
                            </div>
                            <div class="sub-options" data-parent-id="{{ $stock['stock_id'] }}">
                                @foreach ($product['stock'] as $subStock)
                                    @if ($subStock['parent_attribute_id'] === $stock['stock_id'])
                                        <div class="sub-option">
                                            <input type="radio" id="stock{{ $subStock['stock_id'] }}" name="stock" value="{{ $subStock['stock_id'] }}">
                                            <label for="stock{{ $subStock['stock_id'] }}">{{ $subStock['value'] }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                    <div class="description-btn">
                        <button class="btn btn-primary add-to-cart">{{ _('Adicionar ao Carrinho') }}</button>
                        <button class="btn btn-success buy-now">{{ _('Comprar') }}</button>
                    </div>
                </div>                             
            </div>
        </div>
        <div class="row mt-12 product-description">
            <div class="row mt-12">
                <div class="col-md-12">
                    <h2>{{ _('Descrição') }}</h2>
                    <p>{!! $product['description'] !!}</p>
                </div>
            </div>        
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            {{ __('Produto não encontrado.') }}
        </div>
    @endif
</div>
@endsection