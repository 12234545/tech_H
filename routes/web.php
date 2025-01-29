<?php
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\SavedPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedArticleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ArticleHistoryController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;

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

Route::get('/ourService', [HomeController::class,'ourService'])
       ->name('app_ourService');


Route::get('/choix', [HomeController::class,'choix'])
       ->name('app_choix');

Route::get('/choixSingUp', [HomeController::class,'choixSingUp'])
       ->name('app_choixSingUp');

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


Route::post('/comments/{article}', [CommentController::class, 'store'])
    ->name('comments.store');

Route::post('/commentReply/{comment}', [CommentController::class, 'storeCommentReply'])
    ->name('comments.storeReply');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');



Route::middleware(['auth'])->group(function () {
    Route::post('/save-article', [SavedArticleController::class, 'save'])
        ->name('articles.save');
    Route::get('/saved-articles', [SavedArticleController::class, 'index'])
        ->name('saved.articles');
    Route::delete('/unsave-article/{id}', [SavedArticleController::class, 'unsave'])
        ->name('articles.unsave');
});




Route::get('showFromNotification/{article}/{notification}', [ArticleController::class, 'showFromNotification'])
    ->name('Article.showFromNotification');



Route::post('/articles/{article}/rate', [ArticleController::class, 'rate'])->name('articles.rate');





Route::middleware(['auth'])->group(function () {
    Route::get('/article-history', [ArticleHistoryController::class, 'index'])
        ->name('article.history');

    Route::patch('/article-history/{id}', [ArticleHistoryController::class, 'updateStatus'])
        ->name('article.history.update');
});

Route::post('/article-history/search', [ArticleHistoryController::class, 'search'])
    ->name('article.history.search')
    ->middleware('auth');

Route::get('/article-history/show/{id}', [ArticleHistoryController::class, 'showSearchResult'])
    ->name('article.history.show')
    ->middleware('auth');


    Route::delete('/article-history/clear', [ArticleHistoryController::class, 'clearAll'])
    ->name('article.history.clear')
    ->middleware('auth');



    Route::post('/themes/{theme}/subscribe', [ThemeController::class, 'subscribe'])->name('themes.subscribe');

    Route::post('/themes', [ThemeController::class, 'store'])->name('themes.store');
    require __DIR__.'/adminauth.php';





    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

// Modifier un article
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');

