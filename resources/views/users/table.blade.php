@section('css')
    <link href="{{asset('datatable/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/loader.css')}}" rel="stylesheet">
@endsection

@push('scripts')
    <script src="{{asset('js/admin/users.js')}}"></script>
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
@endpush

<div class="table-responsive">
    <div id="loader" class="text-center">
        <div class="lds-roller">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <table class="table" id="users-table" style="display: none">
        <thead>
        <tr>
            <th class="name">Логин</th>
            <th class="email">Email</th>
            <th class="comments">Комментарии</th>
            <th class="created_at">Дата регистрации</th>
            <th class="action">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->comments->count() }}</td>
                <td data-order="{{$user->created_at->format('Y-m-d H:i:s')}}">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-default btn-xs'><i
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
