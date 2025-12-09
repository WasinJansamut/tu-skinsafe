<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // ข้อมูลผู้ใช้งาน
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/soft_delete/{id}', [UserController::class, 'soft_delete'])->name('user.soft_delete');
        // Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        // Route::get('/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
        Route::get('/my_profile/edit', [UserController::class, 'my_profile_edit'])->name('user.my_profile_edit');
        Route::post('/my_profile/update', [UserController::class, 'my_profile_update'])->name('user.my_profile_update');
    });
});
