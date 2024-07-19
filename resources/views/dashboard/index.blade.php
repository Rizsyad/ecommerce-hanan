@extends('components.template')

@section('title', 'Dashboard')

@section('head')
    
@endsection

@section('content')
    ini dashboard untuk semua role: role kamu adalah <b>{{ auth()->user()->getRoleNames()->first() }}</b> 
@endsection

@section('footer')
    
@endsection