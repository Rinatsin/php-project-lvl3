@extends("layouts.app");

@section('content')
<div class="container text-left">
<h2>Site: {{  $domain[0]->name }}</h2>
<table class="table table-hover">
    <tr>
        <td>id</td>
        <td>{{  $domain[0]->id }}</td>
    </tr>
    <tr>
        <td>name</td>
        <td>{{ $domain[0]->name }}</td>
    </tr>
    <tr>
        <td>created_at</td>
        <td>{{ $domain[0]->created_at }}</td>
    </tr>
    <tr>
        <td>updated_at</td>
        <td>{{ $domain[0]->updated_at }}</td>
    </tr>
</table>
</div>
<div class="container text-left">
<h2>Checks</h2>
@include('domain.check')
<table class="table">
    <tr>
        <td>check id</td>
        <td>status code</td>
        <td>check date</td>
    </tr>
@foreach ($domain_checks as $check)
    <tr>
        <td>{{  $check->id }}</td>
        <td>{{  $check->status_code }}</td>
        <td>{{  $check->created_at }}</td>
    </tr>
@endforeach
</table>
<div>{{ $domain_checks->links() }}</div>
</div>
</div>
@endsection
