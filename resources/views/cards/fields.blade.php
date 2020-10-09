<!-- Card Num Field -->
<div class="form-group col-sm-6">
    {!! Form::label('card_num', 'Card Num:') !!}
    {!! Form::text('card_num', null, ['class' => 'form-control','maxlength' => 20]) !!}
</div>

<!-- Comment Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comment_id', 'Comment Id:') !!}
    {!! Form::select('comment_id', $commentItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('cards.index') }}" class="btn btn-default">Cancel</a>
</div>
