<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ServerOrder;
use App\Models\Book;
use App\Models\Table;
use App\Models\Booking;
use App\Models\Reservation;

use App\Models\Serveur;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;

class ServeurController extends Controller
{

        public function updateReservation(Request $request, $id)
        {
            $reservation = Reservation::findOrFail($id);
            $reservation->update($request->all());
            return redirect()->back()->with('success', 'Réservation mise à jour.');
        }


        public function showReservations()
        {
            $book = Book::all(); // ou avec une condition selon le serveur
            return view('serveur.showReservations', compact('book'));
        }


        public function order()
        {
            $data = Order::all();
            return view('serveur.order',compact('data'));

        }

        public function showOrderDetails($id)
        {
            $order = Order::with('food')->findOrFail($id);
            return view('serveur.orders.details', compact('order'));
        }


        public function searchOrders(Request $request)
        {
            $search = $request->input('search');
            $orders = Order::where('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->get();

            return view('serveur.orders.index', compact('orders'));
        }


        public function markAsServed($id)
        {
            $order = Order::findOrFail($id);
            $order->delivery_status = 'Served';
            $order->save();
            return redirect()->back()->with('success', 'Commande marquée comme servie.');
        }

        public function myTables()
        {
            $tables = Table::where('serveur_id', Auth::id())->get();
            return view('serveur.my_tables', compact('tables'));
        }


        public function release_table($id)
        {
            $table = Table::findOrFail($id);

            // Empêcher la libération de la table "Commande externe"
            if ($table->nom_table === 'Commande externe') {
                return back()->with('error', 'Cette table ne peut pas être libérée manuellement.');
            }

            if ($table->serveur_id == Auth::id()) {
                $table->serveur_id = null;
                $table->statut = 'Disponible'; // Facultatif, selon ton flux
                $table->save();
            }

            return back()->with('success', 'Table libérée. En attente de nouvelle affectation.');
        }



        public function dashboard()
        {
            if (Auth::user()->usertype !== 'serveur') {
                abort(403, 'Accès refusé. Vous n’êtes pas un serveur.');
            }

            // Le code normal si c'est un serveur
            return view('serveur.dashboard');
        }


        public function mesTables()
        {
            $serveurId = Auth::id();

            // Récupérer les tables assignées au serveur avec leurs réservations et commandes (orders)
            $tables = Table::with([
                'reservation' => function ($q) {
                    $q->latest();
                },
                'orders' => function ($q) {
                    $q->with('food')->orderBy('created_at', 'desc');
                }
            ])
            ->where('serveur_id', $serveurId)
            ->get();

            // Récupérer la table "Commande externe" avec ses commandes
            $tableExterne = Table::with(['orders.food'])
                ->where('nom_table', 'Commande externe')
                ->first();

            // L'ajouter à la collection $tables si elle existe et n’est pas déjà dedans
            if ($tableExterne && !$tables->contains('id', $tableExterne->id)) {
                $tables->push($tableExterne);
            }

            return view('serveur.mesTables', compact('tables'));
        }

    //     // Supprimer une commande
    //    public function modifierCommande($id)
    //     {
    //         $commande = Order::findOrFail($id);
    //         return view('serveur.modifier_commande', compact('commande'));
    //     }

    //     public function supprimerCommande($id)
    //     {
    //         $commande = Order::findOrFail($id);
    //         $commande->delete();

    //         return redirect()->route('serveur.commandes')
    //                         ->with('success', 'Commande supprimée avec succès');
    //     }

    //     public function commande(){
    //         Order::Findorfail();
    //     }

        // Mettre à jour la commande
        public function updateCommande(Request $request, $id)
        {
            $commande = Order::findOrFail($id);

            if ($commande->payment_status === 'payé') {
                return back()->with('error', 'Impossible de modifier une commande déjà payée.');
            }

            $request->validate([
                'food_id' => 'required|exists:food,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $commande->update([
                'food_id' => $request->food_id,
                'quantity' => $request->quantity,
            ]);

            return redirect()->route('serveur.mesTables')->with('success', 'Commande modifiée avec succès.');
        }



        public function nouvelleCommande()
        {
            $serveurId = Auth::id();
            $tablesServeur = Table::where('serveur_id', $serveurId)->get();

            // Récupérer la table "Commande externe" qui peut ne pas avoir de serveur assigné
            $tableExterne = Table::where('nom_table', 'Commande externe')->first();

            if ($tableExterne && !$tablesServeur->contains($tableExterne)) {
                $tablesServeur->prepend($tableExterne);
            }

            $foods = Food::all();

            return view('serveur.nouvelle_commande', [
                'tables' => $tablesServeur,
                'foods' => $foods,
            ]);
        }


        public function createOrder()
        {
            $tables = Table::where('statut', 'Disponible')->get();
            $foods = Food::all();

            return view('serveur.nouvelle_commande', compact('tables', 'foods'));
        }


            public function enregistrerCommande(Request $request)
        {
            $request->validate([
                'table_id' => 'required|exists:tables,id',
                'foods' => 'required|array|min:1',
                'foods.*.food_id' => 'required|exists:food,id',
                'foods.*.quantite' => 'required|integer|min:1',
            ]);

            // Étape 1 : Créer la commande principale
            $serverOrder = ServerOrder::create([
                'serveur_id' => Auth::id(),
                'table_id' => $request->table_id,
                'statut' => 'en_attente',
            ]);

            // Étape 2 : Ajouter tous les plats commandés
            foreach ($request->foods as $item) {
                Order::create([
                    'server_order_id' => $serverOrder->id,
                    'food_id' => $item['food_id'],
                    'quantite' => $item['quantite'],
                    'status' => 'non payé',
                ]);
            }

            return redirect()->route('serveur.mesTables')->with('success', 'Commande enregistrée avec succès.');
        }


        public function enregistrerCommandeMultiple(Request $request)
        {
            $request->validate([
                'table_id' => 'required|exists:tables,id',
                'food_id' => 'required|array|min:1',
                'quantite' => 'required|array|min:1',
                'food_id.*' => 'required|exists:food,id',
                'quantite.*' => 'required|integer|min:1',
            ]);

            foreach ($request->food_id as $index => $foodId) {
                ServerOrder::create([
                    'serveur_id' => Auth::id(),
                    'table_id' => $request->table_id,
                    'food_id' => $foodId,
                    'quantite' => $request->quantite[$index],
                    'statut' => 'en_attente',
                ]);
            }

            return redirect()->route('serveur.mesTables')->with('success', 'Commande enregistrée avec plusieurs plats.');
        }


        public function reserverTable(Request $request)
        {
            $request->validate([
                'table_id' => 'required|exists:tables,id',
            ]);

            $table = Table::find($request->table_id);

            if ($table->statut !== 'Disponible') {
                return back()->with('error', 'La table n’est pas disponible.');
            }

            $table->statut = 'réservée';
            $table->save();

            return back()->with('success', 'Table réservée avec succès.');
        }


        public function historiqueCommandes()
        {
            $serveurId = Auth::id();
            $commandes = ServerOrder::with('food', 'table')
                ->where('serveur_id', $serveurId)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('serveur.historique_commandes', compact('commandes'));
        }

        public function showFacture($id)
        {
            $commande = ServerOrder::with('food', 'table')->findOrFail($id);

            if ($commande->payment_status == 'payé') {
                return view('serveur.recu', compact('commande'));
            }

            return view('serveur.facture', compact('commande'));
        }




        public function payerReservation($table_id)
        {
            $reservation = Book::where('table_id', $table_id)
                            ->where('payment_status', 'non_payé')
                            ->first();

            if ($reservation) {
                $reservation->payment_status = 'payé';
                $reservation->save();
                return redirect()->back()->with('success', 'Paiement effectué avec succès.');
            }

            return redirect()->back()->with('error', 'Aucune réservation à payer trouvée.');
        }


            public function genererFactureReservation($table_id)
        {
            $reservation = Book::with('table')
                ->where('table_id', $table_id)
                ->firstOrFail();

            $pdf = Pdf::loadView('pdfs.facture_reservation', compact('reservation'));
            return $pdf->stream('pdfs.facture_reservation');
        }


        public function genererRecuReservation($table_id)
        {
                $reservation = Book::with('client', 'table')
                ->where('table_id', $table_id)
                ->where('payment_status', 'payé')
                ->firstOrFail();

            $pdf = Pdf::loadView('pdfs.recu_reservation', compact('reservation'));
            return $pdf->stream('pdfs.recu_reservation');
        }

        public function genererFactureCommande($id)
        {
                $commande = ServerOrder::with('serveur', 'food')
                    ->findOrFail($id);
                    
            $pdf = Pdf::loadView('pdfs.facture_commande', compact('commande'));
            return $pdf->stream('pdfs.facture_commande');
        }

        public function genererRecuCommande($id)
        {
            $commande = ServerOrder::with('serveur')->where('id', $id)->where('payment_status', 'payé')->firstOrFail();
            $pdf = Pdf::loadView('pdfs.recu_commande', compact('commande'));
            return $pdf->stream('pdfs.recu_commande');
        }

        public function payerCommande($id)
        {
            $commande = ServerOrder::findOrFail($id);

            if ($commande->payment_status !== 'payé') {
                $commande->payment_status = 'payé';
                $commande->save();

                return redirect()->back()->with('success', 'Paiement de la commande effectué.');
            }

            return redirect()->back()->with('error', 'Cette commande est déjà payée.');
        }




        public function factureCommandes($table_id)
            {
                $commandes = ServerOrder::with('food')->where('table_id', $table_id)
                                ->where('payment_status', 'non_payé')->get();

             $total = $commandes->sum(function ($cmd)
                {
                     if ($cmd->food && is_numeric($cmd->food->price))
                    {
                        $quantite = (int) $cmd->quantite;
                        $prix = (float) $cmd->food->price;
                        return $quantite * $prix;
                    }
                return 0;
            });



                $pdf = PDF::loadView('pdfs.facture_commande', compact('commandes', 'total'));
                return $pdf->download('facture_commandes_table_'.$table_id.'.pdf');
            }

            
            public function recuCommandes($table_id)
            {
                // Récupération des commandes payées de la table
                $commandes = ServerOrder::with('food')
                    ->where('table_id', $table_id)
                    ->where('payment_status', 'payé')
                    ->get();

                $total = $commandes->sum(fn($cmd) => $cmd->quantite * $cmd->food->price);

                // Génération du PDF
                $pdf = PDF::loadView('pdfs.recu_commande', compact('commandes', 'total'));

                // ✅ Mettre automatiquement le statut à "Delivered"
                foreach ($commandes as $cmd) {
                    $order = Order::find($cmd->order_id ?? null); // si tu as un lien avec la table orders
                    if ($order) {
                        $order->delivery_status = "Delivered";
                        $order->save();
                    }
                }

                // ✅ Optionnel : suppression des commandes payées après reçu
                ServerOrder::where('table_id', $table_id)
                    ->where('payment_status', 'payé')
                    ->delete();

                // ✅ Optionnel : libérer la table
                Table::where('id', $table_id)->update(['statut' => 'Disponible']);

                return $pdf->download('recu_commandes_table_'.$table_id.'.pdf');
            }



            public function payerCommandes($table_id)
            {
                ServerOrder::where('table_id', $table_id)
                    ->where('payment_status', 'non_payé')
                    ->update(['payment_status' => 'payé']);

                return back()->with('success', 'Commandes payées avec succès.');
            }


            public function prendreCommandeEnLigne($orderId, $serveurId, $tableId)
            {
                // Vérifier que la commande en ligne existe
                $commandeEnLigne = Order::findOrFail($orderId);

                // Créer une entrée dans server_orders
                ServerOrder::create([
                    'serveur_id' => $serveurId,
                    'table_id' => $tableId,
                    'food_id' => $commandeEnLigne->food_id,
                    'quantite' => $commandeEnLigne->quantity,
                    'statut' => 'servie', // Ou 'en_attente' si on veut suivre
                    'payment_status' => 'payé', // si déjà payé
                ]);

                // Optionnel : Marquer la commande en ligne comme "servie" ou "converted"
                $commandeEnLigne->delivery_status = 'Delivered';
                $commandeEnLigne->save();

                return redirect()->back()->with('success', 'Commande prise en charge par le serveur.');
            }

                public function commandesEnLigneDisponibles()
                {
                    $serveurId = Auth::id();

                    // Tables assignées + "Commande externe"
                    $tablesAssignes = Table::where('serveur_id', $serveurId)
                        ->orWhere('nom_table', 'Commande externe')
                        ->pluck('id')
                        ->toArray();

                    // Toutes les commandes en ligne en cours
                    $commandesEnLigne = Order::where('delivery_status', 'In Progress')->get();

                    $commandesFiltrees = collect();

                    foreach ($commandesEnLigne as $commande) {
                        $email = $commande->email ?? 'inconnu';

                        // Vérifier réservation
                        $reservation = Book::where('name', $commande->name)
                            ->whereDate('date', now()->toDateString())
                            ->where('payment_status', 'non_payé')
                            ->latest()
                            ->first();

                        if ($reservation) {
                            if (in_array($reservation->table_id, $tablesAssignes)) {
                                $commandesFiltrees->push([
                                    'email' => $email,
                                    'commande' => $commande,
                                    'reservation' => $reservation
                                ]);
                            }
                        } else {
                            // Pas de réservation
                            $commandesFiltrees->push([
                                'email' => $email,
                                'commande' => $commande,
                                'reservation' => null
                            ]);
                        }
                    }

                    // Regrouper par email pour le Blade
                    $commandesFiltrees = $commandesFiltrees->groupBy('email');

                    // Tables disponibles pour <select>
                    $tablesDisponibles = Table::where('serveur_id', $serveurId)
                        ->orWhere('nom_table', 'Commande externe')
                        ->get();

                    return view('serveur.commandes_en_ligne', compact('commandesFiltrees', 'tablesDisponibles'));
                }


            public function prendreCommandesClient(Request $request)
            {
                $orderIds = $request->input('order_ids', []);
                $serveurId = $request->input('serveur_id');
                $tableId = $request->input('table_id');

                foreach ($orderIds as $orderId) {
                    $order = Order::find($orderId);

                    if (!$order || !$order->food_id) {
                        Log::error("Commande introuvable ou food_id manquant pour l'order ID: $orderId");
                        continue;
                    }

                    // Vérifier si le client a une réservation active
                    $reservation = Book::where('name', $order->name)
                        ->whereDate('date', now()->toDateString())
                        ->where('payment_status', 'non_payé')
                        ->latest()
                        ->first();

                    if ($reservation) {
                        $tableId = $reservation->table_id;
                    }

                    // Fallback vers "Commande externe"
                    if (!$tableId) {
                        $tableExterne = Table::where('nom_table', 'Commande externe')->first();
                        $tableId = $tableExterne ? $tableExterne->id : null;
                        if (!$tableId) {
                            return redirect()->back()->with('error', 'La table "Commande externe" est introuvable.');
                        }
                    }

                    ServerOrder::create([
                        'serveur_id' => $serveurId,
                        'table_id' => $tableId,
                        'food_id' => $order->food_id,
                        'quantite' => $order->quantity,
                        'statut' => 'en_attente',
                        'commande_en_ligne_id' => $order->id,
                        'payment_status' => 'non_payé',
                    ]);

                    $order->update(['delivery_status' => 'Delivered']);
                }

                // Marquer la table comme occupée sauf "Commande externe"
                $table = Table::find($tableId);
                if ($table && $table->nom_table !== 'Commande externe') {
                    $table->update([
                        'serveur_id' => $serveurId,
                        'statut' => 'occupée',
                    ]);
                }

                return redirect()->back()->with('success', 'Commandes prises en charge avec succès.');
            }

        

            public function payerCommandesGroupes(Table $table)
            {
                // Met à jour toutes les commandes non payées pour cette table
                $table->commandes()->where('payment_status', 'non_payé')->update(['payment_status' => 'payé']);

                // Libérer la table (statut dispo et serveur_id nul)
                $table->update([
                    'statut' => 'Disponible',
                    'serveur_id' => null,
                ]);

                return redirect()->back()->with('success', 'Paiement des commandes effectué. Table libérée.');
            }


            
            
             public function board()
            {
                $serveurId = Auth::id();

                $commandesJour = ServerOrder::whereDate('created_at', today())
                                    ->where('serveur_id', $serveurId)
                                    ->count();

                $tablesServies = ServerOrder::whereDate('created_at', today())
                                    ->where('serveur_id', $serveurId)
                                    ->distinct('table_id')
                                    ->count('table_id');

                $reservationsActives = Book::whereDate('date', today())
                                    ->where('payment_status', 'non_payé') // ou 'payé', selon ta logique
                                    ->count();;

                $platsServis = ServerOrder::whereDate('created_at', today())
                                    ->where('serveur_id', $serveurId)
                                    ->sum('quantite');

                return view('serveur.board', compact(
                    'commandesJour', 'tablesServies', 'reservationsActives', 'platsServis'
                ));
            }

}