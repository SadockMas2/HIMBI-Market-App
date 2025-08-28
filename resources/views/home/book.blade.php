@php
    use Illuminate\Support\Facades\Auth;
@endphp

<style>
/* === Section Réservation === */
.reservation-section {
    position: relative;
    background-image: url('{{ asset('images_sections/12.jpg') }}');
    background-position: center top;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    padding: 60px 20px;
    border-radius: 16px;
    overflow: hidden;
    color: #fff;
}

.reservation-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.reservation-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: 0 auto;
}

.reservation-content h2 {
    color: #ffc107;
    text-align: center;
    font-size: 2rem;
    margin-bottom: 30px;
    font-weight: bold;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
}

/* === Alerts === */
.alert {
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 15px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #28a745;
    color: #fff;
    text-align: center;
}

.alert-danger {
    background-color: #dc3545;
    color: #fff;
    text-align: center;
}

/* === Form Inputs === */
.form-label {
    color: #ededed;
    font-weight: 500;
}

.form-control, .form-select {
    background-color: rgba(255,255,255,0.1);
    border: 1px solid #ffc107;
    color: #b5aaaa;
    border-radius: 8px;
    padding: 10px;
    transition: 0.3s;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: #28a745;
    background-color: rgba(255,255,255,0.15);
    box-shadow: 0 0 8px rgba(40,167,69,0.6);
}

/* === Bouton Réserver === */
.btn-reserve {
    background: linear-gradient(45deg, #ffc107, #ffca2c);
    color: #000;
    font-weight: bold;
    font-size: 1.2rem;
    padding: 12px 40px;
    border-radius: 50px;
    border: none;
    transition: 0.3s;
}

.btn-reserve:hover {
    background: linear-gradient(45deg, #ffca2c, #ffc107);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.5);
}

/* === Responsive === */
@media (max-width: 768px) {
    .reservation-content {
        padding: 0 10px;
    }

    .reservation-content h2 {
        font-size: 1.6rem;
    }

    .form-control, .form-select {
        font-size: 0.9rem;
        padding: 8px;
    }

    .btn-reserve {
        font-size: 1rem;
        padding: 10px 25px;
        width: 100%;
    }
}
</style>

<div id="book" class="container-fluid reservation-section">
    <div class="reservation-overlay"></div>

    <div class="reservation-content">
        <h2>📅 Planifiez votre reservation</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li style="list-style: none;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('book_table') }}" method="POST" class="row g-3">
            @csrf

            @if(Auth::check())
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->phone }}" disabled>
                    <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                </div>
            @endif

            <div class="col-md-4">
                <label class="form-label">Nombre d'invités</label>
                <input type="number" class="form-control" name="guest" placeholder="1 à 20" min="1" max="20" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Heure</label>
                <input type="time" class="form-control" name="time" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" class="form-control" name="date" required>
            </div>

            <div class="col-md-12">
                <label class="form-label">Table</label>
                <select name="table_id" class="form-select" required>
                    <option value="">-- Choisir une table --</option>
                    @foreach($tables as $table)
                        @if($table->nom_table !== 'Commande externe')
                            <option value="{{ $table->id }}">
                                Table {{ $table->nom_table }} ({{ $table->capacite }} pers.)
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn-reserve">✅ Réserver</button>
            </div>
        </form>
    </div>
</div>
