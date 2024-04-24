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
            {{ __('Produtos') }}
            <a href="{{ route('createProducts') }}" class="btn btn-primary float-right">{{ __('Cadastrar') }}</a>
        </h1>  
        @if (count($paginator) > 0)
            <div class="card shadow-sm">        
                <div style="overflow-x:auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Nome') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="float-right">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator as $product)
                                <tr class="custom-row">
                                    <td>{{ $product['id'] }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <!--<td>{!! Illuminate\Support\Str::limit($product['description'], $limit = 10, $end = '...') !!}</td>-->
                                    <td>{{ $product['status'] == 1 ? 'Habilitado' : 'Desabilitado' }}</td>
                                    <td>
                                        <a href="{{ route('editProduct', ['id' => $product['id']]) }}" class="btn btn-primary btn-sm float-right">{{ __('Editar') }}</a>
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
            <div class="alert alert-info" role="alert">{{ __('Não há produtos disponíveis.') }}</div>
        @endif
    </div>
@endsection
