<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, ProfilController, OffreController, CandidatureController, AdminController};

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('jwt')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Profil: candidats uniquement
    Route::middleware('role:candidat')->group(function () {
        Route::post('/profil',                               [ProfilController::class, 'store']);
        Route::get('/profil',                                [ProfilController::class, 'show']);
        Route::put('/profil',                                [ProfilController::class, 'update']);
        Route::post('/profil/competences',                   [ProfilController::class, 'addCompetence']);
        Route::delete('/profil/competences/{competence}',    [ProfilController::class, 'removeCompetence']);
    });

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

    // Candidatures
    Route::middleware('role:candidat')->group(function () {
        Route::post('/offres/{offre}/candidater', [CandidatureController::class, 'store']);
        Route::get('/mes-candidatures',           [CandidatureController::class, 'mesCandidatures']);
    });

    // Admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users',                   [AdminController::class, 'users']);
        Route::delete('/users/{user}',         [AdminController::class, 'deleteUser']);
        Route::patch('/offres/{offre}',        [AdminController::class, 'toggleOffre']);
    });

});