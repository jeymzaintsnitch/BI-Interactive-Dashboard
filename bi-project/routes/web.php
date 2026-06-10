<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessInt\DashboardController as BIDashboardController;

// ── Business Intelligence Dashboard Routes ────────────────────────
Route::get('/Dashboard', [BIDashboardController::class, 'Dashboard'])->name('bi.dashboard');
Route::post('/Dashboard', [BIDashboardController::class, 'Dashboard'])->name('bi.dashboard.filter');

Route::group(['prefix' => 'users'], function(){
        Route::get('/',[RegisterController::class, 'index'])->name('viewWeb');
        Route::post('/',[RegisterController::class, 'store'])->name('user.submit');
        Route::get('/edit/{ID}',[RegisterController::class, 'formEdit'])->name('user.edit');
        // add delete and update
        Route::delete('/delete/{ID}',[RegisterController::class, 'deleteuserbyID'])->name('delete.submit');
        Route::put('/edit/{ID}', [RegisterController::class, 'updateUser'])->name('edit.submit');

    });

