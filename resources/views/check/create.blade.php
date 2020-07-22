{{ Form::open(['route' => ['domains.checks.store', $domain->id], 'class' => 'form-inline']) }}
{{ Form::submit('Run Check', ['class' => 'btn btn-success btn-lg']) }}
{{ Form::close() }}
