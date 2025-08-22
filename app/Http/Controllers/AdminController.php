<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\Ingredient;
use App\Models\Serveur;
use App\Models\ServerOrder;  // ajoute ce use si tu as ce modèle
use App\Models\StockHistory;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Mail\Transport\ResendTransport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;

use function Laravel\Prompts\table;

class AdminController extends Controller
{

    public function show_user()
        {
                // Récupérer tous les utilisateurs (par exemple tous, ou filtrer si besoin)
                $users = User::all();

                // Passer la variable $users à la vue
    return view('admin.show_user', compact('users'));
        }


    public function add_food()
    {
        return view('admin.add_food');

    }

    public function upload_food(Request $request)
    {

        $data = new Food;
        $data->title = $request->title;
        $data->detail = $request->details;
        $data->price = $request->price;
        $image = $request->img;
        $filename = time().'.'.$image->getClientOriginalExtension();
        $request->img->move('food_img',$filename);
        $data->image = $filename;

        $data->save();

        return redirect()->back();
    }

        public function view_food()
        {
            $data = Food::all(); 

          

            return view('admin.show_food', compact('data'));
        }

         public function view_table()
        {
          
            $tables = Table::all(); // Récupérer toutes les tables aussi
            $serveurs = User::where('usertype', 'serveur')->get();


            return view('admin.view_table', compact('tables','serveurs'));
        }

        public function updateCommandeStatus(Request $request, $id)
        {
            $request->validate([
                'status' => 'required|in:en_attente,en_cours,terminee,payee',
            ]);

            $commande = ServerOrder::findOrFail($id);
            $commande->status = $request->status;
            $commande->save();

            return redirect()->back()->with('success', 'Statut de la commande mis à jour.');
        }

        public function libererTable($id)
        {
            $table = Table::findOrFail($id);
            $table->statut = 'Disponible';
            $table->save();

            return redirect()->back()->with('success', "Table {$table->nom_table} libérée avec succès.");
        }

     

        public function commandesEnCours()
        {
            // On récupère toutes les commandes qui ne sont pas terminées ou payées
            $commandes = ServerOrder::whereNotIn('status', ['terminee', 'payee'])
                        ->with(['table', 'serveur', 'food'])
                        ->get();

            return view('admin.commandes_en_cours', compact('commandes'));
        }





        public function delete_food($id)
        {
            $data = Food::find($id);
            $data->delete();
            return redirect()->back();

        }

      // Affiche le formulaire de mise à jour
        public function update_food($id)
        {
            $food = Food::with('ingredients')->findOrFail($id);
            $ingredients = Ingredient::all(); // tous les ingrédients disponibles

            return view('admin.update_food', compact('food', 'ingredients'));
        }

        // Traite le formulaire
         public function update_food_post(Request $request, $id)
        {
            $food = Food::findOrFail($id);

            // Mise à jour des champs simples
            $food->title = $request->title;
            $food->detail = $request->details;
            $food->price = $request->price;

            // Gestion image
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('food_img'), $imageName);
                $food->image = $imageName;
            }

            $food->save();

            // --- Conversion unité ---
            $convertToBase = function($quantity, $unit) {
                $unit = strtolower($unit);

                switch ($unit) {
                    case 'kg': return $quantity * 1000; // kg → g
                    case 'g': return $quantity;         // déjà g
                    case 'mg': return $quantity / 1000; // mg → g

                    case 'l': return $quantity * 1000;  // litre → ml
                    case 'ml': return $quantity;        // déjà ml

                    case 'piece': 
                    case 'pièce': 
                    case 'pcs': return $quantity;       // unité de base = pièce

                    default: return $quantity; // fallback : pas de conversion
                }
            };

            // Gestion des ingrédients pivot
            $syncData = [];
            if($request->ingredients){
                foreach($request->ingredients as $ingredientId => $data){
                    if(isset($data['selected'])){
                        $ingredient = Ingredient::find($ingredientId);
                        $qty = $data['quantity_required'] ?? 1;
                        $unit = $data['unit'] ?? $ingredient->unit;

                        // Conversion des quantités en unité de base
                        $requiredBase = $convertToBase($qty, $unit);
                        $stockBase = $convertToBase($ingredient->quantity_in_stock, $ingredient->unit);

                        // Vérification du stock
                        if($requiredBase > $stockBase){
                            return back()->with('error', "Quantité pour {$ingredient->name} dépasse le stock disponible !");
                        }

                        $syncData[$ingredientId] = [
                            'quantity_required' => $qty,
                            'unit' => $unit,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            $food->ingredients()->sync($syncData);

            return redirect()->back()->with('success', 'Plat mis à jour avec succès !');
        }

        //Liste des ingredients
       public function indexIngredients()
        {
            $ingredients = Ingredient::all();
            return view('admin.view_all_ingredients', compact('ingredients'));
        }


        public function create()
        {
            $ingredients = Ingredient::all(); // Liste de tous les ingrédients
            return view('admin.add_ingredients');
        }

        public function store(Request $request)
        {
       $request->validate([
            'name' => 'required|string|max:255',
            'quantity_in_stock' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            ]);

        Ingredient::create([
            'name' => $request->name,
            'quantity_in_stock' => $request->quantity_in_stock ?? 0,
            'unit' => $request->unit ?? 'pcs',
        ]);

            return redirect()->back()->with('success', 'Ingrédient ajouté avec succès !');
        }

        public function editIngredients($id) 
        {
            $ingredient = Ingredient::findOrFail($id);
            return view('admin.edit_ingredient', compact('ingredient'));
        }


        public function editFoodIngredients($id)
        {
            $food = Food::findOrFail($id); 
            $ingredients = Ingredient::all();
            $selected = $food->ingredients->pluck('id')->toArray();

            return view('admin.view_all_ingredients', compact('food', 'ingredients', 'selected'));
        }

        public function updateIngredient(Request $request, $id)
        {
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->update($request->only('name', 'quantity_in_stock', 'unit'));
            return redirect()->route('admin.ingredients.index')->with('success', 'Ingrédient mis à jour !');
        }



        public function updateIngredients(Request $request, $id)
       {
            $food = Food::findOrFail($id);

            // Sync des ingrédients sélectionnés
            // Ici on ne gère pas quantity_required, juste l'association
            $food->ingredients()->sync($request->ingredients ?? []);

            return redirect()->route('view_food')->with('success', 'Ingrédients mis à jour avec succès !');
        }

            public function deleteIngredient($id)
            {
                $ingredient = Ingredient::findOrFail($id);
                $ingredient->delete();
                return redirect()->route('admin.ingredients.index')->with('success', 'Ingrédient supprimé !');
            }


        public function edit_food(Request $request, $id)
        {
            // Récupérer le plat
            $data = Food::findOrFail($id);
            $data->title = $request->title;
            $data->detail = $request->details;
            $data->price = $request->price;

            // Gérer le changement d'image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagename = time().'.'.$image->getClientOriginalExtension();
                $image->move('food_img', $imagename);
                $data->image = $imagename;
            }

            $data->save();

            // Mettre à jour les ingrédients associés avec quantité et unité
            if ($request->has('ingredients')) {
                $syncData = [];
                foreach ($request->ingredients as $ingredientId => $ingredientData) {
                    // Vérifier que l'ingrédient est coché
                    if (isset($ingredientData['id'])) {
                        $syncData[$ingredientId] = [
                            'quantity_required' => $ingredientData['quantity_required'] ?? 1,
                            'unit' => $ingredientData['unit'] ?? 'pcs',
                        ];
                    }
                }
                $data->ingredients()->sync($syncData);
            } else {
                // Si aucun ingrédient sélectionné, détacher tous les ingrédients
                $data->ingredients()->detach();
            }

            return redirect('view_food')->with('success', 'Plat mis à jour avec succès');
        }


        public function showIngredientsForFood($food_id)
            {
                $food = Food::findOrFail($food_id);
                $ingredients = Ingredient::all();
                $selected = $food->ingredients->pluck('id')->toArray();

                return view('admin.ingredients', compact('ingredients', 'food', 'selected'));
            }


        public function orders()
        {
            // Récupérer toutes les commandes triées par date décroissante
            $orders = Order::orderBy('created_at', 'desc')->get();

            // Grouper les commandes par client (ici par email, tu peux aussi grouper par user_id si tu as)
            $groupedOrders = $orders->groupBy('email');

            return view('admin.order', compact('groupedOrders'));
        }

        public function deliverAll($email)
        {
            \App\Models\Order::where('email', $email)
                ->update(['delivery_status' => 'livré']);
            
            return redirect()->back()->with('success', "Toutes les commandes de $email ont été livrées.");
        }

        public function cancelAll($email)
        {
            // Supposons que "vider le panier" signifie supprimer les commandes
            \App\Models\Order::where('email', $email)->delete();
            
            return redirect()->back()->with('success', "Toutes les commandes de $email ont été annulées et supprimées.");
        }




        public function store_order(Request $request)
        {
            $food = Food::find($request->food_id);

            if (!$food) {
                return back()->with('error', 'Plat introuvable');
            }

            $quantity = (int) $request->quantity;

            // Création commande
            $order = new Order();
            $order->name = $request->name;
            $order->email = $request->email;
            $order->adress = $request->adress;
            $order->phone = $request->phone;
            $order->food_id = $food->id;
            $order->quantity = $quantity;
            $order->price = $food->price * $quantity;
            $order->image = $food->image;
            $order->delivery_status = 'In Progress';

            // Stock insuffisant ?
            $order->stock_insuffisant = $food->stock < $quantity;

            $order->save();

            // Décrémenter le stock (même si négatif)
            $food->stock -= $quantity;
            $food->save();

            return back()->with('success', 'Commande enregistrée avec succès.');
        }



        public function alert_stock()
        {
            $orders = Order::where('stock_insuffisant', true)->with('food')->latest()->get();
            return view('admin.alert_stock', compact('orders'));
        }

        
        public function on_the_way($id)
        {
                $data = Order::find($id);
                $data->delivery_status = "On the Way";
                $data->save();
                return redirect()->back();

        }

          public function delivered($id)
        {
                $data = Order::find($id);
                $data->delivery_status = "Delivered";
                $data->save();
                return redirect()->back();

        }
       public function canceled($id)
        {
                $data = Order::find($id);
                $data->delivery_status = "Canceled";
                $data->save();
                return redirect()->back();

        }
    
        public function reservations()
        {
            $book = Book::all();
            return view('admin.reservations' ,compact('book'));
        }

        public function store_serveur(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'adress' => 'nullable|string|max:255',
                'password' => 'required|string|min:6',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->adress = $request->adress;
            $user->usertype = 'serveur';
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Serveur ajouté avec succès.');
        }

        
        public function store_user(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'adress' => 'nullable|string|max:255',
                'password' => 'required|string|min:6',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->adress = $request->adress;
            $user->usertype = 'user';
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Client ajouté avec succès.');
        }


        

         public function update_serveur($id)
        {
            $food = Food::find($id);
            return view('admin.update_servur',compact('serveurs'));
        }

        public function view_serveur()
        {
        $serveurs = User::where('usertype', 'serveur')->get();
        return view('admin.view_serveur', compact('serveurs'));
        }

        public function view_user()
        {
        $users = User::where('usertype', 'user')->get();
        return view('admin.view_user', compact('users'));
        }

        public function add_serveur()
        {
         return view('admin.add_serveur'); // Crée cette vue aussi
        }

         public function add_user()
        {
         return view('admin.add_user'); // Crée cette vue aussi
        }


           public function destroy_user($id)
        {
           $user = User::findOrFail($id);

            // Optionnel : vérifier que c'est bien un serveur
            if ($user->usertype !== 'user') 
            {
                return redirect()->back()->with('error', 'Ce n\'est pas un serveur.');
            }

            $user->delete();

            return redirect()->back()->with('success', 'Client supprimé avec succès.');
        }


        public function destroy_serveur($id)
        {
           $serveur = User::findOrFail($id);

            // Optionnel : vérifier que c'est bien un serveur
            if ($serveur->usertype !== 'serveur') 
            {
                return redirect()->back()->with('error', 'Ce n\'est pas un serveur.');
            }

            $serveur->delete();

            return redirect()->back()->with('success', 'Serveur supprimé avec succès.');
        }


    
        public function add_table (Request $request)
        {
            $request->validate([
                'nom_table' => 'required|string',
                'capacite' => 'required|integer',
                'statut' => 'required|string',
            ]);

            Table::create([
                'nom_table' => $request->nom_table,
                'capacite' => $request->capacite,
                'statut' => $request->statut,
            ]);

            return redirect()->back()->with('success', 'Table ajoutée avec succès');
        }

        
           public function delete_table($id)
        {
           $table = Table::findOrFail($id);

          
            $table->delete();

            return redirect()->back()->with('success', 'Table supprimée avec succès.');
        }


         public function showAddTableForm()
        {
             return view('admin.add_table'); // ou le chemin correct vers ta vue
            
        }

        public function update_table_status(Request $request, $id)
        {
            $request->validate([
                'statut' => 'required|in:Disponible,Occupée,Réservée',
            ]);

            $table = Table::findOrFail($id);
            $table->statut = $request->statut;
            $table->save();

            return redirect()->back()->with('success', 'Statut de la table mis à jour avec succès.');
        }


         public function show_stock()
        {
            // Charger simplement la relation ingredients
            $foods = Food::with('ingredients')->get();

            return view('admin.show_stock', compact('foods'));
        }

                
        public function updateDrinkStock(Request $request, $id)
        {
            $request->validate([
                'stock' => 'required|integer|min:0'
            ]);

            $drink = Food::findOrFail($id);

            // Vérifier que c'est bien une boisson
            if(strtolower($drink->detail) !== 'boisson') {
                return redirect()->back()->with('error', 'Ce plat n\'est pas une boisson.');
            }

            $drink->stock = $request->stock;
            $drink->save();

            return redirect()->back()->with('success', 'Stock mis à jour avec succès.');
        }


        // Conversion des unités vers une unité de base (g pour masse, ml pour volume, pcs pour pièce)
        private function convertToBase($quantity, $unit)
        {
            switch ($unit) {
                case 'kg':
                    return $quantity * 1000; // kg -> g
                case 'g':
                    return $quantity; // déjà en g
                case 'L':
                    return $quantity * 1000; // L -> ml
                case 'ml':
                    return $quantity; // déjà en ml
                case 'pcs':
                default:
                    return $quantity; // pièces restent telles quelles
            }
        }

        private function convertFromBase($quantity, $unit)
        {
            switch ($unit) {
                case 'kg':
                    return $quantity / 1000;
                case 'g':
                    return $quantity;
                case 'L':
                    return $quantity / 1000;
                case 'ml':
                    return $quantity;
                case 'pcs':
                default:
                    return $quantity;
            }
        }



        public function prepareDish(Request $request, $id)
        {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $plat = Food::with('ingredients')->findOrFail($id);
            $quantityPrepared = (int) $request->quantity;

            DB::beginTransaction();

            try {
                // --- Vérifier le stock pour chaque ingrédient ---
                foreach ($plat->ingredients as $ingredient) {
                    $needed = $ingredient->pivot->quantity_required * $quantityPrepared;

                    // Convertir le stock de l'ingrédient en la même unité que la quantité requise
                    switch (strtolower($ingredient->unit)) {
                        case 'kg': $stockBase = $ingredient->quantity_in_stock * 1000; break;
                        case 'g':  $stockBase = $ingredient->quantity_in_stock; break;
                        case 'l':  $stockBase = $ingredient->quantity_in_stock * 1000; break;
                        case 'ml': $stockBase = $ingredient->quantity_in_stock; break;
                        default: $stockBase = $ingredient->quantity_in_stock; break;
                    }

                    if ($needed > $stockBase) {
                        DB::rollBack();
                        return back()->with('error', "Stock insuffisant pour l'ingrédient {$ingredient->name}");
                    }
                }

                // --- Débiter le stock des ingrédients ---
                foreach ($plat->ingredients as $ingredient) {
                    $needed = $ingredient->pivot->quantity_required * $quantityPrepared;

                    switch (strtolower($ingredient->unit)) {
                        case 'kg': 
                            $ingredient->quantity_in_stock -= $needed / 1000; // Convertir g -> kg
                            break;
                        case 'l':
                            $ingredient->quantity_in_stock -= $needed / 1000; // Convertir ml -> L
                            break;
                        default:
                            $ingredient->quantity_in_stock -= $needed; // g ou ml
                            break;
                    }

                    $ingredient->save();
                }

                // --- Mettre à jour le stock du plat préparé ---
                $plat->stock = ($plat->stock ?? 0) + $quantityPrepared;
                $plat->save();

                DB::commit();

                return back()->with('success', "Stock mis à jour pour {$plat->title} ({$quantityPrepared} plat(s) préparé(s))");

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', "Une erreur est survenue : " . $e->getMessage());
            }
        }






     public function kitchen()
        {
            $foods = Food::with('ingredients')->get();

            // Fonction de conversion en unité de base (g, ml, pcs)
            $convertToBase = function($quantity, $unit) {
                $unit = strtolower($unit);
                switch ($unit) {
                    case 'kg': return $quantity * 1000; // kg -> g
                    case 'g': return $quantity;
                    case 'l': return $quantity * 1000;  // L -> ml
                    case 'ml': return $quantity;
                    case 'pcs':
                    case 'piece':
                    case 'pièce':
                    default: return $quantity;
                }
            };

            // Fonction de conversion depuis unité de base
            $convertFromBase = function($quantity, $unit) {
                $unit = strtolower($unit);
                switch ($unit) {
                    case 'kg': return $quantity / 1000;
                    case 'g': return $quantity;
                    case 'l': return $quantity / 1000;
                    case 'ml': return $quantity;
                    case 'pcs':
                    case 'piece':
                    case 'pièce':
                    default: return $quantity;
                }
            };

            foreach ($foods as $food) {
                $possibleQuantities = [];

                foreach ($food->ingredients as $ingredient) {
                    $requiredBase = $convertToBase($ingredient->pivot->quantity_required, $ingredient->pivot->unit);
                    $stockBase = $convertToBase($ingredient->quantity_in_stock, $ingredient->unit);

                    if ($requiredBase > 0) {
                        $possibleQuantities[] = floor($stockBase / $requiredBase);
                    }
                }

                // Le stock disponible pour ce plat est le minimum calculé parmi tous les ingrédients
                $food->available_stock = count($possibleQuantities) > 0 ? min($possibleQuantities) : 0;
            }

            return view('admin.kitchen', compact('foods'));
        }

        

        public function storeIngredients(Request $request, $foodId)
        {
            $food = Food::findOrFail($foodId);

            // On détache d'abord tous les anciens ingrédients (si besoin)
            $food->ingredients()->detach(); 

            // On ajoute les nouveaux
            foreach ($request->ingredients as $ingredient) {
                $food->ingredients()->attach($ingredient['id'], [
                    'quantity_required' => $ingredient['quantity_required'],
                    'unit' => $ingredient['unit'],
                ]);
            }

            return redirect()->back()->with('success', 'Ingrédients affectés avec succès !');
        }


        

        
        public function update_stock(Request $request, $id)
        {
            $request->validate([
                'stock' => 'required|integer|min:0',
            ]);

            // Mise à jour de la colonne 'stock' dans la table 'food'
            $food = Food::findOrFail($id);
            $food->stock = $request->stock;
            $food->save();

            // Mise à jour ou création dans la table 'stocks'
            if ($food->stockRelation) {
                // Si une ligne existe déjà dans la table 'stocks'
                $food->stockRelation->update(['quantity' => $request->stock]);
            } else {
                // Sinon, on en crée une nouvelle
                $food->stockRelation()->create(['quantity' => $request->stock]);
            }

            return redirect()->back()->with('success', 'Stock mis à jour dans les deux tables.');
        }

        public function paiements()
        {
            return view('admin.Paiements');
        }

        public function assign_serveur(Request $request, $id)
        {
            $table = Table::findOrFail($id);
            $table->serveur_id = $request->serveur_id;
            $table->save();

            return back()->with('success', 'Serveur assigné avec succès à la table.');
        }

      public function historiqueCommandesParServeur($serveurId)
        {
            $commandes = ServerOrder::with(['food', 'payments'])
                ->where('serveur_id', $serveurId)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.historique_commandes', compact('commandes'));
        }


        public function historiqueServeurs()
        {
            $commandes = ServerOrder::with('serveur', 'table', 'food')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.historique_serveurs', compact('commandes'));
        }

        public function afficherFacture($id)
        {
            $commande = ServerOrder::with('food', 'table', 'serveur')->findOrFail($id);
            return view('admin.facture', compact('commande'));
        }

        public function marquerCommePaye($id)
        {
            $commande = ServerOrder::findOrFail($id);
            $commande->payment_status = 'payé';
            $commande->save();

            return redirect()->back()->with('success', 'Commande marquée comme payée.');
        }

        public function afficherRecu($id)
        {
            $commande = ServerOrder::with('food', 'table', 'serveur')->findOrFail($id);
            return view('admin.recu', compact('commande'));
        }

       


   

        public function historique(Request $request)
        {
            $queryCommandes = ServerOrder::with('serveur', 'table', 'food')
                ->where('payment_status', 'payé');

            if ($request->filled('serveur_id')) {
                $queryCommandes->where('serveur_id', $request->serveur_id);
            }

            if ($request->filled('date')) {
                $queryCommandes->whereDate('created_at', $request->date);
            }

            $commandes = $queryCommandes->orderBy('created_at', 'desc')->get();

            // Total général des commandes payées
            $totalCommandes = $commandes->sum(function ($cmd) {
                $prix = is_numeric($cmd->food->price) ? (float) $cmd->food->price : 0;
                $quantite = (int) $cmd->quantite;
                return $prix * $quantite;
            });

            $queryReservations = Book::with('client', 'table')
                ->where('payment_status', 'payé');

            if ($request->filled('date')) {
                $queryReservations->whereDate('created_at', $request->date);
            }

            $reservations = $queryReservations->orderBy('created_at', 'desc')->get();

            $serveurs = User::where('usertype', 'serveur')->get();

            return view('admin.historique', compact('commandes', 'reservations', 'serveurs', 'totalCommandes'));
        }


       public function exportHistoriquePDF(Request $request)
        {
            $queryCommandes = ServerOrder::with('serveur', 'table', 'food')
                ->where('payment_status', 'payé');

            // Appliquer les filtres
            if ($request->filled('serveur_id')) {
                $queryCommandes->where('serveur_id', $request->serveur_id);
            }

            if ($request->filled('date')) {
                $queryCommandes->whereDate('created_at', $request->date);
            }

            $commandes = $queryCommandes->orderBy('created_at', 'desc')->get();

            $totalCommandes = $commandes->sum(function ($cmd) {
                $prix = is_numeric($cmd->food->price) ? (float) $cmd->food->price : 0;
                $quantite = (int) $cmd->quantite;
                return $prix * $quantite;
            });

            $filtreServeur = $request->filled('serveur_id') ? User::find($request->serveur_id)->name ?? null : null;
            $filtreDate = $request->filled('date') ? $request->date : null;

            $pdf = Pdf::loadView('pdfs.historique_commandes', compact('commandes', 'totalCommandes', 'filtreServeur', 'filtreDate'))
                    ->setPaper('A4', 'landscape');

            return $pdf->download('historique_commandes.pdf');
        }


        private function getDashboardStats()
        {
            return [
                'total_utilisateurs' => User::count(),
                'total_plats' => Food::count(),
                'total_commandes' => Order::count(),
                'total_reservations' => Reservation::count(),
            ];
        }

        public function showStockHistory(Request $request)
        {
            $query = StockHistory::with('food', 'ingredient');

            // Filtre par plat
            if ($request->filled('food_id')) {
                $query->where('food_id', $request->food_id);
            }

            // Filtre par date
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

            $history = $query->orderBy('created_at', 'desc')->get();

            $foods = Food::orderBy('title')->get(); // Pour le filtre plat

            return view('admin.stock_history', compact('history', 'foods'));
        }

             public function exportStockHistoryPdf()
        {
            $stockHistories = StockHistory::with(['food', 'ingredient'])
                ->orderBy('created_at', 'desc')
                ->get();

            $pdf = Pdf::loadView('admin.stock_history_pdf', compact('stockHistories'));

            return $pdf->download('historique_stock.pdf');
        }




}


