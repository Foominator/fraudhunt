<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['approved' => 'approved', 'declined' => 'declined'], null, ['class' => 'form-control']) !!}
</div>

<!-- Author Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('author_id', 'Author:') !!}
    {!! Form::select('author_id', $userItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_id', 'Phone:') !!}
    {!! Form::select('phone_id', $phoneItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('comments.index') }}" class="btn btn-default">Cancel</a>
</div>
