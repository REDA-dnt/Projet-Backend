<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function store(Request $request)
    {
        if (Profil::where('user_id', auth('api')->id())->exists()) {
            return response()->json(['message' => 'Profil deja existant'], 409);
        }

        $data = $request->validate([
            'titre'        => 'required|string|max:255',
            'bio'          => 'nullable|string',
            'localisation' => 'nullable|string|max:255',
            'disponible'   => 'nullable|boolean',
        ]);

        $profil = Profil::create(array_merge($data, [
            'user_id' => auth('api')->id(),
        ]));

        return response()->json($profil->load('competences'), 201);
    }

    public function show()
    {
        $profil = Profil::with('competences')
            ->where('user_id', auth('api')->id())
            ->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        return response()->json($profil);
    }

    public function update(Request $request)
    {
        $profil = Profil::where('user_id', auth('api')->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $data = $request->validate([
            'titre'        => 'sometimes|string|max:255',
            'bio'          => 'sometimes|string',
            'localisation' => 'sometimes|string|max:255',
            'disponible'   => 'sometimes|boolean',
        ]);

        $profil->update($data);

        return response()->json($profil->load('competences'));
    }

    public function addCompetence(Request $request)
    {
        $data = $request->validate([
            'nom'    => 'required|string|max:255',
            'niveau' => 'required|in:debutant,intermediaire,expert',
        ]);

        $profil = Profil::where('user_id', auth('api')->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $competence = Competence::firstOrCreate(['nom' => $data['nom']]);

        $profil->competences()->syncWithoutDetaching([
            $competence->id => ['niveau' => $data['niveau']],
        ]);

        return response()->json(['message' => 'Competence ajoutee', 'competence' => $competence]);
    }

    public function removeCompetence(int $id)
    {
        $profil = Profil::where('user_id', auth('api')->id())->first();

        if (!$profil) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        }

        $profil->competences()->detach($id);

        return response()->json(['message' => 'Competence supprimee']);
    }
}
