<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidature;
use App\Models\Offre;

class CandidatureController extends Controller
{
    public function postuler(Request $request, $id)
    {
        $offre = Offre::findOrFail($id);

        $dejaCandidaté = Candidature::where('user_id', auth()->id())
                                    ->where('offre_id', $id)
                                    ->exists();

        if ($dejaCandidaté) {
            return response()->json(['message' => 'Vous avez déjà postulé'], 409);
        }

        $candidature = Candidature::create([
            'user_id'  => auth()->id(),
            'offre_id' => $id,
            'statut'   => 'en_attente',
            'message'  => $request->message,
        ]);

        return response()->json($candidature, 201);
    }

    public function mesCandidatures()
    {
        $candidatures = Candidature::with('offre')
                                   ->where('user_id', auth()->id())
                                   ->get();

        return response()->json($candidatures);
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,accepte,refuse'
        ]);

        $candidature = Candidature::findOrFail($id);
        $candidature->update(['statut' => $request->statut]);

        return response()->json($candidature);
    }
}
