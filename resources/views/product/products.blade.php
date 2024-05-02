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
            <a href="#" id="btnOpenCreatePopup" class="btn btn-primary float-right">{{ __('Cadastrar') }}</a>
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
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">{{ _('Cadastrar Produto') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="message-return" class="alert alert-warning" role="alert" style="display: none"></div>
                    <form id="createProductForm">
                        <div class="form-group">
                            <label for="productName">{{ _('Nome do Produto') }}</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="productPrice">{{ _('Preço') }}</label>
                                <input type="text" class="form-control" id="productPrice" name="productPrice" required pattern="\d+(\.\d{1)?" title="Formato válido: 13.9">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="productWeight">{{ _('Peso') }}</label>
                                <input type="text" class="form-control" id="productWeight" name="productWeight" required pattern="\d+(\.\d{1})?" title="Formato válido: 0.5">
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label for="productDescription">{{ _('Descrição') }}</label>
                            <textarea class="form-control" id="productDescription" name="productDescription" required></textarea>
                        </div>
                        <button type="submit" id="submitButton" class="btn btn-success">{{ _('Salvar') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
@endsection
