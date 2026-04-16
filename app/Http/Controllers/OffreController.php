<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::where('actif', true);

        if ($request->filled('localisation')) {
            $query->where('localisation', 'like', '%' . $request->localisation . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $offres = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($offres);
    }

    public function show(Offre $offre)
    {
        return response()->json($offre->load('recruteur'));
    }

    public function store(Request $request)
    {
        if (auth('api')->user()->role !== 'recruteur') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $data = $request->validate([
            'titre'        => 'required|string',
            'description'  => 'required|string',
            'localisation' => 'nullable|string',
            'type'         => 'required|in:CDI,CDD,stage',
        ]);

        $offre = auth('api')->user()->offres()->create($data);

        return response()->json($offre, 201);
    }

    public function update(Request $request, Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $data = $request->validate([
            'titre'        => 'sometimes|string',
            'description'  => 'sometimes|string',
            'localisation' => 'sometimes|string',
            'type'         => 'sometimes|in:CDI,CDD,stage',
        ]);

        $offre->update($data);

        return response()->json($offre);
    }

    public function destroy(Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $offre->delete();

        return response()->json(['message' => 'Offre supprimée']);
    }
}