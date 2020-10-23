@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Пользователи
            <small>
            <a href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Создать</a>
            </small>
        </h1>
        <h1 class="pull-right">
            <div class="input-group">
                <input type="text" name="q" id="users-table-search" class="form-control" placeholder="Поиск...">
            </div>
        </h1>
    </section>
    <br>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body" style="padding-top: 0">
                @include('users.table')
            </div>
        </div>
        <div class="text-center">

{{--            @include('adminlte-templates::common.paginate', ['records' => $users])--}}

        </div>
    </div>
@endsection
