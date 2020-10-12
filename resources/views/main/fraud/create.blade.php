@extends('main.layouts.app')

@section('title', 'Добавить мошенника')

@section('content')
    <div class="container pt-4">
        <create-fraud :routes="{{json_encode($routes)}}"></create-fraud>
    </div>
@endsection
