@extends("layouts.app");

@section('content')
<h2>Domains</h2>
<table>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Last check</td>
    </tr>
    @foreach ($domains as $domain)
    <tr>
        <td>{{$domain->id}}</td>
        <td><a href="{{ route('domains.show', ['id' => $domain->id]) }}">{{ $domain->name }}</a></td>
        <td>{{$domain->updated_at}}</td>
    </tr>
    @endforeach
</table>
@endsection
