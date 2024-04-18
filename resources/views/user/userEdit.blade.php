@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Editar Usuário') }}</h1>
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
                    <form action="{{ route('updateUser', ['id' => $users[0]['id']]) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Nome:') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $users[0]['name'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email:') }}</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $users[0]['email'] }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Senha:') }}</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
