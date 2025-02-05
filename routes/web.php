<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('last-fm.user_info');
});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/toggle-theme', function (Request $request) {
    $data = json_decode($request->getContent(), true);
    $theme = $data['theme'] ?? 'light';
    session(['theme' => $theme]);

    return response()->noContent();
})->middleware('web');

require __DIR__.'/last_fm.php';
require __DIR__.'/auth.php';
