@if($products)
    <div class="row product-row justify-content-center">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="card product-card">
                    @if (!empty($product['images']))
                        @php $firstImage = reset($product['images']); @endphp
                        @php
                            $imageUrl = env('API_IMAGE_URL') . $firstImage['image_url'];
                            $imagePath = str_replace('\\', '/', $imageUrl);
                        @endphp
                        <a href="{{ $product['url'] }}">
                            <img src="{{ $imagePath }}" class="card-img-top product-image mx-auto" alt="Imagem do Produto">
                        </a>
                    @else                            
                        <img src="{{ asset('images/placeholder.png') }}" class="card-img-top product-image mx-auto" alt="Imagem do Produto">
                    @endif
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="card-text price">{{ _('Preço: ') }} {{ 'R$ ' . number_format($product['price'], 2, ',', '.') }}</p>
                        <i class="card-text">{{ $product['description_resume'] }}</i>
                        <p class="card-text">{{ _('Compra Minima: ') }} {{ $product['minimum'] }}</p>                        
                    </div>
                </div>
            </div>
        @endforeach            
    </div>
@else
    <div class="alert alert-info" role="alert">{{ 'Nenhum produto encontrado para esta categoria!' }}</div>
@endif