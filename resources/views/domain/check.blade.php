{{ Form::open(['route' => ['domains.create_check', $domain[0]->id], 'class' => 'form-inline']) }}
{{ Form::submit('Run Check', ['class' => 'btn btn-success btn-lg']) }}
{{ Form::close() }}
