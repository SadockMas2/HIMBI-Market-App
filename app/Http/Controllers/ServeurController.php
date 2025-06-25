<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Book;
use App\Models\Booking;
use App\Models\Serveur;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServeurController extends Controller
{


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





}