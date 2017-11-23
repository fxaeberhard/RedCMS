@extends('layouts.app')

@section('title', 'Page not found')

@section('content')

    <h1>Page Not Found</h1>
    <br>
    Unfortunately the page you are looking for could not be found.

    {{ $exception->getMessage() }}

@endsection
