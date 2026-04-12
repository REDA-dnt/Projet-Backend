<?php
namespace App\Http\Controllers;

use App\Models\{User, Offre};

class AdminController extends Controller
{
    public function users()
    {
        return response()->json(User::all());
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé']);
    }

    public function toggleOffre(Offre $offre)
    {
        $offre->update(['actif' => !$offre->actif]);
        return response()->json(['message' => 'Statut de l\'offre mis à jour', 'actif' => $offre->actif]);
    }
}