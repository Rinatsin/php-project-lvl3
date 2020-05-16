@extends("layouts.app");

@section('content')
<h2>Site: {{  $domain[0]->name }}</h2>
<table>
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
@endsection
