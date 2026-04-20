<?php

namespace App\Http\Controllers;

use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;
use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Profil;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function postuler(Request $request, Offre $offre)
    {
        $request->validate([
            'message' => 'nullable|string',
        ]);

        $profil = Profil::where('user_id', auth('api')->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        if (!$offre->actif) {
            return response()->json(['message' => 'Cette offre n\'est plus active'], 422);
        }

        $existe = Candidature::where('profil_id', $profil->id)
            ->where('offre_id', $offre->id)
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'Vous avez déjà postulé à cette offre'], 409);
        }

        $candidature = Candidature::create([
            'profil_id' => $profil->id,
            'offre_id'  => $offre->id,
            'statut'    => 'en_attente',
            'message'   => $request->message,
        ]);

        event(new CandidatureDeposee($candidature));

        return response()->json($candidature->load('offre'), 201);
    }

    public function mesCandidatures()
    {
        $profil = Profil::where('user_id', auth('api')->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $candidatures = Candidature::with('offre')
            ->where('profil_id', $profil->id)
            ->get();

        return response()->json($candidatures);
    }

    public function offreCandidatures(Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $candidatures = $offre->candidatures()->with('profil.user')->get();

        return response()->json($candidatures);
    }

    public function updateStatut(Request $request, Candidature $candidature)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        if ($candidature->offre->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $ancienStatut = $candidature->statut;

        $candidature->update(['statut' => $request->statut]);

        event(new StatutCandidatureMis($candidature, $ancienStatut, $request->statut));

        return response()->json($candidature);
    }
}
