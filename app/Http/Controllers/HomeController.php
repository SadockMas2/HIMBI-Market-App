<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Book;
use App\Models\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\CommandeConfirmee;



class HomeController extends Controller
{
    public function my_home()
        {
            $data = Food::all();
            $tables = Table::where('statut', 'Disponible')->get(); // 🔍 filtrage ici

            return view('home.index', compact('data', 'tables'));
        }

     

        public function index()
        {
            // Si un utilisateur est connecté
            if (Auth::id()) {
                $usertype = Auth::user()->usertype;

                if ($usertype === 'user') {
                    $data = Food::all();
                    $tables = Table::where('statut', 'Disponible')->get();

                    return view('home.index', compact('data', 'tables'));

                } elseif ($usertype === 'serveur') {
                    return view('serveur.index');

                } else { // admin
                    $total_utilisateurs = User::where('usertype', '=', 'user')->count();
                    $total_plats = Food::count();
                    $total_commandes = Order::count();
                    $total_reservations = Book::count(); // ou Table::where('statut', 'Réservée')->count();
                    $total_livré = Order::where('delivery_status', '=', 'Delivered')->count();

                    return view('admin.index', compact(
                        'total_utilisateurs',
                        'total_plats',
                        'total_commandes',
                        'total_reservations',
                        'total_livré'
                    ));
                }
            }

            return redirect()->route('login');
        }



        public function store_order(Request $request)
        {
            $order = new Order();

            // autres champs...
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->adress = $request->adress;
            $order->title = $request->title;
            $order->price = $request->price;
            $order->quantity = $request->quantity;
            $order->image = $request->image;
            $order->food_id = $request->food_id;

            // Nettoyer le statut et le rendre constant
            $order->delivery_status = 'In Progress'; // PAS de saut de ligne ou tabulation

            // ou plus sécurisé :
            // $order->delivery_status = trim('In Progress');

            $order->save();
        }

                // Ajouter un plat au panier
                public function add_cart(Request $request, $id)
                {
                    if (Auth::check()) {
                        $food = Food::find($id);
                        $qty = (int) $request->qty;

                        $existing = Cart::where('userid', Auth::id())
                                        ->where('food_id', $id)
                                        ->first();

                        if ($existing) {
                            $existing->quantity += $qty;
                            $existing->price = $food->price * $existing->quantity;
                            $existing->save();
                        } else {
                            $cart = new Cart;
                            $cart->food_id = $id;
                            $cart->title = $food->title;
                            $cart->details = $food->detail;
                            $cart->price = $food->price * $qty;
                            $cart->image = $food->image;
                            $cart->quantity = $qty;
                            $cart->userid = Auth::id();
                            $cart->save();
                        }

                        return redirect()->route('my_cart')->with('success', 'Ajouté au panier.');

                    } else {
                        return redirect("login");
                    }
                }

                // Ajouter plusieurs plats à la fois
                public function add_cart_multiple(Request $request)
                {
                    if (!Auth::check()) {
                        return redirect()->route('login')->with('error', 'Connectez-vous pour ajouter au panier.');
                    }

                    $user_id = Auth::id();
                    $food_ids = $request->food_ids;
                    $quantities = $request->qty;

                    if (!$food_ids || count($food_ids) == 0) {
                        return back()->with('error', 'Aucun plat sélectionné.');
                    }

                    foreach ($food_ids as $food_id) {
                        $food = Food::find($food_id);
                        $qty = isset($quantities[$food_id]) ? (int)$quantities[$food_id] : 1;

                        if ($food) {
                            $existing = Cart::where('userid', $user_id)
                                            ->where('food_id', $food_id)
                                            ->first();

                            if ($existing) {
                                $existing->quantity += $qty;
                                $existing->price = $food->price * $existing->quantity;
                                $existing->save();
                            } else {
                                $cart = new Cart;
                                $cart->userid = $user_id;
                                $cart->food_id = $food_id;
                                $cart->title = $food->title;
                                $cart->details = $food->detail;
                                $cart->price = $food->price * $qty;
                                $cart->image = $food->image;
                                $cart->quantity = $qty;
                                $cart->save();
                            }
                        }
                    }

                return redirect()->route('my_cart')->with('success', 'Les plats sélectionnés ont été ajoutés au panier.');

                }

                // Afficher le panier
                public function my_cart()
                {
                    if (!Auth::check()) {
                        return redirect()->route('login')->with('error', 'Vous devez être connecté.');
                    }

                    $data = Cart::where('userid', Auth::id())
                                ->select('id', 'food_id', 'title', 'price', 'quantity', 'image')
                                ->get();

                    $tables = Table::where('statut', 'disponible')->get();

                    return view('home.my_cart', compact('data', 'tables'));
                }

        

            public function confirm_order(Request $request)
            {
                $user_id   = Auth::id();
                $food_ids  = $request->input('food_id', []);
                $titles    = $request->input('title', []);
                $quantities= $request->input('quantity', []);
                $prices    = $request->input('price', []);

                // Déterminer la table
                if ($request->mode === 'sur_place') {
                    $table_id = $request->table_id ?: null;

                    if (!$table_id) {
                        return redirect()->back()->with('error', 'Veuillez choisir une table.');
                    }

                    // Vérifier la disponibilité
                    $table = Table::where('id', $table_id)
                                ->where('statut', 'Disponible')
                                ->first();

                    if (!$table) {
                        return redirect()->back()->with('error', 'La table sélectionnée n’est pas disponible.');
                    }

                    // Marquer la table comme occupée
                    $table->update(['statut' => 'Occupée']);
                } else {
                    // Mode à emporter
                    $table = Table::where('nom_table', 'Commande externe')->first();
                    if (!$table) {
                        return redirect()->back()->with('error', 'La table "Commande externe" est introuvable.');
                    }
                    $table_id = $table->id;
                }

                // Création des commandes
                foreach ($food_ids as $index => $food_id) {
                    $food = Food::find($food_id);
                    if (!$food) continue;

                    $quantity = (int)($quantities[$index] ?? 1);

                    Order::create([
                        'name'            => $request->name,
                        'email'           => $request->email,
                        'phone'           => $request->phone,
                        'adress'          => $request->adress,
                        'title'           => $titles[$index],
                        'quantity'        => $quantity,
                        'price'           => $prices[$index],
                        'food_id'         => $food->id,
                        'delivery_status' => 'In Progress',
                        'table_id'        => $table_id, // 🔥 Sauvegarde de la table
                    ]);

                    // Décrément du stock
                    $food->decrement('stock', $quantity);
                }

                // Vider le panier
                Cart::where('userid', $user_id)->delete();

                return redirect('/home#home')->with('success', 'Commande confirmée avec succès !');
            }


    // MyCartController
            public function checkout(Request $request)
            {
                $user_id = Auth::id();

                // Récupérer les articles du panier
                $cart_items = collect($request->input('food_id', []))->map(function($food_id, $index) use ($request) {
                    return (object)[
                        'food_id' => $food_id,
                        'title' => $request->title[$index] ?? '',
                        'quantity' => $request->quantity[$index] ?? 1,
                        'price' => $request->price[$index] ?? 0,
                    ];
                });

                // Tables disponibles, **exclure "Commande externe"**
                $tables = DB::table('tables')
                            ->where('statut', 'disponible')
                            ->where('nom_table', '<>', 'Commande externe')
                            ->get();

                return view('home.checkout', compact('cart_items', 'tables'));
            }



       
        

            public function update_cart(Request $request, $cart_id)
        {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier le panier.');
            }

            $cart = Cart::where('id', $cart_id)
                        ->where('userid', Auth::id())
                        ->first();

            if (!$cart) {
                return back()->with('error', 'Article non trouvé dans votre panier.');
            }

            $quantity = (int) $request->quantity;
            if ($quantity < 1) {
                return back()->with('error', 'La quantité doit être au moins 1.');
            }

            $food = Food::find($cart->food_id);
            if (!$food) {
                return back()->with('error', 'Plat introuvable.');
            }

            $cart->quantity = $quantity;
            $cart->price = $food->price * $quantity;
            $cart->save();

            return back()->with('success', 'Quantité mise à jour avec succès.');
        }

        public function update_cart_multiple(Request $request)
        {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Veuillez vous connecter pour modifier le panier.');
            }

            $cart_ids = $request->input('cart_id', []);
            $quantities = $request->input('quantity', []);

            foreach ($cart_ids as $index => $cart_id) {
                $quantity = isset($quantities[$index]) ? (int)$quantities[$index] : 1;
                if ($quantity < 1) {
                    continue; // ignore quantités invalides
                }

                $cart = Cart::where('id', $cart_id)
                            ->where('userid', Auth::id())
                            ->first();

                if (!$cart) {
                    continue; // ignore éléments pas trouvés
                }

                $food = Food::find($cart->food_id);
                if (!$food) {
                    continue; // ignore plat non trouvé
                }

                $cart->quantity = $quantity;
                $cart->price = $food->price * $quantity;
                $cart->save();
            }

            return back()->with('success', 'Quantités mises à jour avec succès.');
        }


    // Suppression d’un article du panier
    public function remove_cart($cart_id)
    {
        $cart = Cart::find($cart_id);
        if ($cart) {
            $cart->delete();
            return back()->with('success', 'Article supprimé du panier.');
        }
        return back()->with('error', 'Article non trouvé.');
    }


      
                





    
        public function showBookingForm()
        {
            $tables = Table::where('statut', 'disponible')->get();
            return view('home.book', compact('tables'));
        }


       public function book_table(Request $request)
        {
            $data = new book();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->guest = $request->guest;
            $data->time = $request->time;
            $data->date = $request->date;
            $data->table_id = $request->table_id;

            $data->save();

            // Mettre à jour le statut de la table
            $table = Table::find($request->table_id);
            if ($table) {
                $table->statut = 'Réservée';
                $table->save();
            }

            return redirect()->back()->with('success', 'Table réservée avec succès !');
        }
        

}



