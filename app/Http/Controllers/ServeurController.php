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

            if ($table->serveur_id == Auth::id()) {
                $table->serveur_id = null;
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

                $tables = Table::with([
                    'reservation' => function ($q) {
                        $q->latest();
                    },
                    'commandes.food'
                ])
                ->where('serveur_id', $serveurId)
                ->get();

                return view('serveur.mesTables', compact('tables'));
            }



        public function nouvelleCommande()
        {
            $serveurId = Auth::id();
            $tables = Table::where('serveur_id', $serveurId)->get();
            $foods = Food::all();

            return view('serveur.nouvelle_commande', compact('tables', 'foods'));
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
                'food_id' => 'required|exists:food,id',
                'quantite' => 'required|integer|min:1'
            ]);

            ServerOrder::create([
                'serveur_id' => Auth::id(),
                'table_id' => $request->table_id,
                'food_id' => $request->food_id,
                'quantite' => $request->quantite,
                'statut' => 'en_attente',
            ]);

            return redirect()->route('serveur.mesTables')->with('success', 'Commande enregistrée avec succès.');

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
                $commandes = ServerOrder::with('food')->where('table_id', $table_id)
                                ->where('payment_status', 'payé')->get();

                $total = $commandes->sum(fn($cmd) => $cmd->quantite * $cmd->food->price);

                $pdf = PDF::loadView('pdfs.recu_commande', compact('commandes', 'total'));
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
                // Commandes en ligne en cours
                $commandes = Order::where('delivery_status', 'In Progress')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->groupBy('email'); // groupe par client

                $tablesDisponibles = Table::where('statut', 'disponible')->get();

                return view('serveur.commandes_en_ligne', compact('commandes', 'tablesDisponibles'));
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

                    ServerOrder::create([
                        'serveur_id' => $serveurId,
                        'table_id' => $tableId,
                        'food_id' => $order->food_id,
                        'quantite' => $order->quantity,
                        'statut' => 'en_attente',
                        'commande_en_ligne_id' => $order->id,
                        'payment_status' => 'non_payé',  // Ajout du statut paiement
                    ]);

                    $order->update(['delivery_status' => 'Taken']);
                }

                $table = Table::find($tableId);
                if ($table) {
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


}