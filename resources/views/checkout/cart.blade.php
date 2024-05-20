@extends('layouts.app')

@section('content')
<div class="container container-cart">
  <h1 class="title">{{ _('Seu Carrinho') }}</h1>
    @if (!empty($products))
        <div class="table-responsive table-cart">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ _('Imagem') }}</th>
                        <th>{{ _('Produto') }}</th>
                        <th>{{ _('Quantidade') }}</th>
                        <th class="text-right">{{ _('Preço Unitário') }}</th>
                        <th class="text-right">{{ _('Total') }}</th>
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
                            <td>{{ $product['name'] }}<br />{{ $product['parent_attribute_value'] }}: {{ $product['value'] }}</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="{{ $product['quantity'] }}" min="1">
                                </div>
                            </td>
                            <td class="text-right">R$ {{ $product['price'] }}</td>
                            <td class="text-right">R$ {{ $product['price'] * $product['quantity'] }}</td>
                            @php $total += $product['price'] * $product['quantity']; @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="total-container">
            <button class="btn btn-success">{{ _('Finalizar Pedido') }}</button>
            <h4>{{ _('Total: R$') }} {{ number_format($total, 2, ',', '.') }}</h4>
        </div>
    @else
        <p>{{ _('Seu carrinho está vazio.') }}</p>
    @endif
</div>
@endsection
