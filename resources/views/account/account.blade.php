@extends('layouts.app')
@section('content')
    <div class="container account-content">
        <h1 class="title">{{ _('Minha Conta') }}</h1>
        @if(session('errors'))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach(session('errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif            
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div id="message-info" class="alert alert-warning" role="alert" style="display: none"></div>
        <div class="row">
            <div class="col-lg-3 margin-bottom-40">
                <div class="list-group">
                    <a href="#my-account" id="link-my-account" class="list-group-item list-group-item-action active border-none">
                        {{ _('Minha Conta') }}
                    </a>
                    <a href="#my-address" id="link-my-address" class="list-group-item list-group-item-action border-none">{{ _('Meus Endereços') }}</a>
                    <a href="#my-orders" id="link-my-orders" class="list-group-item list-group-item-action border-none">{{ _('Meus Pedidos') }}</a>
                    <a href="#my-password" id="link-my-password" class="list-group-item list-group-item-action border-none">{{ _('Alterar Senha') }}</a>                    
                </div>
            </div>
            <div class="col-lg-9">
                <div id="my-account" class="content-section">
                    @include('partials.my-account', ['data' => $data])
                </div>
                <div id="my-address" class="content-section" style="display:none;">
                    @include('partials.my-address', ['addresses' => $addresses])
                </div>
                <div id="my-orders" class="content-section" style="display:none;">
                    @include('partials.my-orders')
                </div>
                <div id="my-password" class="content-section" style="display:none;">
                    @include('partials.my-password')
                </div>
            </div>
        </div>
    </div>
@endsection