<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {
        $domains = DB::table('domains')->paginate();

        return view('domain.index', compact('domains'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')
                ->where('id', '=', $id)
                ->get();


        return view('domain.show', compact('domain'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:domains',
        ]);

        $parsedUrl = parse_url($data['name']);
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $path     = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $normalized = "{$scheme}{$host}{$path}";

        DB::table('domains')->insert(
            [
                'name' => $normalized,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        );

        flash('Url has been added')->success();
        return redirect('/');
    }
}
