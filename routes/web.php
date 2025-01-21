<?php
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\SavedPostController;
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

Route::get('/', [HomeController::class,'home'])
       ->name('app_home');

Route::get('/about', [HomeController::class,'about'])
       ->name('app_about');

Route::get('/history', [HomeController::class,'history'])
       ->name('app_history')
       ->middleware('auth');

 Route::middleware(['auth'])->group(function () {
        Route::get('/saves', [SavedPostController::class, 'index'])->name('saves.index');
        Route::post('/saves', [SavedPostController::class, 'store'])->name('saves.store');
        Route::delete('/saves/{id}', [SavedPostController::class, 'destroy'])->name('saves.destroy');
 });

 Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

Route::match(['get','post'],'/dashboard',[HomeController::class,'dashboard'])
      ->middleware('auth')
      ->name('app_dashboard');

Route::get('/logOut',[logincontroller::class,'logOut'])
      ->name('app_logOut');


