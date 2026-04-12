<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\AdminController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    Route::get('/profil',                     [ProfilController::class, 'show']);
    Route::put('/profil',                     [ProfilController::class, 'update']);
    Route::post('/profil/competences',        [ProfilController::class, 'addCompetence']);
    Route::delete('/profil/competences/{id}', [ProfilController::class, 'removeCompetence']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('/offres/{id}/candidater',      [CandidatureController::class, 'postuler']);
    Route::get('/candidatures/mes',             [CandidatureController::class, 'mesCandidatures']);
    Route::put('/candidatures/{id}/statut',     [CandidatureController::class, 'updateStatut']);
});

Route::middleware(['auth:api', 'checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/users',          [AdminController::class, 'listUsers']);
    Route::delete('/users/{id}',  [AdminController::class, 'deleteUser']);
    Route::get('/offres',         [AdminController::class, 'listOffres']);
    Route::delete('/offres/{id}', [AdminController::class, 'deleteOffre']);
});