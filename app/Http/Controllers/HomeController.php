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
         if (Auth::id()) 
        {
        // Récupère le type de l’utilisateur connecté
            $usertype = Auth::user()->usertype;

            if ($usertype === 'user')
            {
                $data = Food::all();
                $tables = Table::where('statut', 'Disponible')->get();

                return view('home.index', compact('data','tables'));

            }
            elseif ($usertype === 'serveur')
            {
                return view('serveur.index');
                
            }

        
        else 
        {
            $total_utilisateurs = User::where('usertype', '=', 'user')->count();
            $total_plats = Food::count();
            $total_commandes = Order::count();
            $total_reservations = Table::where('statut', '=', 'Disponible')->count();
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

    // Si personne n’est connecté
    return redirect()->route('login');
}





    public function add_cart(Request $request,$id)
    {
        
        if(Auth::id())
        {
         $food = Food::find($id);

        $cart_title = $food->title;
        $cart_details = $food->detail;
        $cart_price = Str::remove('$',$food->price);
        $cart_image = $food->image;  
        
        
            $data = new Cart;
            $data->title = $cart_title;
            $data->details = $cart_details;
            $data->price = $cart_price  * $request->qty;
            $data->image = $cart_image;
            $data->quantity = $request->qty;

            $data->userid = Auth::user()->id;

        $data->save();
        return redirect()->back();


        }
        
        else
        {
            return redirect("login");
        }
    }   

   public function my_cart()
    {
           if (!Auth::check())
                {
                     return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder au panier.');
                }

    $user_id = Auth::user()->id;
    $data = Cart::where('userid', '=', $user_id)->get();    
    return view('home.my_cart', compact('data'));
        }
    public function remove_cart($id)

    {
        $data = cart::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function confirm_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $cartItems = Cart::where('userid', '=', $user_id)->get();

        foreach ($cartItems as $cart) {
            $food = Food::where('title', $cart->title)->first();

            // Sécurité : vérifie qu'on a trouvé le plat
            if (!$food) continue;

            $order = new Order;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->adress = $request->adress;
            $order->title = $cart->title;
            $order->quantity = $cart->quantity;
            $order->price = $cart->price;
            $order->image = $cart->image;
            $order->food_id = $food->id;

            // Alerte stock insuffisant
            $order->stock_insuffisant = $food->stock < $cart->quantity;

            $order->save();

            // Décrémenter le stock
            $food->stock -= $cart->quantity;
            $food->save();

            // Supprimer le panier
            $cart->delete();
        }

        return redirect()->back()->with('success', 'Commande confirmée et stock mis à jour');
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



