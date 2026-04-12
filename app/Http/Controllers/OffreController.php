<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre;

class OffreController extends Controller
{
    public function index()
    {
        $offres = Offre::with('user')->get();
        return response()->json($offres);
    }

    public function show($id)
    {
        $offre = Offre::with('user')->findOrFail($id);
        return response()->json($offre);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string',
            'description'  => 'required|string',
            'localite'     => 'required|string',
            'type_contrat' => 'required|string',
        ]);

        $offre = Offre::create([
            'user_id'      => auth()->id(),
            'titre'        => $request->titre,
            'description'  => $request->description,
            'localite'     => $request->localite,
            'type_contrat' => $request->type_contrat,
        ]);

        return response()->json($offre, 201);
    }

    public function update(Request $request, $id)
    {
        $offre = Offre::where('user_id', auth()->id())
                      ->findOrFail($id);

        $offre->update($request->only([
            'titre', 'description', 'localite', 'type_contrat'
        ]));

        return response()->json($offre);
    }

    public function destroy($id)
    {
        $offre = Offre::where('user_id', auth()->id())
                      ->findOrFail($id);
        $offre->delete();

        return response()->json(['message' => 'Offre supprimée']);
    }
}