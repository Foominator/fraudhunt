@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Phone
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($phone, ['route' => ['phones.update', $phone->id], 'method' => 'patch']) !!}

                        @include('phones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection