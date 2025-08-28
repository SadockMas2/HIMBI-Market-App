@extends('serveur.index') {{-- Layout serveur avec sidebar --}}

@section('content')


<style>
    /* CONTENEUR PRINCIPAL */
    .dashboard-wrapper {
        background: url('/images_sections/serveur.jpg') no-repeat center center;
        background-size: cover;
        position: relative;
        min-height: 100vh;
        padding: 80px 20px 40px;
    }

    /* OVERLAY SOMBRE */
    .dashboard-overlay {
        background: rgba(15, 15, 20, 0.85);
        padding: 50px 30px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.6);
    }

    /* TITRE */
    .dashboard-overlay h2 {
        font-weight: 700;
        font-size: 2rem;
        color: #f8f9fa;
    }

    /* CARDS */
    .card-custom {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border: none;
        color: #f8f9fa;
        border-radius: 20px;
        padding: 25px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .card-custom:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    }

    /* ICONES */
    .card-custom i {
        font-size: 40px;
        margin-bottom: 15px;
        color: #ffc107;
    }

    /* TITRES */
    .card-custom h5 {
        font-weight: 700;
        margin-bottom: 6px;
        font-size: 1.25rem;
    }

    /* TEXTE */
    .card-custom small {
        color: #adb5bd;
        font-size: 0.9rem;
    }

    /* ANIMATION NOUVELLE COMMANDE */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
        70% { box-shadow: 0 0 25px 15px rgba(255, 193, 7, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
    }

    .pulse {
        animation: pulse 1s ease-in-out 3; /* répète 3 fois */
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .dashboard-overlay {
            padding: 30px 20px;
        }
        .dashboard-overlay h2 {
            font-size: 1.5rem;
        }
    }
    
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-overlay container text-center">
        <h2 class="mb-5">👋 Bienvenue, <span class="text-warning">{{ Auth::user()->name }}</span></h2>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card card-custom" id="cardCommandes">
                    <i class="fa fa-receipt"></i>
                    <h5>{{ $commandesJour }} Commandes</h5>
                    <small>Aujourd'hui</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-custom" id="cardTables">
                    <i class="fa fa-chair"></i>
                    <h5>{{ $tablesServies }} Tables</h5>
                    <small>Servies</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-custom" id="cardReservations">
                    <i class="fa fa-calendar-check"></i>
                    <h5>{{ $reservationsActives }} Réservations</h5>
                    <small>En cours</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-custom" id="cardPlats">
                    <i class="fa fa-utensils"></i>
                    <h5>{{ $platsServis }} Plats</h5>
                    <small>Servis aujourd'hui</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

