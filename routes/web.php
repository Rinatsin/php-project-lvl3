<?php

use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/domains', 'DomainController@index')
    ->name('domains.index');

Route::post('/domains', 'DomainController@store')
    ->name('domains.store');

Route::get('/domains/{id}', 'DomainController@show')
    ->name('domains.show');

Route::post('/domains/{id}/checks', 'DomainCheckController@store')
    ->name('domains.checks.store');
