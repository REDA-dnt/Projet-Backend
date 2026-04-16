<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Competence;

class ProfilController extends Controller
{
    public function show()
    {
        $profil = Profil::with('competences')
            ->where('user_id', auth()->id())
            ->first();

        return response()->json($profil);
    }

    public function update(Request $request)
    {
        $request->validate([
            'titre' => 'sometimes|string',
            'bio' => 'sometimes|string',
            'localisation' => 'sometimes|string',
        ]);

        $profil = Profil::where('user_id', auth()->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $profil->update($request->only(['titre', 'bio', 'localisation']));

        return response()->json($profil);
    }

    public function addCompetence(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'niveau' => 'required|in:debutant,intermediaire,expert'
        ]);

        $competence = Competence::firstOrCreate([
            'nom' => $request->nom
        ]);

        $profil = Profil::where('user_id', auth()->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $profil->competences()->syncWithoutDetaching([
            $competence->id => ['niveau' => $request->niveau]
        ]);

        return response()->json(['message' => 'Compétence ajoutée']);
    }

    public function removeCompetence($id)
    {
        $profil = Profil::where('user_id', auth()->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $profil->competences()->detach($id);

        return response()->json(['message' => 'Compétence supprimée']);
    }
}