@extends('main.layouts.app')

@section('title', 'Мошенники')

@section('content')
    <div class="container pt-4">
        <search-fraud
            :frauds_count="{{$fraudsCount}}"
            :auth_check="{{json_encode(auth()->check())}}"
            :routes="{{json_encode($routes)}}"
            :translations="{{json_encode(\Illuminate\Support\Facades\Lang::get('frauds'))}}">
        </search-fraud>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('css/comments.css') }}" rel="stylesheet">
@endpush
