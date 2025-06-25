<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use App\Models\Table;
use App\Models\Serveur;


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

            return view('admin.view_table', compact('tables'));
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
    }



