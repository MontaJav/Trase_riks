<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UsersController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/projekti', [ProjectController::class, 'index'])->name('projekti');
    Route::get('/projekti/{ID_projekts}/uzdevumi', [ProjectController::class, 'uzdevumi'])->name('projekti.uzdevumi');

    Route::get('/uzdevumi', [TaskController::class, 'index'])->name('uzdevumi');
    Route::get('/uzdevumi/createOrEdit/{ID_uzdevums?}', [TaskController::class, 'createOrEdit'])->name('uzdevumi.createOrEdit');
    Route::post('/uzdevumi/saglabat/{ID_uzdevums?}', [TaskController::class, 'store'])->name('uzdevumi.store');
    Route::get('/uzdevumi/{ID_pielikums}/download', [TaskController::class, 'download'])->name('uzdevumi.download');
    Route::get('/uzdevumi/{ID_pielikums}/deleteAttachment', [TaskController::class, 'deleteAttachment'])->name('uzdevumi.deleteAttachment');
    Route::get('/uzdevumi/{ID_komentars}/deleteComment', [TaskController::class, 'deleteComment'])->name('uzdevumi.deleteComment');

    Route::get('/kalendars', [CalendarController::class, 'index'])->name('kalendars');
    Route::get('/kalendars/diena/{diena}', [CalendarController::class, 'diena'])->name('kalendars.diena');

    Route::get('/laikauzskaite', [TimeController::class, 'index'])->name('laikauzskaite');
    Route::get('/laikauzskaite/uzdevums/{ID_uzdevums}', [TimeController::class, 'uzdevums'])->name('laikauzskaite.uzdevums');
    Route::get('/laikauzskaite/createOrEdit/{ID_uzdevums}/{ID_laikauzsk?}', [TimeController::class, 'createOrEdit'])->name('laikauzskaite.createOrEdit');
    Route::post('/laikauzskaite/saglabat/{ID_uzdevums}/{ID_laikauzsk?}', [TimeController::class, 'store'])->name('laikauzskaite.store');
    Route::get('/laikauzskaite/delete/{ID_laikauzsk}', [TimeController::class, 'destroy'])->name('laikauzskaite.get.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('projVad')->group(function () {
    Route::get('/projekti/create', function () {
        return view('projekti.form', ['projekts' => null]);
    })->name('projekti.create');
    Route::post('/projekti/saglabat/{ID_projekts?}', [ProjectController::class, 'store'])->name('projekti.store');
    Route::get('/projekti/delete/{ID_projekts}', [ProjectController::class, 'destroy'])->name('projekti.get.destroy');
    Route::post('/projekti/{ID_projekts}', [ProjectController::class, 'destroy'])->name('projekti.destroy');
    Route::get('/projekti/{ID_projekts}/edit', [ProjectController::class, 'edit'])->name('projekti.edit');

    Route::get('/lietotaji', [UsersController::class, 'index'])->name('lietotaji');
    Route::get('/lietotaji/create', [UsersController::class, 'create'])->name('lietotaji.create');
    Route::post('/lietotaji/saglabat/{ID_lietotajs?}', [UsersController::class, 'store'])->name('lietotaji.store');
    Route::get('/lietotaji/delete/{ID_lietotajs}', [UsersController::class, 'destroy'])->name('lietotaji.get.destroy');
    Route::post('/lietotaji/{ID_lietotajs}', [UsersController::class, 'destroy'])->name('lietotaji.destroy');
    Route::get('/lietotaji/{ID_lietotajs}/edit', [UsersController::class, 'edit'])->name('lietotaji.edit');

    Route::get('/uzdevumi/delete/{ID_uzdevums}', [TaskController::class, 'destroy'])->name('uzdevumi.get.destroy');
    Route::post('/uzdevumi/{ID_uzdevums}', [TaskController::class, 'destroy'])->name('uzdevumi.destroy');
});

require __DIR__.'/auth.php';
