<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\User;

class AdminController extends Controller
{
    public function users()
    {
        return response()->json(User::paginate(10));
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Impossible de supprimer un administrateur'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }

    public function toggleOffre(Offre $offre)
    {
        $offre->update(['actif' => !$offre->actif]);

        return response()->json([
            'message' => 'Statut de l\'offre mis à jour',
            'actif'   => $offre->actif,
        ]);
    }
}