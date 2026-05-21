<?php

use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\CandidatureController;
 use App\Http\Controllers\EntretienController;


Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function(){
// Routes pour le dashboard
    Route
    ::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Routes pour les candidatures
      // Liste des candidatures actives (avec filtres)
    Route::get('/candidatures',[CandidatureController::class,'index'])->name('candidatures.index');
    // Formulaire de création
    Route::get('/candidatures/create',[CandidatureController::class,'create'])->name('candidatures.create');
     // Enregistrement d'une nouvelle candidature
    Route::post('/candidatures',[CandidatureController::class,'store'])->name('candidatures.store');
    // Page archives (AVANT {candidature} pour éviter le conflit de routing)
    Route::get('/candidatures/archives',[CandidatureController::class,'archives'])->name('candidatures.archives');
    // Détail d'une candidature
    Route::get('/candidatures/{candidature}',[CandidatureController::class,'show'])->name('candidatures.show');
    // Formulaire de modification
    Route::get('/candidatures/{candidature}/edit',[CandidatureController::class,'edit'])->name('candidatures.edit');
     // Mise à jour d'une candidature
     Route::put('/candidatures/{candidature}',[CandidatureController::class,'update'])->name('candidatures.update');
     // Archivage d'une candidature (soft delete)
     Route::delete('/candidatures/{candidature}',[CandidatureController::class,'destroy'])->name('candidatures.destroy');
    // Restauration d'une candidature archivée
    Route::post('/candidatures/{id}/restore',[CandidatureController::class,'restore'] )->name('candidatures.restore');
   // ── ENTRETIENS ────────────────────────────────────────────

    // Ajouter un entretien à une candidature
    Route::post('/candidatures/{candidature}/entretiens', [EntretienController::class, 'store'])
        ->name('entretiens.store');

    // Formulaire de modification d'entretien
    Route::get('/entretiens/{entretien}/edit', [EntretienController::class, 'edit'])
        ->name('entretiens.edit');

    // Mise à jour d'un entretien
    Route::put('/entretiens/{entretien}', [EntretienController::class, 'update'])
        ->name('entretiens.update');

    // Suppression d'un entretien
    Route::delete('/entretiens/{entretien}', [EntretienController::class, 'destroy'])
        ->name('entretiens.destroy');   



}) ;


