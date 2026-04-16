<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Offre;

class AdminController extends Controller
{
    public function users()
    {
        if (auth('api')->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        return response()->json(User::paginate(10));
    }

    public function deleteUser(User $user)
    {
        if (auth('api')->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }

    public function toggleOffre(Offre $offre)
    {
        if (auth('api')->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $offre->update(['actif' => !$offre->actif]);

        return response()->json([
            'message' => 'Statut de l\'offre mis à jour',
            'actif' => $offre->actif
        ]);
    }
}
