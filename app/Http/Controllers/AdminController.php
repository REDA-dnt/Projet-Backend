<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offre;

class AdminController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }

    public function listOffres()
    {
        $offres = Offre::with('user')->get();
        return response()->json($offres);
    }

    public function deleteOffre($id)
    {
        $offre = Offre::findOrFail($id);
        $offre->delete();

        return response()->json(['message' => 'Offre supprimée']);
    }
}