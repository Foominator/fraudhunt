@extends('main.layouts.app')

@section('title', 'Добавить мошенника')

@section('content')
    <div class="container pt-4">
        <create-fraud
            :routes="{{json_encode($routes)}}"
            :translations="{{json_encode(\Illuminate\Support\Facades\Lang::get('create_fraud'))}}"
        ></create-fraud>
    </div>
@endsection
