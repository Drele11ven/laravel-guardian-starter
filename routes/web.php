<?php

use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\SiteCoreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::controller(SiteCoreController::class)->group(function () {
    //Site routes here
});
Route::middleware(['auth','role:مهمان'])->group(function () {
    //Guest routes here
});
Route::middleware(['auth','role:دانشجو'])->group(function () {
    //Students routes here
});
Route::middleware(['auth','role:استاد'])->group(function () {
    //Professor routes here
});
Route::middleware(['auth','role:ادمین سایت'])->group(function () {
    //Admin routes here
});

require __DIR__.'/auth.php';
