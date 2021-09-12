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
Route::get('/tiket/', 'App\Http\Controllers\TicketController@index')
    ->name('ticket.index');
Route::match(['get','post'], '/tiket/{code}', 'App\Http\Controllers\TicketController@view')
    ->name('ticket.view')
    ->middleware('captcha_session_valid:ticket_code_expire');

// per-queue routing
Route::post('/{slug}/admin/login', 'App\Http\Controllers\QueueController@adminLogin')->name('admin.login');

Route::middleware(App\Http\Middleware\QueueAdminValidation::class)->group(function () {
    Route::get('/{slug}/admin/', 'App\Http\Controllers\QueueController@adminCounter')->name('admin.counter');
    Route::get('/{slug}/admin/setting', 'App\Http\Controllers\QueueController@adminSetting')->name('admin.setting');
    Route::post('/{slug}/admin/setting', 'App\Http\Controllers\QueueController@adminSettingUpdate')->name('admin.setting.update');
    Route::post('/{slug}/admin/next', 'App\Http\Controllers\QueueController@adminNext')->name('admin.next');
});

Route::get('/{slug}/', 'App\Http\Controllers\QueueController@guestCounter')->name('guest.counter');
Route::post('/{slug}/add', 'App\Http\Controllers\QueueController@guestAdd')->name('guest.add');

