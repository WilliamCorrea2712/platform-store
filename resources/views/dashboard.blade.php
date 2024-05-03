@extends('layouts.app')

@section('content')
    <div class="container">
        @if (!empty($errorProducts))
            <div class="alert alert-danger" role="alert">
                {{ $errorProducts }}
            </div>
        @endif
        @if (!empty($errorCustomers))
            <div class="alert alert-danger" role="alert">
                {{ $errorCustomers }}
            </div>
        @endif
        <h1 class="title">
            {{ __('Dashboard') }}
        </h1>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('Quantidade de Produtos') }}</h2>
                        <p class="card-text">{{ __('Total de Produtos:') }} {{ count($products) }}</p>
                        <p class="card-text">{{ __('Meta de Produtos: 300') }}</p>
                        <p class="card-text">{{ __('Porcentagem Atingida:') }} {{ number_format($percentAchieved, 2) }}%</p>
                        <canvas id="productsChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('Quantidade de Clientes') }}</h2>
                        <p class="card-text">{{ __('Total de Clientes:') }} {{ count($customers) }}</p>
                        <p class="card-text">{{ __('Masculino:') }} {{ $sexM }}</p>
                        <p class="card-text">{{ __('Feminino:') }} {{ $sexF }}</p>
                        <canvas id="clientsSexChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('Tipos de Clientes') }}</h2>
                        <p class="card-text">{{ __('Total de Clientes:') }} {{ count($customers) }}</p>
                        <p class="card-text">{{ __('Pessoa Fisica:') }} {{ $personF }}</p>
                        <p class="card-text">{{ __('Pessoa Juridica:') }} {{ $personJ }}</p>
                        <canvas id="clientsPersonChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">{{ __('Clientes por Estado') }}</h2>
                        <!--<canvas id="customersStateChart" width="400" height="400"></canvas>-->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctxProducts = document.getElementById('productsChart').getContext('2d');
        var productsChart = new Chart(ctxProducts, {
            type: 'pie',
            data: {
                labels: ['Produtos Recebidos', 'Meta'],
                datasets: [{
                    label: 'Quantidade de Produtos',
                    data: [{{ count($products) }}, 300],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)', 
                    'rgba(75, 192, 192, 0.2)', 
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)', 
                    'rgba(75, 192, 192, 1)',
                ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false, 
            }
        });

        var ctxClients = document.getElementById('clientsSexChart').getContext('2d');
        var clientsChart = new Chart(ctxClients, {
            type: 'pie',
            data: {
                labels: ['Masculino', 'Feminino'], 
                datasets: [{
                    label: 'Sexo dos Clientes',
                    data: [{{ $sexM }}, {{ $sexF }}],
                    backgroundColor: [
                        'rgba(255, 204, 128, 0.2)',
                        'rgba(128, 191, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 204, 128, 1)',
                        'rgba(128, 191, 255, 1)',
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false, 
            }
        });

        var ctxClients = document.getElementById('clientsPersonChart').getContext('2d');
        var clientsChart = new Chart(ctxClients, {
            type: 'pie',
            data: {
                labels: ['Fisica', 'Juridica'], 
                datasets: [{
                    label: 'Tipo dos Clientes',
                    data: [{{ $personF }}, {{ $personJ }}],
                    backgroundColor: [
                        'rgba(255, 153, 153, 0.2)',
                        'rgba(204, 153, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 153, 153, 1)', 
                        'rgba(204, 153, 255, 1)', 
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
            }
        });
 
        var ctx = document.getElementById('customersStateChart').getContext('2d');
        var customersStateChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($stateCustomers)) !!},
                datasets: [{
                    label: 'Clientes por Estado',
                    data: {!! json_encode(array_values($stateCustomers)) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    </script>
    
@endsection
