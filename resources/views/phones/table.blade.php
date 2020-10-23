@section('css')
    <link href="{{asset('datatable/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/loader.css')}}" rel="stylesheet">
@endsection

@push('scripts')
    <script src="{{asset('js/admin/phones.js')}}"></script>
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
@endpush

<div class="table-responsive">
    <table class="table" id="phones-table">
        <thead>
        <tr>
            <th class="number">Номер</th>
            <th class="author">Автор</th>
            <th class="comment">Комментарий автора</th>
            <th class="created_at">Дата добавления</th>
            <th class="actions">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($phones as $phone)
            <tr>
                <td>{{ $phone->number }}</td>
                <td>
                    <a href="{{ route('users.show', [$phone->author->id]) }}" class='btn btn-default btn-xs'><i
                            class="glyphicon glyphicon-eye-open"></i></a>
                    {{ $phone->author->email }}
                </td>
                <td style="width: 40%">{{ $phone->comments->first()->description }}</td>
                <td data-order="{{$phone->created_at->format('Y-m-d H:i:s')}}">{{ $phone->created_at->format('d.m.Y H:i') }}</td>
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
