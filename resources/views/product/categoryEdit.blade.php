@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Editar') }}
            <button type="button" class="btn btn-success submit-form float-right" data-form-id="categoryForm">{{ __('Salvar') }}</button>
            @if(isset($categories[0]['id']))
                <button type="button" class="btn btn-danger delete-category float-right" data-category-id="{{ $categories[0]['id'] }}">Deletar</button>                                       
            @endif
        </h1>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(isset($categories[0]['id']))
                        <form id="categoryForm" action="{{ route('updateCategory', ['id' => $categories[0]['id']]) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="name">{{ __('Nome:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $categories[0]['name'] }}" required>
                                    </div>
                                    <!--<div class="form-group col-md-6">
                                        <label for="image">{{ __('Imagem:') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="image" name="image">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button">Upload</button>
                                            </div>
                                        </div>
                                    </div>-->                                
                                    <div class="form-group col-md-3">
                                        <label for="parent_id">{{ __('Categoria Pai:') }}</label>
                                        <select class="form-control" id="parent_id" name="parent_id">
                                            <option value="">{{ __('Selecione uma categoria pai') }}</option>
                                            @foreach($categoriesFather as $father)
                                                @if($categories[0]['id'] !== $father['id'])
                                                    <option value="{{ $father['id'] }}" @if($categories[0]['parent_id'] == $father['id']) selected @endif>{{ $father['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>                                                                
                                    <div class="form-group col-md-2">
                                        <label for="sort_order">{{ __('Ordem:') }}</label>
                                        <input type="text" class="form-control" id="sort_order" name="sort_order" value="{{ $categories[0]['sort_order'] }}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="status">{{ __('Status:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                        <input type="text" class="form-control" id="status" name="status" value="{{ $categories[0]['status'] }}">
                                    </div>
                                </div>  
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="description">{{ __('Descrição:') }}</label>
                                        <textarea class="form-control ckeditor" id="description" name="description">{{ $categories[0]['description'] }}</textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="meta_description">{{ __('Meta Descrição:') }}</label>
                                        <input type="text" class="form-control" id="meta_description" name="meta_description" value="{{ $categories[0]['meta_description'] }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="meta_title">{{ __('Meta Título:') }}</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $categories[0]['meta_title'] }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="meta_keyword">{{ __('Meta Palavra-chave:') }}</label>
                                        <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" value="{{ $categories[0]['meta_keyword'] }}">
                                    </div>
                                </div>                            
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info" role="alert">
                            {{ __('Categoria não encontrada!') }}
                            <a href="{{ route('getCategory') }}" class="btn btn-primary float-right">{{ __('Voltar') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
