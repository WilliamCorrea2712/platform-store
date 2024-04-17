@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!empty($error))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="title">
            Todos Clientes
            <a href="{{ route('createCustomer') }}" class="btn btn-primary float-right">Cadastrar</a>
        </h1>        

        @if (count($paginator) > 0)
            <div class="card shadow-sm">        
                <div style="overflow-x:auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Contato</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator as $customer)
                                <tr>
                                    <td>{{ $customer['name'] }}</td>
                                    <td>{{ $customer['email'] }}</td>
                                    <td>{{ $customer['phone_number'] }}</td>
                                    <td>{{ $customer['status'] == 1 ? 'Habilitado' : 'Desabilitado' }}</td>

                                    <td>
                                        <a href="{{ url('/editCustomer/' . $customer['id']) }}" class="btn btn-primary btn-sm float-right">Editar</a>
                                    </td>                                                         
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $paginator->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @else
            <div class="alert alert-info" role="alert">
                Não há clientes disponíveis.
            </div>
        @endif
    </div>
@endsection
