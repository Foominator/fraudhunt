@extends('main.layouts.app')

@section('title', 'Мошенники')

@section('content')
    <div class="container pt-4">
        <search-fraud :frauds_count="{{$fraudsCount}}" :routes="{{json_encode($routes)}}"></search-fraud>
    </div>
@endsection
