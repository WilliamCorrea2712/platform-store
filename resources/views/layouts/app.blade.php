<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Platform Store' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">    
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand logo" href="/">{{ _('Minha Loja') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <form class="form-inline" action="{{ route('search') }}" method="get">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" name="search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{ _('Buscar') }}</button>
                        </form>                                                                      
                    </ul>
                    <ul class="navbar-nav align-items-center">
                        @if(session()->has('api_token'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('account') }}">{{ _('Minha Conta') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">{{ _('Sair') }}</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">{{ _('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/create-account">{{ _('Cadastre-se') }}</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/cart">{{ _('Carrinho') }} <i class="fas fa-shopping-cart"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @include('includes.menu')        
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer bg-dark">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-12 newsletter mb-4">
                    <h5 class="text-center newsletter-title">{{ _('Assine nossa newsletter') }}</h5>
                    <form action="#" method="post" class="form-inline justify-content-center">
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control" placeholder="{{ _('Seu nome') }}" required>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="email" class="form-control" placeholder="{{ _('Seu email') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">{{ _('Inscrever-se') }}</button>
                    </form>
                </div>
                <div class="col-md-3 border-right mb-4 text-footer">
                    <h5>{{ _('Central de Atendimento') }}</h5>
                    <p>{{ _('Contato (16) 99125-2086') }}</p>
                    <p>{{ _('E-mail: william.correa.dev@gmail.com') }}</p>
                </div>
                <div class="col-md-3 border-right mb-4 text-footer">
                    <h5>{{ _('Horário de Atendimento') }}</h5>
                    <p>{{ _('Segunda a Sexta, das 8:30h às 18h') }}</p>
                    <p>{{ _('Sábado e Feriados, das 9h às 14h') }}</p>
                </div>
                <div class="col-md-3 border-right mb-4 text-footer">
                    <h5>{{ _('Institucional') }}</h5>
                    <p>{{ _('Fale Conosco') }}</p>
                    <p>{{ _('Troca e devolução') }}</p>
                    <p>{{ _('Política de Privacidade') }}</p>
                    <p>{{ _('Termos de Uso') }}</p>
                </div>
                <div class="col-md-3 mb-4 text-footer">
                    <h5>{{ _('Endereço') }}</h5>
                    <p>{{ _('Rua Geny Mozette Garcia') }}</p>
                    <p>{{ _('2090 - Franca - SP') }}</p>
                    <p>{{ _('Cep: 14403-194') }}</p>
                </div>
            </div>
        </div>
    </footer>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('js/edit.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
