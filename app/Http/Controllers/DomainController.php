<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DomainController extends Controller
{
    public function index()
    {
        $domains = DB::table('domains')
                    ->distinct('domains.id')
                    ->select('domains.id', 'domains.name', 'domain_checks.status_code', DB::raw('MAX(domain_checks.updated_at) as updated_at'))
                    ->leftJoin('domain_checks', 'domains.id', '=', 'domain_checks.domain_id')
                    ->groupBy('domains.id', 'domain_checks.status_code')
                    ->paginate(10);

        return view('domain.index', compact('domains'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')
                ->where('id', '=', $id)
                ->get();

        $domain_checks = DB::table('domain_checks')
                        ->where('domain_id', '=', $id)
                        ->paginate(10);

        return view('domain.show', compact('domain', 'domain_checks'));
    }

    public function store(Request $request)
    {
        $requiredValidator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($requiredValidator->fails()) {
            $requiredValidator->validate();
        }
        $uniqueValidator = Validator::make($request->all(), [
            'name' => 'unique:domains',
        ]);
        if ($uniqueValidator->fails()) {
            $normalized = $this->normalizeUrl($request->name);
            $domain = DB::table('domains')
                                ->where('name', '=', $normalized)
                                ->get();
            $id = $domain[0]->id;
            flash('This url already exists')->error();
            return redirect()
                    ->route('domains.show', ['id' => $id])
                    ->withErrors($uniqueValidator)
                    ->withInput();
        }
        $data = $uniqueValidator->validate();
        $normalized = $this->normalizeUrl($data['name']);
        DB::table('domains')->insert(
            [
                'name' => $normalized,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        );
        $domain = DB::table('domains')
                            ->where('name', '=', $normalized)
                            ->get();
        $id = $domain[0]->id;

        flash('Url has been added')->success();
        return redirect()
                    ->route('domains.show', ['id' => $id]);
    }

    public function normalizeUrl($url)
    {
        $parsedUrl = parse_url($url);
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $path     = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        return "{$scheme}{$host}{$path}";
    }

    public function createCheck(Request $request, $id)
    {
        $domain = DB::table('domains')
                        ->where('id', '=', $id)
                        ->get();

        if ($domain !== null) {
            try {
                $status = Http::get($domain[0]->name)->status();
                DB::table('domain_checks')->insert(
                    [
                        'domain_id' => $id,
                        'status_code' => $status,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]
                );
            } catch (Throwable $e) {
                flash($e->getMessage())->error();
                return redirect()
                    ->route('domains.show', ['id' => $id]);
            }
        }
        flash('Site has been cheked')->success();
        return redirect()
            ->route('domains.show', ['id' => $id]);
    }
}
