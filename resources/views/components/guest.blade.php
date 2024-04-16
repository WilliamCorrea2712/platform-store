<!-- resources/views/layouts/guest.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EAM') }}</title>
    <!-- Adicione links para CSS e JS comuns, se necessário -->
</head>
<body>
    <header>
        <!-- Aqui vai o cabeçalho comum -->
    </header>

    <main>
        <!-- O conteúdo da página vai aqui -->
        @yield('content')
    </main>

    <footer>
        <!-- Aqui vai o rodapé comum -->
    </footer>
    <!-- Adicione scripts comuns, se necessário -->
</body>
</html>
