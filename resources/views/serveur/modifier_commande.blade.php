@extends('serveur.index')

@section('content')
<div class="container mt-5">
    <h2>Modifier la commande</h2>

    <form action="{{ route('serveur.commande.update', $commande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="food_id" class="form-label">Plat</label>
            <select name="food_id" id="food_id" class="form-select" required>
                @foreach($foods as $food)
                    <option value="{{ $food->id }}" @if($commande->food_id == $food->id) selected @endif>
                        {{ $food->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantité</label>
            <input type="number" name="quantity" id="quantity" value="{{ $commande->quantity }}" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('serveur.mesTables') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
