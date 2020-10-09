<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $comment->description }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $comment->status }}</p>
</div>

<!-- Author Id Field -->
<div class="form-group">
    {!! Form::label('author_id', 'Author Id:') !!}
    <p>{{ $comment->author_id }}</p>
</div>

<!-- Phone Id Field -->
<div class="form-group">
    {!! Form::label('phone_id', 'Phone Id:') !!}
    <p>{{ $comment->phone_id }}</p>
</div>
