@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-6 title">{{ __('Cadastrar Usuário') }}</h1>
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
                    <form action="{{ route('storeUser') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Nome:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Email:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Senha:') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
