@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Мошенники</h1>
        <h1 class="pull-right">
            <div class="input-group">
                <input type="text" name="q" id="phones-table-search" class="form-control" placeholder="Поиск...">
            </div>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('phones.table')
            </div>
        </div>
        <div class="text-center">

{{--            @include('adminlte-templates::common.paginate', ['records' => $phones])--}}

        </div>
    </div>
@endsection
