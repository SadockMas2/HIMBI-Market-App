<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServeurController;

/*
|--------------------------------------------------------------------------
| API Routes for HIMBI-Market
|--------------------------------------------------------------------------
*/


// Routes protégées par authentification Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Utilisateur connecté
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | Routes Home (Client)
    |--------------------------------------------------------------------------
    */
    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index']);

        // Gestion panier
        Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);
        Route::post('/add_cart_multiple', [HomeController::class, 'add_cart_multiple']);
        Route::get('/my_cart', [HomeController::class, 'my_cart']);
        Route::post('/update_cart/{id}', [HomeController::class, 'update_cart']);
        Route::delete('/remove_cart/{id}', [HomeController::class, 'remove_cart']);
        Route::post('/confirm_order', [HomeController::class, 'confirm_order']);

        // Réservations
        Route::post('/book_table', [HomeController::class, 'book_table']);
        Route::get('/book_form', [HomeController::class, 'showBookingForm']);
    });

    /*
    |--------------------------------------------------------------------------
    | Routes Admin
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        // Utilisateurs
        Route::get('/users', [AdminController::class, 'show_user']);

        // Plats
        Route::get('/foods', [AdminController::class, 'view_food']);
        Route::post('/foods', [AdminController::class, 'upload_food']);
        Route::get('/foods/{id}', [AdminController::class, 'update_food']);
        Route::put('/foods/{id}', [AdminController::class, 'edit_food']);
        Route::delete('/foods/{id}', [AdminController::class, 'delete_food']);

        // Tables
        Route::get('/tables', [AdminController::class, 'view_table']);
        Route::post('/tables', [AdminController::class, 'add_table']);
        Route::put('/tables/{id}/status', [AdminController::class, 'update_table_status']);
        Route::put('/tables/{id}/release', [AdminController::class, 'libererTable']);

        // Commandes
        Route::get('/orders', [AdminController::class, 'orders']);
        Route::post('/orders', [AdminController::class, 'store_order']);
        Route::put('/orders/{id}/on_the_way', [AdminController::class, 'on_the_way']);
        Route::put('/orders/{id}/delivered', [AdminController::class, 'delivered']);
        Route::put('/orders/{id}/canceled', [AdminController::class, 'canceled']);
        Route::put('/orders/{id}/update_status', [AdminController::class, 'updateCommandeStatus']);

        // Réservations
        Route::get('/reservations', [AdminController::class, 'reservations']);

        // Serveurs
        Route::get('/servers', [AdminController::class, 'view_serveur']);
        Route::post('/servers', [AdminController::class, 'store_serveur']);
        Route::delete('/servers/{id}', [AdminController::class, 'destroy_serveur']);
        Route::post('/servers/{id}/assign', [AdminController::class, 'assign_serveur']);

        // Stocks
        Route::get('/stocks', [AdminController::class, 'show_stock']);
        Route::post('/stocks/{id}', [AdminController::class, 'update_stock']);
        Route::get('/stock_alerts', [AdminController::class, 'alert_stock']);

        // Paiements
        Route::get('/payments', [AdminController::class, 'paiements']);
        Route::post('/orders/{id}/mark_paid', [AdminController::class, 'marquerCommePaye']);

        // Historique & PDF
        Route::get('/orders/history', [AdminController::class, 'historique']);
        Route::get('/orders/history/pdf', [AdminController::class, 'exportHistoriquePDF']);
        Route::get('/orders/history/server/{serverId}', [AdminController::class, 'historiqueCommandesParServeur']);
        Route::get('/invoice/{orderId}', [AdminController::class, 'printInvoice']);
        Route::get('/receipt/{orderId}', [AdminController::class, 'printReceipt']);
        Route::get('/facture/{id}', [AdminController::class, 'afficherFacture']);
        Route::get('/recu/{id}', [AdminController::class, 'afficherRecu']);
    });

    /*
    |--------------------------------------------------------------------------
    | Routes Serveur
    |--------------------------------------------------------------------------
    */
    Route::prefix('serveur')->group(function () {
        Route::get('/board', [ServeurController::class, 'board']);

        Route::get('/new_order', [ServeurController::class, 'nouvelleCommande']);
        Route::post('/save_order', [ServeurController::class, 'enregistrerCommande']);
        Route::post('/save_orders_multiple', [ServeurController::class, 'enregistrerCommandeMultiple']);

        Route::get('/tables', [ServeurController::class, 'mesTables']);
        Route::post('/reserve_table', [ServeurController::class, 'reserverTable']);
        Route::post('/release_table/{id}', [ServeurController::class, 'release_table']);

        Route::get('/stock_alerts', [ServeurController::class, 'stockAlerts']);
        Route::get('/profile', [ServeurController::class, 'profile']);

        Route::get('/reservations', [ServeurController::class, 'showReservations']);

        // Paiement
        Route::put('/reservation/{id}/pay', [ServeurController::class, 'payerReservation']);
        Route::put('/order/{id}/pay', [ServeurController::class, 'payerCommande']);

        // Factures & reçus PDF
        Route::get('/reservation/{id}/invoice', [ServeurController::class, 'genererFactureReservation']);
        Route::get('/reservation/{id}/receipt', [ServeurController::class, 'genererRecuReservation']);
        Route::get('/order/{id}/invoice', [ServeurController::class, 'genererFactureCommande']);
        Route::get('/order/{id}/receipt', [ServeurController::class, 'genererRecuCommande']);

        Route::get('/invoices/{table_id}', [ServeurController::class, 'factureCommandes']);
        Route::get('/receipts/{table_id}', [ServeurController::class, 'recuCommandes']);
        Route::put('/pay_orders/{table_id}', [ServeurController::class, 'payerCommandes']);

        Route::get('/online_orders', [ServeurController::class, 'commandesEnLigneDisponibles']);
        Route::post('/take_online_order', [ServeurController::class, 'prendreCommandeEnLigne']);
        Route::post('/take_client_orders', [ServeurController::class, 'prendreCommandesClient']);
    });

});
