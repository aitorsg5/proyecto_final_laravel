<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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

//Route::get('/', HomeController::class)->name('home');
Route::get('/', function () {
    return redirect('/admin/login');
});

//Route::get('/blog', [PostController::class, 'index'])->name('posts.index');

//Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');


Route::get('/language/{locale}', function ($locale) {
    if (array_key_exists($locale, config('app.supported_locales'))) {
        session()->put('locale', $locale);
    }

    return redirect()->back();
})->name('locale');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});
Route::get('/storage/coches/{filename}', function ($filename) {
    $path = storage_path("app/public/coches/{$filename}");

    if (!file_exists($path)) {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }

   return response()->file($path, [
    'Access-Control-Allow-Origin' => '*',
    'Access-Control-Allow-Methods' => 'GET',
    'Access-Control-Allow-Headers' => 'Content-Type',
]);
});
