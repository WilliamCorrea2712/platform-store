<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Platform EAM' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">{{ _('EAM') }}</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <button id="theme-toggle">{{ _('Dark') }}</button>
                        </li>                                               
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">{{ _('Sobre') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">{{ _('Contato') }}</a>
                        </li>                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">{{ _('Sair') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 menu d-lg-block">
                @include('includes.menu')
            </div>
            <div class="col-md-10 margin-bottom">
                @yield('content')
            </div>
        </div>
    </div>
 
    <footer class="footer bg-dark text-light py-4">
        <div class="container text-center">
            &copy; {{ date('Y') }} Plataforma EAM. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('js/customer.js') }}"></script>
</body>
</html>
