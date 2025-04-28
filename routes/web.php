<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\TaskController;


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
// Route::get('/', function () {
//     return view('voters');
// });
// Route::get('/voters', [VotersController::class, 'index']);

Route::get('/voters', [VoterController::class, 'viewVoter']);
Route::get('/task', [TaskController::class, 'index'])->name('task.index');
Route::get('/task/create', [TaskController::class, 'create'])->name('task.create'); // Tambahkan ini
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::get('/task/{task}', [TaskController::class, 'show'])->name('task.show');
Route::get('/task/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
Route::put('/task/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/task/{task}', [TaskController::class, 'delete'])->name('task.delete');

