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
            {{ __('Clientes') }}
            <a href="{{ route('createCustomer') }}" class="btn btn-primary float-right">{{ __('Cadastrar') }}</a>
        </h1>
        <form action="{{ route('reports.customer') }}" method="GET">
            <div class="form-row">                                            
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Nome') }}">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="email" placeholder="{{ __('E-mail') }}">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="phone_number" placeholder="{{ __('Contato') }}">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" name="cnpj_cpf" placeholder="{{ __('CNPJ/CPF') }}">
                </div>
                <div class="form-group col-md-1">
                    <button type="submit" class="btn btn-primary">{{ _('Filtrar') }}</button>
                </div>
            </div>
        </form>
        @if (!is_null($paginator) && count($paginator) > 0)
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Contato') }}</th>
                                <th>{{ __('Aniversário') }}</th>
                                <th>{{ __('CPF/CNPJ') }}</th>
                                <th>{{ __('RG/IE') }}</th>
                                <th>{{ __('Sexo') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="float-right">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator as $customer)
                                <tr class="custom-row">
                                    <td>{{ $customer['name'] }}</td>
                                    <td>{{ $customer['email'] }}</td>
                                    <td>{{ $customer['phone_number'] }}</td>
                                    <td>{{ $customer['birth_date'] }}</td>
                                    <td>{{ $customer['cnpj_cpf'] }}</td>
                                    <td>{{ $customer['rg_ie'] }}</td>
                                    <td>{{ $customer['sex'] === 'M' ? 'Masculino' : 'Feminino' }}</td>
                                    <td>{{ $customer['status'] == 1 ? __('Habilitado') : __('Desabilitado') }}</td>
                                    <td>
                                        <a href="{{ url('/editCustomer/' . $customer['id']) }}" class="btn btn-primary btn-sm float-right">{{ __('Editar') }}</a>
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
            <div class="alert alert-info" role="alert">{{ __('Não há clientes disponíveis.') }}</div>
        @endif
    </div>
@endsection
