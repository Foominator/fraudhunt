<div class="table-responsive">
    <table class="table" id="cards-table">
        <thead>
        <tr>
            <th>Card Num</th>
            <th style="width: 70%">Comment</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cards as $card)
            <tr>
                <td>{{ $card->card_num }}</td>
                <td>{{ $card->comment->description }}</td>
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
