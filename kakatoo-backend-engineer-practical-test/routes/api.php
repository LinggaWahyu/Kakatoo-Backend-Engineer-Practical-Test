<?php

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

Route::group([
    'middleware' => 'role:all',
], function ($router) {
    Route::post('/auth/login', [App\Http\Controllers\UserController::class, 'login'])->name('user-login')->withoutMiddleware('role:all');
    Route::get('/auth/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('user-logout');
    Route::get('/auth/user', [App\Http\Controllers\UserController::class, 'show'])->name('user-profile');

    Route::get('/activities/{skill_id}', [App\Http\Controllers\ActivityController::class, 'index'])->name('activity-list');

    Route::get('/skills', [App\Http\Controllers\SkillController::class, 'index'])->name('skill-list');

    Route::get('/profiles', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile-list');

    Route::get('/activities', [App\Http\Controllers\ActivityController::class, 'getAll'])->name('activity-list');

    Route::get('/users/{skill_id}', [App\Http\Controllers\UserController::class, 'index'])->name('user-list-by-skill_id');
});

Route::group([
    'middleware' => 'role:board',
], function ($router) {
    Route::post('/user', [App\Http\Controllers\UserController::class, 'register'])->name('user-register');
});

Route::group([
    'middleware' => 'role:expert',
    'prefix' => 'activity'
], function ($router) {
    Route::post('/', [App\Http\Controllers\ActivityController::class, 'store'])->name('activity-create');
    Route::put('/{id}', [App\Http\Controllers\ActivityController::class, 'update'])->name('activity-update');
    Route::delete('/{id}', [App\Http\Controllers\ActivityController::class, 'destroy'])->name('activity-delete');
    Route::get('/{id}', [App\Http\Controllers\ActivityController::class, 'show'])->name('activity-detail');
});

