@extends('errors::minimal')
@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('We are sorry. the page you requested was not found'))
@section('image')
    <img src="{{ asset('images/errors/404.jpg') }}" alt="404 Error" width="400">
@endsection
