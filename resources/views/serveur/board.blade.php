    @extends('serveur.index') {{-- Layout du serveur avec sidebar --}}

@section('content')
<style>
    .dashboard-wrapper {
        background: url('/images_sections/serveur.jpg') no-repeat center center;
        background-size: cover;
        position: relative;
        min-height: 100vh;
        padding: 60px 20px;
    }

    .dashboard-overlay {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 40px;
        border-radius: 12px;
    }

    .card-custom {
        background-color: #1f1f1f;
        border: none;
        color: #ffc107;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        border-left: 6px solid #ffc107;
        transition: 0.3s ease-in-out;
    }

    .card-custom:hover {
        transform: scale(1.02);
        border-left-color: #ff214f;
    }

    .card-custom .card-body {
        padding: 25px;
    }

    .card-custom h5 {
        font-weight: 700;
    }

    .card-custom i {
        font-size: 30px;
        margin-bottom: 10px;
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-overlay text-white container">
        <h2 class="mb-5 text-center">👋 Bienvenue, {{ Auth::user()->name }} !</h2>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fa fa-receipt"></i>
                        <h5>{{ $commandesJour }} Commandes du jour</h5>
                        <small>Reçues aujourd'hui</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fa fa-chair"></i>
                        <h5>{{ $tablesServies }} Tables servies</h5>
                        <small>Actuellement occupées</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fa fa-calendar-check"></i>
                        <h5>{{ $reservationsActives }} Réservations</h5>
                        <small>En cours</small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card card-custom text-center">
                    <div class="card-body">
                        <i class="fa fa-utensils"></i>
                        <h5>{{ $platsServis }} Plats servis</h5>
                        <small>Total aujourd'hui</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
