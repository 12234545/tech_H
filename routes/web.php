<?php
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\SavedPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

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



Route::match(['get','post'],'/dashboard',[HomeController::class,'dashboard'])
      ->middleware('auth')
      ->name('app_dashboard');

Route::get('/logOut',[logincontroller::class,'logOut'])
      ->name('app_logOut');


Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [ArticleController::class, 'index'])->name('dashboard');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::post('/articles/{article}/rate', [ArticleController::class, 'rate'])->name('articles.rate');
    });




Route::get('/articles/{article}/comments', [ArticleController::class, 'getComments'])->name('articles.comments.index');
Route::post('/articles/{article}/comments', [ArticleController::class, 'storeComment'])->name('articles.comments.store');


Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');






