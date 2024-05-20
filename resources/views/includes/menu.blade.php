<?php
    $controller = app(\App\Http\Controllers\MenuController::class);
    $response = $controller->index();
    $categories = $response->getData()['categories'] ?? [];
    $error = $response->getData()->error ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light menu-categories">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAllCategories" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Categorias') }}
                    </a>
                    <div class="dropdown-menu menu-categories" aria-labelledby="navbarDropdownAllCategories">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled">
                                    @foreach($categories as $category)
                                        <li class="category-container">
                                            <a class="dropdown-item category-link" href="{{ $category['url'] }}" data-category-id="{{ $category['id'] }}">{{ $category['name'] }}</a>
                                            <ul class="list-unstyled ml-3 subcategories">
                                                @foreach($category['subcategories'] as $subcategory)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $subcategory['url'] }}">{{ $subcategory['name'] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>                                       
                </li>
            </ul>
        </div>
    </div>
</nav>
