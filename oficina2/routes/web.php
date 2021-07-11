<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BudgetController;

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

Route::resource('/orcamento', BudgetController::class);
Route::post('/orcamento/search', [BudgetController::class, 'search'])->name('search');
