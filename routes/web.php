<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── CANDIDATURES ─────────────────────────────────────────
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
    Route::get('/candidatures/create', [CandidatureController::class, 'create'])->name('candidatures.create');
    Route::post('/candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::get('/candidatures/archives', [CandidatureController::class, 'archives'])->name('candidatures.archives');
    Route::get('/candidatures/{candidature}', [CandidatureController::class, 'show'])->name('candidatures.show');
    Route::get('/candidatures/{candidature}/edit', [CandidatureController::class, 'edit'])->name('candidatures.edit');
    Route::put('/candidatures/{candidature}', [CandidatureController::class, 'update'])->name('candidatures.update');
    Route::delete('/candidatures/{candidature}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
    Route::post('/candidatures/{id}/restore', [CandidatureController::class, 'restore'])->name('candidatures.restore');
    Route::delete('/candidatures/{id}/force-delete', [CandidatureController::class, 'forceDestroy'])->name('candidatures.force-destroy');
    Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class, 'updateStatut'])->name('candidatures.statut');

    // ── ENTRETIENS ───────────────────────────────────────────
    Route::get('/entretiens', [EntretienController::class, 'index'])->name('entretiens.index');
    Route::get('/entretiens/avenirs/', [EntretienController::class, 'avenirs'])->name('entretiens.avenirs');
    Route::post('/candidatures/{candidature}/entretiens', [EntretienController::class, 'store'])->name('entretiens.store');
    Route::get('/entretiens/{entretien}/edit', [EntretienController::class, 'edit'])->name('entretiens.edit');
    Route::put('/entretiens/{entretien}', [EntretienController::class, 'update'])->name('entretiens.update');
    Route::delete('/entretiens/{entretien}', [EntretienController::class, 'destroy'])->name('entretiens.destroy');
});

require __DIR__.'/auth.php';
