<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// AUTH — public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // OFFRES — accessibles à tous les rôles authentifiés
    Route::get('/offres',         [OffreController::class, 'index']);
    Route::get('/offres/{offre}', [OffreController::class, 'show']);

    // PROFIL — candidat uniquement
    Route::middleware('role:candidat')->group(function () {
        Route::post('/profil',                          [ProfilController::class, 'store']);
        Route::get('/profil',                           [ProfilController::class, 'show']);
        Route::put('/profil',                           [ProfilController::class, 'update']);
        Route::post('/profil/competences',              [ProfilController::class, 'addCompetence']);
        Route::delete('/profil/competences/{id}',       [ProfilController::class, 'removeCompetence']);

        Route::post('/offres/{offre}/candidater',       [CandidatureController::class, 'postuler']);
        Route::get('/mes-candidatures',                 [CandidatureController::class, 'mesCandidatures']);
    });

    // OFFRES & CANDIDATURES — recruteur uniquement
    Route::middleware('role:recruteur')->group(function () {
        Route::post('/offres',                                    [OffreController::class, 'store']);
        Route::put('/offres/{offre}',                             [OffreController::class, 'update']);
        Route::delete('/offres/{offre}',                          [OffreController::class, 'destroy']);
        Route::get('/offres/{offre}/candidatures',                [CandidatureController::class, 'offreCandidatures']);
        Route::patch('/candidatures/{candidature}/statut',        [CandidatureController::class, 'updateStatut']);
    });

    // ADMIN
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users',              [AdminController::class, 'users']);
        Route::delete('/users/{user}',    [AdminController::class, 'deleteUser']);
        Route::patch('/offres/{offre}',   [AdminController::class, 'toggleOffre']);
    });
});