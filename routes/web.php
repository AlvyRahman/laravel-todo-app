<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

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

Route::get('/', [TodoListController::class, 'index']);
Route::post('/saveItem', [TodoListController::class, 'saveItem'])->name('saveItem');
Route::post('/complete/{id}', [TodoListController::class, 'complete'])->name('complete');
Route::post('/remove/{id}', [TodoListController::class, 'remove'])->name('remove');
Route::post('/markAllComplete', [TodoListController::class, 'markAllComplete'])->name('markAllComplete');
Route::post('/markAllIncomplete', [TodoListController::class, 'markAllIncomplete'])->name('markAllIncomplete');
//Route::post('/editItem/{id}', [TodoListController::class, 'editItem'])->name('editItem');
