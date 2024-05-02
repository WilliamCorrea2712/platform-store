<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">{{ _('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link customers-toggle" href="#">{{ _('Clientes ') }}<i class="fas fa-chevron-down smaller-arrow"></i></a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getCustomer') }}">{{ _('Todos os Clientes') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link products-toggle" href="#">{{ _('Produtos ') }}<i class="fas fa-chevron-down smaller-arrow"></i></a></a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getCategory') }}">{{ _('Categorias') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getBrand') }}">{{ _('Marcas') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getProduct') }}">{{ _('Produto') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ _('Estoque') }}</a>
                        </li>
                    </ul>
                </li>      
                <li class="nav-item">
                    <a class="nav-link config-toggle" href="#">{{ _('Configurações ') }}<i class="fas fa-chevron-down smaller-arrow"></i></a></a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getSetting') }}">{{ _('Gerais') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getListProduct') }}">{{ _('Lista de Produtos') }}</a>
                        </li>
                    </ul>
                </li>           
                <li class="nav-item">
                    <a class="nav-link users-toggle" href="#">{{ _('Usuários ') }}<i class="fas fa-chevron-down smaller-arrow"></i></a></a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getUser') }}">{{ _('Todos os Usuários') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>