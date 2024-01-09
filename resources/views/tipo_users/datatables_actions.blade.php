{!! Form::open(['route' => ['tipoUsers.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('tipoUsers.show', $id) }}" class='btn btn-success pl-3'><i class="fa fa-info"></i>
    </a>
    <a href="{{ route('tipoUsers.edit', $id) }}" class='btn btn-warning pr-2'><i
                                class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash-o"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
