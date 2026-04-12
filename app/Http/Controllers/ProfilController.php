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
        $profil = Profil::where('user_id', auth()->id())->first();

        $profil->update($request->only(['bio', 'titre', 'localite']));

        return response()->json($profil);
    }

    public function addCompetence(Request $request)
    {
        $request->validate(['nom' => 'required|string']);

        $competence = Competence::firstOrCreate(['nom' => $request->nom]);

        $profil = Profil::where('user_id', auth()->id())->first();
        $profil->competences()->attach($competence->id);

        return response()->json(['message' => 'Compétence ajoutée']);
    }

    public function removeCompetence($id)
    {
        $profil = Profil::where('user_id', auth()->id())->first();
        $profil->competences()->detach($id);

        return response()->json(['message' => 'Compétence supprimée']);
    }
}