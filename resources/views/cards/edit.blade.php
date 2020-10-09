@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Card
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($card, ['route' => ['cards.update', $card->id], 'method' => 'patch']) !!}

                        @include('cards.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection