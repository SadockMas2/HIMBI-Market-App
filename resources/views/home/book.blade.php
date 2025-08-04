@php
    use Illuminate\Support\Facades\Auth;
@endphp

<style>
.reservation-section {
    position: relative;
    background-image: url('/images_sections/reservation_table-bg.jpg');
    background-position: center top;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-color: rgba(0, 0, 0, 0.6);
    padding: 80px 20px;
    border-radius: 16px;
    overflow: hidden;
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
}

.reservation-section h2 {
    color: #ffc107;
}

.form-label {
    color: #fff;
}
</style>

<div id="book" class="container-fluid reservation-section">
    <div class="reservation-overlay"></div>

    <div class="container reservation-content text-light">
        <h2 class="text-center mb-4">Trouver une table disponible</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger text-center">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li style="list-style: none;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('book_table') }}" method="POST" class="row g-3 justify-content-center">
            @csrf

            @if(Auth::check())
                <div class="col-md-4">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                </div>
            @endif

            @if(Auth::check())
                <div class="col-md-4">
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

                        <div class="col-md-4">
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


            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-warning btn-lg px-5">Réserver</button>
            </div>
        </form>
    </div>
</div>
