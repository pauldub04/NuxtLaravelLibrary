<?php

use Illuminate\Support\Facades\Route;
use \App\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/book', function () {
    return view('spa');
});

Route::post('/book/add', 'BookController@add');
Route::get('/book/all', 'BookController@all');
Route::get('/book/delete/{id}', 'BookController@delete');
Route::get('/book/change_availability/{id}', 'BookController@changeAvailability');

Route::post('/get_token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});