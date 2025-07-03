<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServeurController;





            Route::get('/', [HomeController::class,'my_home'] );
            Route::get('/home',[HomeController::class,'index']);
            Route::post('/add_cart/{id}',[HomeController::class,'add_cart']);
            Route::get('/my_cart',[HomeController::class,'my_cart']);
            Route::get('/remove_cart/{id}',[HomeController::class,'remove_cart']);
            Route::post('/confirm_order',[HomeController::class,'confirm_order']);
            Route::post('book_table',[HomeController::class,'book_table']); 





            Route::get('/show_user', [AdminController::class, 'show_user']);
            Route::get('/add_food',[AdminController::class,'add_food']);
            Route::post('/upload_food',[AdminController::class,'upload_food']);
            Route::get('/view_food',[AdminController::class,'view_food']);
            Route::get('/delete_food/{id}',[AdminController::class,'delete_food']);
            Route::get('/update_food/{id}',[AdminController::class,'update_food']);
            Route::post('/edit_food/{id}',[AdminController::class,'edit_food']);

            Route::get('/view_table',[AdminController::class,'view_table']);
            Route::get('/add_table', [AdminController::class, 'showAddTableForm']);
            Route::post('/add_table', [AdminController::class, 'add_table']);
            Route::put('/update_table_status/{id}', [AdminController::class, 'update_table_status']);

            Route::get('/orders',[AdminController::class,'orders']); 
            Route::post('/store_order',[AdminController::class,'store_order']); 
            Route::get('on_the_way/{id}',[AdminController::class,'on_the_way']); 
            Route::get('delivered/{id}',[AdminController::class,'delivered']); 
            Route::get('canceled/{id}',[AdminController::class,'canceled']); 
            Route::get('reservations',[AdminController::class,'reservations']); 
            Route::get('/view_serveur', [AdminController::class, 'view_serveur']);
            Route::get('/add_serveur', [AdminController::class, 'add_serveur']);
            Route::post('/add_serveur', [AdminController::class, 'store_serveur']);
            Route::delete('destroy_serveur/{id}', [AdminController::class, 'destroy_serveur']);
            Route::get('/showBookingForm', [HomeController::class, 'showBookingForm']);

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







            Route::middleware(['auth'])->group(function () {

                Route::get('dashboard-serveur', [ServeurController::class, 'dashboard']);
                Route::get('nouvelle_commande', [ServeurController::class, 'nouvelleCommande'])->name('serveur.commande.form');
                Route::post('enregistrer_commande', [ServeurController::class, 'enregistrerCommande'])->name('serveur.commande.store');
                Route::get('mesTables', [ServeurController::class, 'mesTables'])->name('serveur.mesTables');
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

                Route::post('/serveur/prendre-commandes-client', [ServeurController::class, 'prendreCommandesClient'])
    ->name('serveur.prendre_commandes_client');

            });






            Route::middleware([
                'auth:sanctum',
                config('jetstream.auth_session'),
                'verified',
            ])->group(function () {
                
                
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');

            });
