<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// header('Access-Control-Allow-Origin: http://localhost:3000');
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
 
    $user->tokens()->delete();
    if ($user->email == 'admin@ideas.com') {
        $response = [
            'token' => $user->createToken($request->device_name, ['server:update', 'idea:create'])->plainTextToken,
            'username' => $user->name,
            'rights' => ['server:update', 'idea:create']
        ];
        return $response;
    }

    $response = [
        'token' => $user->createToken($request->device_name, ['idea:create'])->plainTextToken,
        'username' => $user->name,
        'rights' => ['idea:create']
    ];
    return $response;
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);
 
    $user = new User;
 
    if (empty($request->email) || empty($request->password) || User::where('email', $request->email)->first()) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    } else {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }
 
    $response = [
        'token' => $user->createToken($request->device_name, ['idea:create'])->plainTextToken,
        'username' => $user->name,
        'rights' => ['idea:create']
    ];
    return $response;
});

Route::get('/idea/all', 'App\Http\Controllers\IdeaController@showAll');
Route::get('/idea/random', 'App\Http\Controllers\IdeaController@random');
Route::get('/idea/index/{id}', 'App\Http\Controllers\IdeaController@index');

// Route::middleware('auth:sanctum')->get('/idea/all/likes', 'App\Http\Controllers\IdeaController@getUserLikes');

Route::middleware('auth:sanctum')->post('/idea/delete', 'App\Http\Controllers\IdeaController@remove');

Route::middleware('auth:sanctum')->post('/idea/like', 'App\Http\Controllers\IdeaController@add_like');

Route::middleware('auth:sanctum')->post('/idea/create', 'App\Http\Controllers\IdeaController@create');