<?php

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

Route::post('/queue', 'App\Http\Controllers\QueueController@create')->name('queue.create');

Route::get('/{slug}/admin/setting', 'App\Http\Controllers\QueueController@adminSetting')->name('admin.setting');
Route::get('/{slug}/admin/counter', 'App\Http\Controllers\QueueController@adminCounter');
Route::post('/{slug}/admin/next', 'App\Http\Controllers\QueueController@adminNext');

Route::get('/{slug}/', 'App\Http\Controllers\QueueController@guestCounter');
Route::post('/{slug}/add', 'App\Http\Controllers\QueueController@guestAdd');

Route::get('/tiket/{code}', 'App\Http\Controllers\QueueController@view')->name('ticket.view');
