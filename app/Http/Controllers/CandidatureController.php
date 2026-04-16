<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Profil;
use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;

class CandidatureController extends Controller
{
    public function postuler(Request $request, $offreId)
    {
        $request->validate([
            'message' => 'nullable|string'
        ]);

        $profil = Profil::where('user_id', auth('api')->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $offre = Offre::findOrFail($offreId);

        $exists = Candidature::where('profil_id', $profil->id)
            ->where('offre_id', $offreId)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Déjà candidat'], 409);
        }

        $candidature = Candidature::create([
            'profil_id' => $profil->id,
            'offre_id' => $offreId,
            'statut' => 'en_attente',
            'message' => $request->message,
        ]);

        event(new CandidatureDeposee($candidature));

        return response()->json($candidature, 201);
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

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,acceptee,refusee'
        ]);

        $candidature = Candidature::findOrFail($id);

        $ancienStatut = $candidature->statut;

        $candidature->update([
            'statut' => $request->statut
        ]);

        event(new StatutCandidatureMis(
            $candidature,
            $ancienStatut,
            $request->statut
        ));

        return response()->json($candidature);
    }
}
