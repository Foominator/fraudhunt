@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Комментарии
        </h1>
        <h1 class="pull-right">
            <div class="input-group">
                <input type="text" name="q" id="comments-table-search" class="form-control" placeholder="Поиск...">
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
                @include('comments.table')
            </div>
        </div>
        <div class="text-center">

            {{--            @include('adminlte-templates::common.paginate', ['records' => $comments])--}}

        </div>
    </div>
@endsection
