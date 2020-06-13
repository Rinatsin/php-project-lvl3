<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Throwable;
use URL\Normalizer as URLNormalizer;

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
            flash('This url already exists')->error();
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

    public function createCheck($id)
    {
        $domain = DB::table('domains')
                        ->where('id', '=', $id)
                        ->get();
        try {
            $document = new Document($domain[0]->name, true);
            $h1 = $document->has('h1') ? $document->first('h1')->text() : null;
            $keywordsElement = $document->first('meta[name=keywords]');
            $descriptionElement = $document->first('meta[name=description]');
            $keywords = $keywordsElement ? $keywordsElement->getAttribute('content') : null;
            $description = $descriptionElement ? $descriptionElement->getAttribute('content') : null;
            $status = Http::get($domain[0]->name)->status();
            DB::table('domain_checks')->insert(
                [
                    'domain_id' => $id,
                    'status_code' => $status,
                    'h1' => $h1,
                    'keywords' => $keywords,
                    'description' => $description,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]
            );
        } catch (Throwable $e) {
            flash($e->getMessage())->error();
            return redirect()
                ->route('domains.show', ['id' => $id]);
        }
        flash('Site has been cheked')->success();
        return redirect()
            ->route('domains.show', ['id' => $id]);
    }
}
