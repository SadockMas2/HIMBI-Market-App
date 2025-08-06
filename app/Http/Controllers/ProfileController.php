<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire de profil.
     */
    public function show()
    {
        return view('profile.show');
    }

    /**
     * Met à jour les informations du profil de l'utilisateur.
     */
public function update(Request $request)
{
    $user = Auth::user();

    // Règles de validation
    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'phone' => ['nullable', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:255'],
    ];

    // Si on veut changer le mot de passe, on valide ces champs aussi
    if ($request->filled('password')) {
        $rules['current_password'] = ['required'];
        $rules['password'] = ['required', 'confirmed', 'min:8'];
    }

    $validatedData = $request->validate($rules);

    // Vérifier le mot de passe actuel si on veut changer le mot de passe
    if ($request->filled('password')) {
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }
    }

    // Mise à jour des infos utilisateur
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->phone = $validatedData['phone'] ?? $user->phone;
    $user->adress = $validatedData['address'] ?? $user->adress;

    if ($request->filled('password')) {
        $user->password = Hash::make($validatedData['password']);
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
}
}
