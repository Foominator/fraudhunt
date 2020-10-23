@section('css')
    <link href="{{asset('datatable/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/loader.css')}}" rel="stylesheet">
@endsection

@push('scripts')
    <script src="{{asset('js/admin/cards.js')}}"></script>
    <script src="{{asset('datatable/datatables.min.js')}}"></script>
@endpush

<div class="table-responsive">
    <table class="table" id="cards-table">
        <thead>
        <tr>
            <th class="card_num">Номер карты</th>
            <th class="phone">Номер мошенника</th>
            <th class="comment" style="width: 60%">Комментарий при добавлении</th>
            <th class="created_at">Дата добавления</th>
            <th class="actions">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cards as $card)
            <tr>
                <td>{{ $card->card_num }}</td>
                <td>{{ $card->comment->phone->number ?? '' }}</td>
                <td>{{ $card->comment->description }}</td>
                <td data-order="{{$card->created_at->format('Y-m-d H:i:s')}}">{{ $card->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    {!! Form::open(['route' => ['cards.destroy', $card->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cards.show', [$card->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('cards.edit', [$card->id]) }}" class='btn btn-default btn-xs'><i
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
