<?php

use App\Http\Controllers\API\ClassesController;
use App\Http\Controllers\API\PlaylistController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\AppController;
use App\Http\Controllers\API\StudioController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PostGalleryController;
use App\Http\Controllers\API\TemplateController;
use App\Models\Studio;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('leads/{id}', [LeadController::class, 'getById']);
Route::get('leads/getAll/{user_id}', [LeadController::class, 'getAll']);
Route::put('leads/status/{id}/{status}', [LeadController::class, 'updateStatusById']);

Route::get('app/version-check', [AppController::class, 'versionCheck']);

Route::post('post-templates/save', [PostGalleryController::class, 'saveImage']);

Route::post('post-gallery/filter', [PostGalleryController::class, 'filter']);

Route::prefix('class')->group(function () {
    Route::get('by-studio/{studioID}', [ClassesController::class, 'classesByStudio']);
    Route::get('reschedule', [ClassesController::class, 'reschedule']);
});

Route::prefix('studios')->group(function () {
    Route::get('{studioID}/grid', [ClassesController::class, 'grid']);
    Route::get('{studioID}/calendar', [ClassesController::class, 'calendar']);
    Route::get('{studioID}/class/{classID}', [ClassesController::class, 'showClass']);
    Route::get('{studioID}/student/{studentID}', [ClassesController::class, 'showStudent']);
    Route::get('{studioID}/hide', [StudioController::class, 'hide']);
    Route::get('{studioID}/show', [StudioController::class, 'show']);
});

Route::prefix('users')->group(function () {
    Route::get('{userID}/delete', [UserController::class, 'delete']);
    Route::get('{userID}/requestSubscription', [UserController::class, 'requestSubscription']);
});

Route::get('/users/{userId}/delete', [UserController::class, 'deleteForm'])->name('users.delete-form');
Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');

Route::prefix('videos')->group(function () {
    Route::get('{accessLevel}', [VideoController::class, 'index']);
});

Route::prefix('playlists')->group(function () {
    Route::get('{accessLevel}', [PlaylistController::class, 'index']);
});
