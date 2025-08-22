<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class FoodIngredientController extends Controller
{
    public function create(Food $food)
    {
        // Tous les ingrédients disponibles pour remplir le select
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.food_ingredients', compact('food', 'ingredients'));
    }

    public function store(Request $request, Food $food)
    {
        // Validation de tableaux (plusieurs lignes)
        $request->validate([
            'ingredient_id'        => 'required|array|min:1',
            'ingredient_id.*'      => 'required|integer|exists:ingredients,id|distinct',
            'quantity_required'    => 'required|array|min:1',
            'quantity_required.*'  => 'required|numeric|min:0.01',
            'unit'                 => 'required|array|min:1',
            'unit.*'               => 'required|string|max:20',
        ]);

        // Sécurise l’alignement des index
        $count = count($request->ingredient_id);
        if ($count !== count($request->quantity_required) || $count !== count($request->unit)) {
            return back()->with('error', 'Les lignes du formulaire ne sont pas alignées.')->withInput();
        }

        // Construire un tableau [ingredient_id => [pivot attrs]]
        // et upsert via syncWithoutDetaching (insère si absent, met à jour si présent)
        for ($i = 0; $i < $count; $i++) {
            $ingredientId = (int) $request->ingredient_id[$i];

            $food->ingredients()->syncWithoutDetaching([
                $ingredientId => [
                    'quantity_required' => $request->quantity_required[$i],
                    'unit'              => $request->unit[$i],
                ],
            ]);
        }

        return redirect()
            ->route('food.ingredients.create', $food->id)
            ->with('success', 'Ingrédients affectés/actualisés avec succès !');
    }
}
