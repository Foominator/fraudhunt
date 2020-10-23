@section('css')
    <link href="{{asset('datatable/datatables.min.css')}}" rel="stylesheet">
@endsection

@push('scripts')
    <script src="{{asset('js/admin/comments.js')}}"></script>
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
@endpush

<div class="table-responsive">
    <table class="table text-center" id="comments-table">
        <thead>
        <tr>
            <th style="text-align: left">Описание</th>
            <th>Мошенник</th>
            <th>Тел. Мошенника</th>
            <th>Карты Мошенника</th>
            <th>Автор</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td style="width:40%;text-align: left">{{ $comment->description }}</td>

                @switch($comment->status)
                    @case('approved')
                    <td>Да</td>
                    @break

                    @case('declined')
                    <td>Нет</td>

                    @break
                    @default
                    <td></td>
                    @break
                @endswitch

                <td>
                    <a href="{{ route('phones.show', [$comment->phone->id]) }}" class='btn btn-default btn-xs'><i
                            class="glyphicon glyphicon-eye-open"></i></a>
                    {{ $comment->phone->number }}
                </td>
                <td>
                    @foreach($comment->cards as $card)
                        {{ $card->card_num }} <br>
                    @endforeach
                </td>

                <td>{{ $comment->author->name }}</td>
                <td>{{ $comment->created_at->format('d.m.Y H:i') }}</td>

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
