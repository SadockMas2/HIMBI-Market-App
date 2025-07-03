<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\Serveur;
use App\Models\ServerOrder;  // ajoute ce use si tu as ce modèle
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Mail\Transport\ResendTransport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;




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

        public function update_food($id)
        {
            $food = Food::find($id);
            return view('admin.update_food',compact('food'));
        }

         public function edit_food(Request $request,$id)
        {
            $data = Food::find($id);
            $data->title = $request->title;
            $data->detail = $request->details;
            $data->price = $request->price;


            $image = $request->image;

                if($image)
                {

                    $imagename=time().'.'.$image->getClientOriginalExtension();
                    $request->image->move('food_img', $imagename);

                        $data->image = $imagename;

                }

            $data->save();
            return redirect('view_food');
        }


        public function orders()
        {
            $data = Order::all();

            return view('admin.order',compact('data'));
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

        public function add_serveur()
        {
         return view('admin.add_serveur'); // Crée cette vue aussi
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
            
            $food = Food::all();
            return view('admin.show_stock', compact('food')); // ou le chemin correct vers ta vue
            
        }
        
       public function update_stock(Request $request, $id)
        {
            $request->validate([
                'stock' => 'required|integer|min:0',
            ]);

            $food = Food::findOrFail($id);
            $food->stock = $request->stock;
            $food->save();

            return redirect()->back()->with('success', 'Stock mis à jour avec succès.');
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




}


