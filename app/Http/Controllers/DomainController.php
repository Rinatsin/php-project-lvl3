<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use URL\Normalizer as URLNormalizer;

class DomainController extends Controller
{
    public function index()
    {
        $lastCheck = DB::table('domain_checks')
                    ->select('updated_at')
                    ->whereColumn('domain_id', 'domains.id')
                    ->latest()
                    ->limit(1);
        $statusCode = DB::table('domain_checks')
                    ->select('status_code')
                    ->whereColumn('domain_id', 'domains.id')
                    ->latest()
                    ->limit(1);
        $domains = DB::table('domains')
                    ->select('id', 'name')
                    ->selectSub($lastCheck, 'last_check')
                    ->selectSub($statusCode, 'status_code')
                    ->paginate();
    //    $domains = DB::table('domains')
    //                ->distinct('domains.id')
    //                ->select('domains.id', 'domains.name', 'domain_checks.status_code', DB::raw('MAX(domain_checks.updated_at) as updated_at'))
    //                ->leftJoin('domain_checks', 'domains.id', '=', 'domain_checks.domain_id')
    //                ->groupBy('domains.id', 'domain_checks.status_code')
    //                ->paginate(10);
        return view('domain.index', compact('domains'));
    }

    public function show($id)
    {
        $domain = DB::table('domains')->find($id);

        $domain_checks = DB::table('domain_checks')
                        ->where('domain_id', '=', $id)
                        ->paginate(10);

        return view('domain.show', compact('domain', 'domain_checks'));
    }

    public function store(Request $request)
    {
        $urlNormalizer = new URLNormalizer($request->name);
        $normalizedUri = $urlNormalizer->normalize();
        $domain = DB::table('domains')
                    ->where('name', $normalizedUri)
                    ->first();

        if ($domain) {
            $id = $domain->id;
            flash('This url already exists')->warning();
            return redirect()
                    ->route('domains.show', ['id' => $id]);
        } else {
            $validatedData = Validator::make(['name' => $normalizedUri], [
                'name' => 'required|max:255',
            ])->validate();

            DB::table('domains')->insert(
                [
                    'name' => $validatedData['name'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]
            );
            $domain = DB::table('domains')
                    ->where('name', $normalizedUri)
                    ->first();
            $id = $domain->id;
            flash('Url has been added')->success();
            return redirect()
                        ->route('domains.show', ['id' => $id]);
        }
    }
}
