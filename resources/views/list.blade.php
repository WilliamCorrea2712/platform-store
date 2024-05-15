@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="title">{{ $nameList }}</h1>
        @include('partials.products-list', ['products' => $products])
    </div>
@endsection