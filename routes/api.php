<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, OffreController, CandidatureController};

// Auth (publiques)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Routes protégées par JWT
Route::middleware('jwt')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Offres
    Route::get('/offres',          [OffreController::class, 'index']);
    Route::get('/offres/{offre}',  [OffreController::class, 'show']);

    Route::middleware('role:recruteur')->group(function () {
        Route::post('/offres',             [OffreController::class, 'store']);
        Route::put('/offres/{offre}',      [OffreController::class, 'update']);
        Route::delete('/offres/{offre}',   [OffreController::class, 'destroy']);
        Route::get('/offres/{offre}/candidatures', [CandidatureController::class, 'index']);
        Route::patch('/candidatures/{candidature}/statut', [CandidatureController::class, 'updateStatut']);
    });

});