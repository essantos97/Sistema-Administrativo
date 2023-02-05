<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmpresaController;
use GuzzleHttp\Middleware;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/empresa/register/admin',[EmpresaController::class, 'adicionarAdmin'])->middleware('auth:empresa')->name('empresa.adicionar.admin');

Route::get('/admin/saque',function(){
    return view('admin.saque');
})->middleware('auth:web')->name('admin.saque');

Route::get('/admin/adicionar/conta',function(){
    return view('admin.adicionar-conta');
})->middleware('auth:web')->name('admin.adicionar.conta');

Route::get('/admin/verificar/conta',function(){
    return view('admin.verificar-conta');
})->middleware('auth:web')->name('admin.verificar.conta');

Route::post('/admin/saque',[AdminController::class, 'saque'])->middleware('auth:web')->name('admin.saque');
Route::post('/admin/adicionar/conta',[AdminController::class, 'adicionarConta'])->middleware('auth:web')->name('admin.adicionar.conta');
Route::post('/admin/verificar/conta',[AdminController::class, 'verificarConta'])->middleware('auth:web')->name('admin.verificar.conta');


Route::get('/empresa/venda', function(){
    return view('empresa.auth.venda');
    })->middleware('auth:empresa')->name('empresa.venda');
Route::post('/empresa/venda', [EmpresaController::class, 'vender'])->middleware('auth:empresa')->name('empresa.venda');


Route::get('/empresa/dashboard', [EmpresaController::class, 'index'])->middleware(['auth:empresa'])->name('empresa.dashboard');

require __DIR__.'/authempresa.php';
