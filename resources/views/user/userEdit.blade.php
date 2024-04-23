@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">
            {{ __('Editar') }}
            <button type="submit" class="btn btn-primary float-right">{{ __('Salvar') }}</button>
            @if(isset($users[0]['id']))
                <button type="button" class="btn btn-danger delete-user float-right" data-user-id="{{ $users[0]['id'] }}">Deletar</button>                                       
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
                    @if(isset($users[0]['id']))
                        <form action="{{ route('updateUser', ['id' => $users[0]['id']]) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('Nome:') }}  <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $users[0]['name'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('Email:') }}  <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $users[0]['email'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __('Senha:') }}  <span class="text-danger">{{ __('*') }}</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>                                
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info" role="alert">
                            {{ __('Usuario não encontrado!') }}
                            <a href="{{ route('getUser') }}" class="btn btn-primary float-right">{{ __('Voltar') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
