<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web'])->group(function () {
    Auth::routes();
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'dashboard']);
        Route::get('/authors', [App\Http\Controllers\AuthorController::class, 'index']);
        Route::get('/members', [App\Http\Controllers\MemberController::class, 'index']);
        Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index']);

        Route::resource('/catalogs', App\Http\Controllers\CatalogController::class);
        Route::resource('/publishers', App\Http\Controllers\PublisherController::class);
        Route::resource('/authors', App\Http\Controllers\AuthorController::class);
        Route::resource('/members', App\Http\Controllers\MemberController::class);
        Route::resource('/books', App\Http\Controllers\BookController::class);
        
       
        
        Route::get('/api/authors', [App\Http\Controllers\AuthorController::class, 'api']);
        Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
        Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
        Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);
        Route::put('/api/books', [App\Http\Controllers\BookController::class, 'api']);
        
  
        
        
    });

});


