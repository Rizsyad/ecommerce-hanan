@extends('template.template')

@section('title', 'Dashboard')

@section('head')
    
@endsection

@section('content')
    ini untuk semua role: role kamu adalah 

    @auth
        <b>{{ auth()->user()->getRoleNames()->first() }}</b> 
    @endauth
@endsection

@section('footer')
    
@endsection