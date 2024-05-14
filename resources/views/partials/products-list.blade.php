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
                        <img src="{{ asset('images/placeholder.png') }}" style="width: 70%;" class="card-img-top product-image mx-auto" alt="Imagem do Produto">
                    @endif
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="card-text list-price">{{ _('Preço: ') }} {{ 'R$ ' . number_format($product['price'], 2, ',', '.') }}</p>
                        <i class="card-text">{!! Illuminate\Support\Str::limit($product['description_resume'], $limit = 100, $end = '...') !!}</i>                        
                        <a href="{{ $product['url'] }}"><div class="btn btn-primary list-details">{{ _('Detalhes') }}</div></a>
                    </div>
                </div>
            </div>
        @endforeach            
    </div>
@else
    <div class="alert alert-info" role="alert">{{ 'Nenhum produto encontrado para esta categoria!' }}</div>
@endif