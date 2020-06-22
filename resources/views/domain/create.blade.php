{{ Form::open(['route' => 'domains.store', 'class' => 'form-inline']) }}
<div class="input-group">
{{ Form::text('name', null, ['class' => 'form-control', 'type' => 'text', 'size' => '60', 'placeholder' => 'https://www.example.com']) }}
<div class="input-group-btn">
{{ Form::submit('Check', ['class' => 'btn btn-danger']) }}
</div>
</div>
{{ Form::close() }}
