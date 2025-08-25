<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServeurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodIngredientController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil publique ou redirection si connecté
Route::get('/', function () {
    // page publique de bienvenue, accessible même si connecté
    return view('bienvenue');
});


// Page d'accueil principale (sections scrollables)
// Protégée par auth (connexion obligatoire)
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);

    // Routes liées au panier / commandes
    Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);
    Route::get('/my_cart', [HomeController::class, 'my_cart'])->name('my_cart');
    Route::post('/update_cart/{id}', [HomeController::class, 'update_cart'])->middleware('auth');
    Route::post('/update_cart_multiple', [HomeController::class, 'update_cart_multiple'])->middleware('auth');
    Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);
    Route::post('/confirm_order', [HomeController::class, 'confirm_order']);
    Route::post('/add_cart_multiple', [HomeController::class, 'add_cart_multiple'])->name('add_cart_multiple');

    // Réservation
    Route::post('book_table', [HomeController::class, 'book_table']);
    Route::get('/book', [HomeController::class, 'showBookingForm'])->name('book.table');
});


/*
|--------------------------------------------------------------------------
| Routes Admin (ajoute ici un middleware auth et éventuellement admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Gestion utilisateurs, plats, tables, commandes, serveurs, stocks, paiements...

    Route::get('/show_user', [AdminController::class, 'show_user']);
    Route::get('/add_food', [AdminController::class, 'add_food']);
    Route::post('/upload_food', [AdminController::class, 'upload_food']);
    Route::get('/view_food', [AdminController::class, 'view_food']);
    Route::get('/delete_food/{id}', [AdminController::class, 'delete_food']);
    Route::get('/update_food/{id}', [AdminController::class, 'update_food']);
    Route::post('/update_food_post/{id}', [AdminController::class, 'update_food_post'])->name('update_food_post');
    Route::post('/edit_food/{id}', [AdminController::class, 'edit_food']);
    Route::get('/view_table', [AdminController::class, 'view_table']);
    Route::get('/add_table', [AdminController::class, 'showAddTableForm']);
    Route::post('/add_table', [AdminController::class, 'add_table']);
    Route::delete('delete_table/{id}', [AdminController::class, 'delete_table']);

    Route::put('/update_table_status/{id}', [AdminController::class, 'update_table_status']);
    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/deliver_all/{email}', [AdminController::class, 'deliverAll'])->name('deliver_all');
    Route::get('/cancel_all/{email}', [AdminController::class, 'cancelAll'])->name('cancel_all');
    Route::post('/store_order', [AdminController::class, 'store_order']);
    Route::get('on_the_way/{id}', [AdminController::class, 'on_the_way']);
    Route::get('delivered/{id}', [AdminController::class, 'delivered']);
    Route::get('canceled/{id}', [AdminController::class, 'canceled']);
    Route::get('reservations', [AdminController::class, 'reservations']);
    Route::get('/view_serveur', [AdminController::class, 'view_serveur']);
    Route::get('/view_user', [AdminController::class, 'view_user']);
    Route::get('/add_serveur', [AdminController::class, 'add_serveur']);
    Route::get('/add_user', [AdminController::class, 'add_user']);
    Route::post('/add_user', [AdminController::class, 'store_user']);
    Route::post('/add_serveur', [AdminController::class, 'store_serveur']);
    Route::delete('destroy_serveur/{id}', [AdminController::class, 'destroy_serveur']);
    Route::delete('destroy_user/{id}', [AdminController::class, 'destroy_user']); //Supprimer un client

    Route::get('admin/commandes-en-cours', [AdminController::class, 'commandesEnCours'])->name('admin.commandes_en_cours');
    Route::put('admin/commande/{id}/update-status', [AdminController::class, 'updateCommandeStatus'])->name('admin.commande.update_status');
    Route::put('admin/table/{id}/liberer', [AdminController::class, 'libererTable'])->name('admin.table.liberer');
    Route::post('assign_serveur/{id}', [AdminController::class, 'assign_serveur']);
    Route::get('show_stock', [AdminController::class, 'show_stock']);
    Route::post('update_stock/{id}', [AdminController::class, 'update_stock']);
    Route::get('alert_stock', [AdminController::class, 'alert_stock']);
    Route::get('paiements', [AdminController::class, 'paiements']);
    Route::get('/historiqueCommandesParServeur/{serveurId}', [AdminController::class, 'historiqueCommandesParServeur'])->name('admin.historique_commandes');
    Route::get('/print/invoice/{serverOrderId}', [AdminController::class, 'printInvoice'])->name('print.invoice');
    Route::get('/print/receipt/{serverOrderId}', [AdminController::class, 'printReceipt'])->name('print.receipt');
    Route::get('admin/facture/{id}', [AdminController::class, 'afficherFacture'])->name('admin.facture');
    Route::post('admin/marquer-paye/{id}', [AdminController::class, 'marquerCommePaye'])->name('admin.marquer_paye');
    Route::get('admin/recu/{id}', [AdminController::class, 'afficherRecu'])->name('admin.recu');
    Route::get('/facture/{id}', [AdminController::class, 'facture'])->name('admin.facture');
    Route::get('/recu/{id}', [AdminController::class, 'recu'])->name('admin.recu');
    Route::get('/historique', [AdminController::class, 'historique'])->name('admin.historique');
    Route::get('/historique/pdf', [AdminController::class, 'exportHistoriquePDF'])->name('admin.historique.pdf');
    Route::post('/kitchen/prepare/{id}', [AdminController::class, 'prepareDish'])->name('prepareDish');
    Route::post('/update-drink-stock/{id}', [AdminController::class, 'updateDrinkStock'])->name('updateDrinkStock');
    Route::get('/kitchen', [AdminController::class, 'kitchen'])->name('kitchen');
    Route::post('/food/{id}/ingredients', [AdminController::class, 'storeIngredients'])->name('food.ingredients.store');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/foods/{id}/ingredients', [AdminController::class, 'editFoodIngredients'])->name('admin.view_all_ingredients');
    Route::put('/foods/{id}/ingredients', [AdminController::class, 'updateIngredients'])->name('admin.ingredients.update');
    
    Route::get('/foods/{id}/edit-ingredients', [AdminController::class, 'showIngredientsForFood'])->name('admin.foods.edit_ingredients');
    Route::get('/ingredients', [AdminController::class, 'indexIngredients'])->name('admin.ingredients.index');
    Route::get('/ingredients/edit/{id}', [AdminController::class, 'editIngredients'])->name('admin.ingredients.edit');
    Route::put('/ingredients/update/{id}', [AdminController::class, 'updateIngredient'])->name('admin.ingredients.update_single');
    Route::get('/ingredients/delete/{id}', [AdminController::class, 'deleteIngredient'])->name('admin.ingredients.delete');

   


    Route::get('/stock-history', [AdminController::class, 'showStockHistory'])
    ->name('admin.stock_history');

    Route::get('/stock-history/pdf', [AdminController::class, 'exportStockHistoryPdf'])
    ->name('admin.stock_history.pdf');


    


        // Formulaire d’affectation des ingrédients pour un plat
    Route::get('/foods/{food}/ingredients', [FoodIngredientController::class, 'create'])
        ->name('food.ingredients.create');

    // Enregistrement des ingrédients (plusieurs à la fois)
    Route::post('/foods/{food}/ingredients', [FoodIngredientController::class, 'store'])
        ->name('food.ingredients.store');
    });


/*
|--------------------------------------------------------------------------
| Routes Serveur (protégées)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
 
    Route::get('/serveur/board', [ServeurController::class, 'board'])
    ->middleware(['auth', 'verified']) // important !
    ->name('serveur.board');

    Route::get('nouvelle_commande', [ServeurController::class, 'nouvelleCommande'])->name('serveur.commande.form');
    Route::post('enregistrer_commande', [ServeurController::class, 'enregistrerCommande'])->name('serveur.commande.store');
    Route::post('/serveur/commande-multiple', [ServeurController::class, 'enregistrerCommandeMultiple'])->name('serveur.commande.storeMultiple');
    Route::get('mesTables', [ServeurController::class, 'mesTables'])->name('serveur.mesTables');
    // Route::get('/commandes', [ServeurController::class, 'commandes'])
    //     ->name('commandes');

    // // Modifier une commande
    // Route::get('/commande/{id}/modifier', [ServeurController::class, 'modifierCommande']);
    // // Supprimer une commande
    // Route::delete('/commande/{id}/supprimer', [ServeurController::class, 'supprimerCommande']);
     


    Route::post('serveur/reserver_table', [ServeurController::class, 'reserverTable'])->name('serveur.reserver_table');
    Route::get('stock-alerts', [ServeurController::class, 'stockAlerts']);
    Route::get('profile', [ServeurController::class, 'profile']);
    Route::post('release_table/{id}', [ServeurController::class, 'release_table']);
    Route::get('createOrder', [ServeurController::class, 'createOrder']);
    Route::get('showReservations', [ServeurController::class, 'showReservations']);
    Route::get('commande/{id}/facture', [ServeurController::class, 'showFacture'])->name('serveur.commande.facture');

    // Paiement réservation
    Route::put('/serveur/reservation/{id}/payer', [ServeurController::class, 'payerReservation'])->name('serveur.reservation.payer');
    Route::put('/serveur/commande/{id}/payer', [ServeurController::class, 'payerCommande'])->name('serveur.commande.payer');

    // Génération PDF
    Route::get('/reservation/{id}/facture', [ServeurController::class, 'genererFactureReservation'])->name('facture.reservation');
    Route::get('/reservation/{id}/recu', [ServeurController::class, 'genererRecuReservation'])->name('recu.reservation');
    Route::get('/commande/{id}/facture', [ServeurController::class, 'genererFactureCommande'])->name('facture.commande');
    Route::get('/commande/{id}/recu', [ServeurController::class, 'genererRecuCommande'])->name('recu.commande');
    Route::get('facture-commandes/{table_id}', [ServeurController::class, 'factureCommandes'])->name('facture.commandes');
    Route::get('recu-commandes/{table_id}', [ServeurController::class, 'recuCommandes'])->name('recu.commandes');
    Route::put('payer-commandes/{table_id}', [ServeurController::class, 'payerCommandes'])->name('serveur.commandes.payer_groupes');
    Route::get('/serveur/commandes-en-ligne', [ServeurController::class, 'commandesEnLigneDisponibles'])->name('serveur.commandes_en_ligne');
    Route::post('/serveur/prendre-commande-en-ligne', [ServeurController::class, 'prendreCommandeEnLigne'])->name('serveur.prendre_commande_en_ligne');
    Route::post('/serveur/prendre-commandes-client', [ServeurController::class, 'prendreCommandesClient'])->name('serveur.prendre_commandes_client');
    

});


/*
|--------------------------------------------------------------------------
| Route Dashboard Jetstream
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/profile', [\Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController::class, 'show'])->name('profile.show');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});