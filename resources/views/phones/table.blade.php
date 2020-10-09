<div class="table-responsive">
    <table class="table" id="phones-table">
        <thead>
        <tr>
            <th>Number</th>
            <th>Name</th>
            <th>Author</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($phones as $phone)
            <tr>
                <td>{{ $phone->number }}</td>
                <td>{{ $phone->name }}</td>
                <td>
                    {{ $phone->author->name }}
                    <a href="{{ route('users.show', [$phone->author->id]) }}" class='btn btn-default btn-xs'><i
                            class="glyphicon glyphicon-eye-open"></i></a>
                </td>
                <td>
                    {!! Form::open(['route' => ['phones.destroy', $phone->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('phones.show', [$phone->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('phones.edit', [$phone->id]) }}" class='btn btn-default btn-xs'><i
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
