<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ProfilController,
    OffreController,
    CandidatureController,
    AdminController
};

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // PROFIL (candidat)
    Route::middleware('role:candidat')->group(function () {
        Route::get('/profil', [ProfilController::class, 'show']);
        Route::put('/profil', [ProfilController::class, 'update']);

        Route::post('/profil/competences', [ProfilController::class, 'addCompetence']);
        Route::delete('/profil/competences/{id}', [ProfilController::class, 'removeCompetence']);
    });

    // OFFRES
    Route::get('/offres', [OffreController::class, 'index']);
    Route::get('/offres/{offre}', [OffreController::class, 'show']);

    Route::middleware('role:recruteur')->group(function () {
        Route::post('/offres', [OffreController::class, 'store']);
        Route::put('/offres/{offre}', [OffreController::class, 'update']);
        Route::delete('/offres/{offre}', [OffreController::class, 'destroy']);

        Route::get('/offres/{offre}/candidatures', [CandidatureController::class, 'offreCandidatures']);
        Route::patch('/candidatures/{id}/statut', [CandidatureController::class, 'updateStatut']);
    });

    // CANDIDATURES
    Route::middleware('role:candidat')->group(function () {
        Route::post('/offres/{offre}/candidater', [CandidatureController::class, 'postuler']);
        Route::get('/mes-candidatures', [CandidatureController::class, 'mesCandidatures']);
    });

    // ADMIN
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users']);
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
        Route::patch('/offres/{offre}', [AdminController::class, 'toggleOffre']);
    });

});