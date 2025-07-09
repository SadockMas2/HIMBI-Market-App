<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Book;
use App\Models\Table;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;




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




    public function add_cart(Request $request, $id)
    {
        if (Auth::check()) {
            $food = Food::find($id);

            $cart = new Cart;
            $cart->title = $food->title;
            $cart->details = $food->detail;
            $cart->price = Str::remove('$', $food->price) * $request->qty;
            $cart->image = $food->image;
            $cart->quantity = $request->qty;
            $cart->userid = Auth::id();

            $cart->save();
            return redirect()->back();
        } else {
            return redirect("login");
        }
    }
public function add_cart_multiple(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Connectez-vous pour ajouter au panier.');
    }

    $user_id = Auth::id();

    $food_ids = $request->food_ids; // Tableau des plats sélectionnés
    $quantities = $request->qty;    // Tableau associatif des quantités (id => qty)

    if (!$food_ids || count($food_ids) == 0) {
        return back()->with('error', 'Aucun plat sélectionné.');
    }

    foreach ($food_ids as $food_id) {
        $food = \App\Models\Food::find($food_id);

        if ($food) {
            $qty = isset($quantities[$food_id]) ? (int)$quantities[$food_id] : 1;

            $cart = new \App\Models\Cart();
            $cart->title = $food->title;
            $cart->details = $food->detail;
            $cart->price = Str::replace('$', '', $food->price) * $qty;
            $cart->image = $food->image;
            $cart->quantity = $qty;
            $cart->userid = $user_id;
            $cart->save();
        }
    }

    return redirect()->back()->with('success', 'Les plats sélectionnés ont été ajoutés au panier.');
}

    public function my_cart()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        $data = Cart::where('userid', Auth::id())->get();
        return view('home.my_cart', compact('data'));
    }

    
                public function confirm_order(Request $request)
                {
                    $user_id = Auth::id();
                    $food_ids = $request->food_id;
                    $titles = $request->title;
                    $quantities = $request->quantity;
                    $prices = $request->price;

                    if (!$food_ids || count($food_ids) === 0) {
                        return back()->with('error', 'Aucun plat sélectionné.');
                    }

                    for ($i = 0; $i < count($food_ids); $i++) {
                        $food = Food::find($food_ids[$i]);
                        if (!$food) continue;

                        $order = new Order;
                        $order->name = $request->name;
                        $order->email = $request->email;
                        $order->phone = $request->phone;
                        $order->adress = $request->adress;
                        $order->title = $titles[$i];
                        $order->quantity = $quantities[$i];
                        $order->price = $prices[$i];
                        $order->food_id = $food->id;
                        $order->stock_insuffisant = $food->stock < $quantities[$i];
                        $order->save();

                        $food->stock -= $quantities[$i];
                        $food->save();
                    }

                    // Vider le panier après commande
                    Cart::where('userid', $user_id)->delete();

                    return redirect('/')->with('success', 'Votre commande a été confirmée avec succès !');
                }




    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        if ($cart) $cart->delete();
        return redirect()->back();
    }



    
        public function showBookingForm()
        {
            $tables = Table::where('statut', 'disponible')->get();
            return view('home.book_table', compact('tables'));
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



