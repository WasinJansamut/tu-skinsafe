<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MobileMenuController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\UserController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/questionnaire', [QuestionnaireController::class, 'index'])->name('questionnaire.index');
Route::post('/questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
Route::post('/participant/register', [UserController::class, 'participant_register'])->name('participant.register');

Route::middleware(['auth'])->group(function () {
    Route::prefix('app')->name('app.')->group(function () {
        Route::get('/upload', [MobileMenuController::class, 'upload'])->name('upload');
        Route::get('/library', [MobileMenuController::class, 'library'])->name('library');
        Route::get('/consent', [MobileMenuController::class, 'consent'])->name('consent');
        Route::get('/access', [MobileMenuController::class, 'access'])->name('access');
        Route::get('/history', [MobileMenuController::class, 'history'])->name('history');
        Route::get('/about', [MobileMenuController::class, 'about'])->name('about');
        Route::get('/status', [MobileMenuController::class, 'status'])->name('status');
        Route::get('/system-overview', [MobileMenuController::class, 'systemOverview'])->name('system_overview');
        Route::post('/system-overview/complete', [MobileMenuController::class, 'completeSystemOverview'])->name('system_overview.complete');
        Route::get('/notifications', [MobileMenuController::class, 'notifications'])->name('notifications');
        Route::get('/shares', [MobileMenuController::class, 'shares'])->name('shares');
    });

    Route::prefix('questionnaire')->group(function () {
        Route::get('/responses', [QuestionnaireController::class, 'responses'])->name('questionnaire.responses');
        Route::get('/responses/{id}', [QuestionnaireController::class, 'showResponse'])->name('questionnaire.responses.show');
        Route::get('/summary', [QuestionnaireController::class, 'summary'])->name('questionnaire.summary');
    });

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
