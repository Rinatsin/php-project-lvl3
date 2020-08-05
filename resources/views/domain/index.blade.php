@extends("layouts.app");

@section('content')
<div class="container text-center">
<h2>Domains</h2>
<table class="table">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Last check</td>
        <td>Status code</td>
    </tr>
    @foreach ($domains as $domain)
    <tr>
        <td>{{$domain->id}}</td>
        <td><a href="{{ route('domains.show', ['id' => $domain->id]) }}">{{ $domain->name }}</a></td>
        @if (isset($lastDomainChecks[$domain->id]))
            <td>{{$lastDomainChecks[$domain->id]->status_code}}</td>
            <td>{{$lastDomainChecks[$domain->id]->last_check}}</td>
        @else
            <td></td>
            <td></td>
        @endif
    </tr>
    @endforeach
</table>
<div>{{ $domains->links() }}</div>
</div>
@endsection
