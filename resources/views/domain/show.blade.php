@extends("layouts.app");

@section('content')
<div class="container text-left">
<h2>Site: {{  $domain->name }}</h2>
<table class="table table-hover">
    <tr>
        <td>id</td>
        <td>{{  $domain->id }}</td>
    </tr>
    <tr>
        <td>name</td>
        <td>{{ $domain->name }}</td>
    </tr>
    <tr>
        <td>created_at</td>
        <td>{{ $domain->created_at }}</td>
    </tr>
    <tr>
        <td>updated_at</td>
        <td>{{ $domain->updated_at }}</td>
    </tr>
</table>
</div>
<div class="container text-left">
<h2>Checks</h2>
@include('check.create')
<table class="table">
    <tr>
        <td>check id</td>
        <td>status code</td>
        <td>h1</td>
        <td>keywords</td>
        <td>description</td>
        <td>check date</td>
    </tr>
@foreach ($domain_checks as $check)
    <tr>
        <td>{{  $check->id }}</td>
        <td>{{  $check->status_code }}</td>
        <td>{{  $check->h1 }}</td>
        <td>{{  $check->keywords }}</td>
        <td>{{  $check->description }}</td>
        <td>{{  $check->created_at }}</td>
    </tr>
@endforeach
</table>
<div>{{ $domain_checks->links() }}</div>
</div>
</div>
@endsection
