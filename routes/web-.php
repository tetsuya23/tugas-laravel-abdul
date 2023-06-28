<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthorController;
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
    
    Route::get('/',[HomeController::class,'index']);
    Route::get('/home',[HomeController::class, 'index']);
    Route::get('/', function () {
        return view('welcome');
    });

    

    Route::resource('publishers',PublisherController::class)->names([
        'index'=>'admin.publisher',
        'create'=>'publisher.create',
        'store'=>'publisher.store',
        'show'=>'publisher.show',
        'edit'=>'publisher.edit',
        'update'=>'publisher.update',
        'destroy'=>'publisher.destroy',

    ]);

    Route::resource('catalogs',CatalogController::class)->names([
        'index'=>'admin.catalog',
        'create'=>'catalog.create',
        'store'=>'catalog.store',
        'show'=>'catalog.show',
        'edit'=>'catalog.edit',
        'update'=>'catalog.update',
        'destroy'=>'catalog.destroy',

    ]);

    Route::resource('authors',AuthorController::class)->names([
        'index'=>'admin.author',

    ]);

});
