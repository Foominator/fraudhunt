<div class="table-responsive">
    <table class="table" id="comments-table">
        <thead>
        <tr>
            <th>Description</th>
            <th>Status</th>
            <th>Author</th>
            <th>Phone</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td style="width:75%;">{{ $comment->description }}</td>
                <td>{{ $comment->status }}</td>
                <td>
                    {{ $comment->author->name }}
                </td>
                <td>
                    <a href="{{ route('phones.show', [$comment->phone->id]) }}" class='btn btn-default btn-xs'><i
                            class="glyphicon glyphicon-eye-open"></i></a>
                    {{ $comment->phone->number }}
                </td>
                <td>
                    {!! Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('comments.show', [$comment->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('comments.edit', [$comment->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
