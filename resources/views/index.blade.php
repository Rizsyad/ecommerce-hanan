@extends('template.template_home')

@section('title', 'Dashboard')

@section('head')
    
@endsection

@section('content')

    @include('components.featured')

    @include('components.categories')

    {{-- nyalakan jika perlu --}}
    {{-- @include('components.offer')   --}}

    @include('components.products-with-title', ['title' => 'Trandy Products'])

    @include('components.subscribe')

    @include('components.products-with-title', ['title' => 'Just Arrived'])

    @include('components.vendor')

    {{-- @auth
        <b>{{ auth()->user()->getRoleNames()->first() }}</b> 
    @endauth --}}
    
@endsection

@section('footer')
    
@endsection