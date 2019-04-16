<?php

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

Route::get('/', 'FrontendController@index')->name('frontend.index');
Route::get('landing', 'FrontendController@landing')->name('frontend.landing');
Route::post('landing', 'FrontendController@landingSubmit')->name('frontend.landingSubmit');