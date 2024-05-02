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
        </h1>
        <form action="{{ route('reports.product') }}" method="GET">
            <div class="form-row">                                            
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Nome') }}">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" name="price" placeholder="{{ __('Preço') }}">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" name="sku" placeholder="{{ __('Sku') }}">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="description" placeholder="{{ __('Descrição') }}">
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
                                <th>{{ __('Preço') }}</th>
                                <th>{{ __('sku') }}</th>
                                <th>{{ __('Descrição') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="float-right">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paginator as $product)
                                <tr class="custom-row">
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>{{ $product['sku'] }}</td>
                                    <td>{!! Illuminate\Support\Str::limit($product['description'], $limit = 70, $end = '...') !!}</td>
                                    <td>{{ $product['status'] == 1 ? __('Habilitado') : __('Desabilitado') }}</td>
                                    <td>
                                        <a href="{{ url('/editProduct/' . $product['id']) }}" class="btn btn-primary btn-sm float-right">{{ __('Editar') }}</a>
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
