<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware('auth');

Route::get('/modelos', function() {
    return view('app.modelos');
})->name('modelos')->middleware('auth');

Route::get('/veiculos', function() {
    return view('app.veiculos');
})->name('veiculos')->middleware('auth');

Route::get('/veiculo/{id}', function() {
    return view('app.veiculo');
})->name('veiculo')->middleware('auth');

Route::get('/grupos', function() {
    return view('app.grupos');
})->name('grupos')->middleware('auth');

Route::get('/perfil', function() {
    return view('app.perfil');
})->name('perfil')->middleware('auth');

Route::get('/alugados', function() {
    return view('app.alugados');
})->name('alugados')->middleware('auth');

Route::get('/avaliar/{id}', function() {
    return view('app.avaliar');
})->name('avaliar')->middleware('auth');

