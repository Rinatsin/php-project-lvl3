@extends("layouts.app");

@section('content')
    <div class="jumbotron text-center">
      <h1>Page Analyzer</h1>
      <p>Check web pages for free</p>
      {{ Form::open(['route' => 'domains.store', 'class' => 'form-inline']) }}
      <div class="input-group">
        {{ Form::text('name', null, ['class' => 'form-control', 'type' => 'text', 'size' => '60', 'placeholder' => 'https://www.example.com']) }}
        <div class="input-group-btn">
        {{ Form::submit('Check', ['class' => 'btn btn-danger']) }}
        </div>
      </div>
    {{ Form::close() }}
    </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection
