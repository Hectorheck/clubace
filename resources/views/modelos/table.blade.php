<div class="table-responsive">
    <table class="table" id="modelos-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($modelos as $modelos)
            <tr>
                <td>{{ $modelos->id }}</td>
            <td>{{ $modelos->created_at }}</td>
            <td>{{ $modelos->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['modelos.destroy', $modelos->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('modelos.show', [$modelos->id]) }}" class='btn btn-success pl-3'><i class="fa fa-info"></i></a>
                        <a href="{{ route('modelos.edit', [$modelos->id]) }}" class='btn btn-warning pr-2'><i
                                class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
