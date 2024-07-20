@extends('template.template_home')

@section('title', 'Selling Farmer and vegetables')

@section('head')
    
@endsection

@section('content')
    @include('components.featured')
    @include('components.categories')
    @include('components.products-with-title', ['title' => 'Farmer Products'])
@endsection

@section('footer')
    
@endsection