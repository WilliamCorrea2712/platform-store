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
                        <li class="nav-item">
                            <a class="nav-link" href="#">Editar Clientes</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link products-toggle" href="#">Produtos</a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getCategories') }}">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getBrands') }}">Marcas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getProducts') }}">Produto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Estoque</a>
                        </li>
                    </ul>
                </li>                
                <li class="nav-item">
                    <a class="nav-link users-toggle" href="#">Usuários</a>
                    <ul class="submenu" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('getUser') }}">Todos os Usuários</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('createUser') }}">Cadastrar Usuários</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const usersToggle = document.querySelector('.users-toggle');
        const productsToggle = document.querySelector('.products-toggle');
        const customersToggle = document.querySelector('.customers-toggle');

        const usersSubmenu = usersToggle.nextElementSibling;
        const productsSubmenu = productsToggle.nextElementSibling;
        const customersSubmenu = customersToggle.nextElementSibling;

        usersSubmenu.style.display = 'none';
        productsSubmenu.style.display = 'none';
        customersSubmenu.style.display = 'none';

        usersToggle.addEventListener('click', function(event) {
            event.preventDefault();
            toggleSubmenu(usersSubmenu);
            resetSelected();
            usersToggle.classList.add('selected');
        });

        productsToggle.addEventListener('click', function(event) {
            event.preventDefault();
            toggleSubmenu(productsSubmenu);
            resetSelected();
            productsToggle.classList.add('selected');
        });

        customersToggle.addEventListener('click', function(event) {
            event.preventDefault();
            toggleSubmenu(customersSubmenu);
            resetSelected();
            customersToggle.classList.add('selected');
        });

        function toggleSubmenu(submenu) {
            if (submenu.style.display === 'none') {
                submenu.style.display = 'block';
            } else {
                submenu.style.display = 'none';
            }
        }

        function resetSelected() {
            const selectedLinks = document.querySelectorAll('.nav-link.selected');
            selectedLinks.forEach(link => {
                link.classList.remove('selected');
            });
        }
    });
</script>
