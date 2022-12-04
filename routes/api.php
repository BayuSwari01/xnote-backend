<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\NoteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//jika mengakses dengan method post argumen register maka akan memanggil method register
Route::post('register', [AuthController::class, 'register']);

//jika mengakses dengan method post argumen login maka akan memanggil method login
Route::post('login', [AuthController::class, 'login']);

//jika posisi sudah login dan mengakses dengan method post argumen '/logout' maka akan memanggil method logout
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('getNote', [NoteController::class, 'getNotes']);

Route::post('addNote', [NoteController::class, 'addNote']);

Route::post('editNote', [NoteController::class, 'editNote']);

Route::post('deleteNote', [NoteController::class, 'deleteNote']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('getNote', [NoteController::class, 'getNotes']);
// });

// Route::get('test', function () {
//     User::create([
//         'name' => 'Bayu',
//         'email' => 'bayu@gmail.com',
//         'password' => 'admin123',
//     ]);
//     return User::all();
// });
