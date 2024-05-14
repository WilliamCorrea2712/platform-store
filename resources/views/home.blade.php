@extends('layouts.app')
@section('content')
    @include('banner')        
    <div class="container">
        <h1 class="title">{{ $nameList }}</h1>
        @include('partials.products-list', ['products' => $products])
    </div>
@endsection
