@extends("layouts.app");

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Page Analyzer
        </div>
        <div class="links m-b-md">
            Check web pages for free
        </div>

        {{ Form::open(['route' => 'store'], ['class' => 'justify-content-center']) }}
            {{ Form::text('name', 'https://www.example.com', ['class' => 'form-control form-control-lg m-b-md']) }}
            {{ Form::submit('Check', ['class' => 'btn btn-lg btn-primary ml-3 px-5 text-uppercase']) }}
        {{ Form::close() }}

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
