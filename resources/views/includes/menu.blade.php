<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link customers-toggle" href="#">Clientes</a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getCustomer') }}">Todos os Clientes</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link products-toggle" href="#">Produtos</a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getCategory') }}">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getBrand') }}">Marcas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getProduct') }}">Produto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Estoque</a>
                        </li>
                    </ul>
                </li>      
                <li class="nav-item">
                    <a class="nav-link config-toggle" href="#">Configurações</a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getListProduct') }}">Lista de Produtos</a>
                        </li>
                    </ul>
                </li>           
                <li class="nav-item">
                    <a class="nav-link users-toggle" href="#">Usuários</a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getUser') }}">Todos os Usuários</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>