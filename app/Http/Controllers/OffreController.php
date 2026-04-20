<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $query = Offre::with('recruteur')->where('actif', true);

        if ($request->filled('localisation')) {
            $query->where('localisation', 'like', '%'.$request->localisation.'%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return response()->json(
            $query->orderBy('created_at', 'desc')->paginate(10)
        );
    }

    public function show(Offre $offre)
    {
        return response()->json($offre->load('recruteur'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre'        => 'required|string|max:255',
            'description'  => 'required|string',
            'localisation' => 'nullable|string|max:255',
            'type'         => 'required|in:CDI,CDD,stage',
        ]);

        $offre = auth('api')->user()->offres()->create($data);

        return response()->json($offre, 201);
    }

    public function update(Request $request, Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $data = $request->validate([
            'titre'        => 'sometimes|string|max:255',
            'description'  => 'sometimes|string',
            'localisation' => 'sometimes|string|max:255',
            'type'         => 'sometimes|in:CDI,CDD,stage',
        ]);

        $offre->update($data);

        return response()->json($offre);
    }

    public function destroy(Offre $offre)
    {
        if ($offre->user_id !== auth('api')->id()) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $offre->delete();

        return response()->json(['message' => 'Offre supprimée']);
    }
}