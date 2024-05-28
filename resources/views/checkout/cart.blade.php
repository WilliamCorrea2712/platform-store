@extends('layouts.checkout')

@section('content')
<div class="container container-cart">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div id="message-cart" class="alert alert-warning" role="alert" style="display: none"></div>
    @if (!empty($products))
    <div class="form-row">
        <div class="table-responsive table-cart col-md-8">
            <h1 class="title-cart">{{ _('SUA SACOLA') }}</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp 
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            @if (!empty($product['image_url']))
                            @php
                            $imageUrl = env('API_IMAGE_URL') . $product['image_url'];
                            $imagePath = str_replace('\\', '/', $imageUrl);
                            @endphp
                            <img src="{{ $imagePath }}" class="card-img-top product-image-cart mx-auto" alt="Imagem do Produto">
                            @else                            
                            <img src="{{ asset('images/placeholder.png') }}" style="width: 70%;" class="card-img-top product-image-cart mx-auto" alt="Imagem do Produto">
                            @endif
                        </td>
                        <td>{{ $product['name'] }}<br />{{ $product['parent_attribute_value'] }}: {{ $product['value'] }} 
                            <br /><strong>R$ {{ number_format($product['price'], 2, ',', '.') }}</strong>                                </td>
                        <td>
                            <div class="input-group">
                                <input type="hidden" id="id_{{ $product['id'] }}" name="id" value="{{ $product['id'] }}">
                                <input type="hidden" id="product_id_{{ $product['id'] }}" name="product_id" value="{{ $product['product_id'] }}">
                                <input type="hidden" id="attribute_id_{{ $product['id'] }}" name="attribute_id" value="{{ $product['attribute_id'] }}">
                                <input type="hidden" id="quantity_current_{{ $product['id'] }}" name="quantity_id" value="{{ $product['quantity'] }}">                               
                                <input id="quantity_{{ $product['id'] }}" type="number" class="form-control" value="{{ $product['quantity'] }}" min="1">  
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary update-quantity-btn d-none" type="button" data-product-id="{{ $product['id'] }}">{{ _('Atualizar') }}</button>
                                </div>
                            </div> 
                        </td>
                        <td class="text-right">R$ {{ number_format($product['price'] * $product['quantity'], 2, ',', '.') }}</td>
                        <td>
                            <form class="remove-product-form" action="{{ route('remove_product_cart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product['id'] }}">
                                <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                                <input type="hidden" name="attribute_id" value="{{ $product['attribute_id'] }}">
                                <button type="submit" class="btn btn-link text-danger remove-product-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>                                    
                        </td>
                        @php $total += $product['price'] * $product['quantity']; @endphp
                    </tr>
                    @endforeach
                </tbody>
            </table>                
        </div>
        <div class="total-container col-md-4">
            <p class="text-righ">{{ _('RESUMO DO PEDIDO') }}</p>
            <h4>{{ _('Total: R$') }}{{ number_format($total, 2, ',', '.') }}</h4>
            <button class="btn btn-success btn-checkout">{{ _('Finalizar Pedido') }}</button>
        </div>
    </div>
    @else
    <h1 class="title-cart">{{ _('CARRINHO VAZIO') }}</h1>
    <div class="alert alert-info alert-cart" role="alert">{{ 'Nenhum produto no carrinho!' }}</div>
    @endif
</div>
@endsection