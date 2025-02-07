<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\AdminArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\Admin\Auth\AdminCommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SavedArticleController;
use App\Http\Controllers\ArticleHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;


Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);
});



Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminArticleController::class, 'index'])->name('admin.dashboard');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('admin.articles.store');
    Route::delete('/articles/{article}', [AdminArticleController::class, 'destroy'])->name('admin.articles.destroy');
    Route::get('logout', [LoginController::class, 'destroy'])->name('admin.logout');
    Route::get('/mesthemes', [ThemeController::class, 'myThemes'])->name('admin.mesthemes');
    Route::get('/themes/{theme}/articles', [ThemeController::class, 'showThemeArticles']) ->name('admin.theme.articles');
    Route::post('/comments/{article}', [AdminCommentController::class, 'store'])->name('admin.comments.store');
    Route::post('/commentReply/{comment}', [AdminCommentController::class, 'storeCommentReply'])->name('admin.comments.storeReply');
     Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');
     Route::get('/home', [HomeController::class, 'home'])->name('admin.home');
     Route::get('/about', [HomeController::class, 'about'])->name('admin.about');
     Route::post('/themes/{theme}/admin-subscribe', [ThemeController::class, 'adminSubscribe'])
    ->name('admin.themes.subscribe');

    Route::delete('/themes/{theme}/unsubscribe/{subscriberType}/{subscriberId}', [ThemeController::class, 'removeSubscriber'])
    ->name('admin.themes.unsubscribe');
});


 Route::get('showFromNotification/{article}/{notification}', [ArticleController::class, 'showFromNotification'])
    ->name('Article.showFromNotification');


Route::post('/articles/{article}/rate', [ArticleController::class, 'rate'])->name('articles.rate');










