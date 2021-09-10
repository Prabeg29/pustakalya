<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::prefix('v1')->group(function (){
    Route::prefix('auth')->group(function(){
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
    });
    Route::middleware('auth:sanctum')->group(function(){
        Route::prefix('auth')->group(function(){
            Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
                ->name('verification.send');
            Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
                ->name('verification.verify');
        });

        Route::post('/file-upload', [FileUploadController::class, 'upload']);
        Route::post('/books/search', [SearchController::class, 'search']);
        Route::apiResource('admin/books', AdminBookController::class);
        Route::apiResource('books', BookController::class)->only(['index', 'show']);
        Route::apiResource('books.reviews', BookReviewController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('users.books', UserBookController::class);
    });
});

Route::fallback(function(){
    return response()->json(
        [
            'message' => 'Page Not Found.'
        ],
        404);
});
