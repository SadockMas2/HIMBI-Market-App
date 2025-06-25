<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServeurController;




Route::get('/show_user', [AdminController::class, 'show_user']);


Route::get('/', function () {return view('welcome');});


Route::get('/', [HomeController::class,'my_home'] );


Route::get('/home',[HomeController::class,'index']);


Route::get('/add_food',[AdminController::class,'add_food']);


Route::post('/upload_food',[AdminController::class,'upload_food']);


Route::get('/view_food',[AdminController::class,'view_food']);


Route::get('/view_table',[AdminController::class,'view_table']);



Route::get('/delete_food/{id}',[AdminController::class,'delete_food']);


Route::get('/update_food/{id}',[AdminController::class,'update_food']);


Route::post('/edit_food/{id}',[AdminController::class,'edit_food']);


Route::post('/add_cart/{id}',[HomeController::class,'add_cart']);


Route::get('/my_cart',[HomeController::class,'my_cart']);


Route::get('/remove_cart/{id}',[HomeController::class,'remove_cart']);


Route::post('/confirm_order',[HomeController::class,'confirm_order']);


Route::get('/orders',[AdminController::class,'orders']); 


Route::post('/store_order',[AdminController::class,'store_order']); 


Route::get('on_the_way/{id}',[AdminController::class,'on_the_way']); 


Route::get('delivered/{id}',[AdminController::class,'delivered']); 


Route::get('canceled/{id}',[AdminController::class,'canceled']); 


Route::post('book_table',[HomeController::class,'book_table']); 


Route::get('reservations',[AdminController::class,'reservations']); 


Route::get('/view_serveur', [AdminController::class, 'view_serveur']);


Route::get('/add_serveur', [AdminController::class, 'add_serveur']);


Route::post('/add_serveur', [AdminController::class, 'store_serveur']);


Route::delete('destroy_serveur/{id}', [AdminController::class, 'destroy_serveur']);


Route::get('showReservations', [ServeurController::class,'showReservations']);


Route::get('order', [ServeurController::class,'order']);


Route::get('/showBookingForm', [HomeController::class, 'showBookingForm']);


Route::get('/add_table', [AdminController::class, 'showAddTableForm']);


Route::post('/add_table', [AdminController::class, 'add_table']);


Route::put('/update_table_status/{id}', [AdminController::class, 'update_table_status']);


Route::get('show_stock', [AdminController::class, 'show_stock']);


Route::post('update_stock/{id}', [AdminController::class, 'update_stock']);


Route::get('alert_stock', [AdminController::class, 'alert_stock']);


Route::get('paiements', [AdminController::class, 'paiements']);














Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    
Route::get('/dashboard', function () {return view('dashboard');
    })->name('dashboard');
});
