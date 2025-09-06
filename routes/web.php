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

// API Documentation Route
Route::get('/api/documentation', function () {
    return view('swagger-ui');
});

// API Docs JSON Route
Route::get('/api-docs.json', function () {
    $apiDocs = file_get_contents(storage_path('api-docs/api-docs.json'));
    return response($apiDocs)->header('Content-Type', 'application/json');
});

// Swagger UI Route
Route::get('/swagger', function () {
    return view('swagger-ui');
});