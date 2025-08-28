@extends('layouts.app')

@section('content')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<style>
.checkout-section {
    background-image: url('{{ asset('images_sections/reservation_table-bg.jpg') }}');
    background-position: center top;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-color: rgba(0,0,0,0.6);
    padding: 50px 20px;
    border-radius: 16px;
    color: #fff;
}

.checkout-overlay {
    position: absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.7);
    z-index: 1;
}

.checkout-content {
    position: relative;
    z-index: 2;
}

h2 {
    color: #ffc107;
    text-align: center;
    margin-bottom: 30px;
}

.form-label {
    color: #fff;
}

.btn-confirm {
    display: inline-block;
    margin: 15px auto;
    padding: 12px 35px;
    background: linear-gradient(45deg, #28a745, #218838);
    border: none;
    color: white;
    font-size: 17px;
    font-weight: bold;
    border-radius: 30px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-confirm:hover {
    background: linear-gradient(45deg, #218838, #1e7e34);
    box-shadow: 0 4px 15px rgba(0,0,0,0.5);
}
</style>

<div class="container checkout-section position-relative">
    <div class="checkout-overlay"></div>
    <div class="checkout-content">
        <h2>✅ Finaliser ma commande</h2>

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

        <form action="{{ url('confirm_order') }}" method="POST">
            @csrf

            {{-- Nom, email, téléphone, adresse --}}
            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
            <input type="hidden" name="adress" value="{{ Auth::user()->adress }}">

            {{-- Mode consommation --}}
            <div class="mb-3">
                <label class="form-label">Mode de consommation</label>
                <select name="mode" class="form-select" id="modeSelect" required>
                    <option value="">-- Choisir --</option>
                    <option value="sur_place">Sur place</option>
                    <option value="a_emporter">À emporter</option>
                </select>
            </div>

            {{-- Sélection table --}}
            <div class="mb-3" id="tableSelection" style="display:none;">
                <label class="form-label">Choisir une table</label>
                <select name="table_id" class="form-select">
                    <option value="">-- Sélectionner une table --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->nom_table }} ({{ $table->capacite }} pers.)</option>
                    @endforeach
                </select>
            </div>

            {{-- Récapitulatif panier --}}
            <h3 class="text-center mt-4">🛒 Récapitulatif</h3>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Plat</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grand_total = 0; @endphp
                    @foreach($cart_items as $item)
                        @php
                            $total = $item->price * $item->quantity;
                            $grand_total += $total;
                        @endphp
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price,2) }}</td>
                            <td>${{ number_format($total,2) }}</td>

                            {{-- Champs cachés --}}
                            <input type="hidden" name="food_id[]" value="{{ $item->food_id }}">
                            <input type="hidden" name="title[]" value="{{ $item->title }}">
                            <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
                            <input type="hidden" name="price[]" value="{{ $item->price }}">
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 class="text-center">Total: ${{ number_format($grand_total,2) }}</h4>

            <div class="text-center mt-4">
                <button type="submit" class="btn-confirm btn-lg">✅ Confirmer la commande</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modeSelect = document.getElementById('modeSelect');
    const tableDiv = document.getElementById('tableSelection');

    modeSelect.addEventListener('change', function() {
        tableDiv.style.display = this.value === 'sur_place' ? 'block' : 'none';
    });
</script>

@endsection
