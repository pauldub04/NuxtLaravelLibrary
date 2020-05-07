<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use \App\User;





Route::post('/get_token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
        /*return response([
            'message' => ['The provided credentials are incorrect.']
        ], 404);*/
    }
    //return $user->createToken($request->device_name)->plainTextToken;
    $token = $user->createToken($request->device_name)->plainTextToken;
    $response = [
        'role' => $user->role,
        'token' => $token,
        'email' => $user->email,
    ];
    return response($response, 201);
});



//Route::get('/book/all', 'BookController@all');
//Route::post('/book/add', 'BookController@add');

Route::middleware('auth:sanctum')->get('/book/all', 'BookController@all');
Route::middleware('auth:sanctum')->post('/book/add', 'BookController@add');
Route::middleware('auth:sanctum')->get('/book/delete/{id}', 'BookController@delete');
Route::middleware('auth:sanctum')->get('/book/change_availability/{id}', 'BookController@changeAvailability');