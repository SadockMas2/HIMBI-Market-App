@extends('serveur.index')

@section('content')
<style>
  body {
    background-color: #260814;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    color: #eee;
  }

  .page-content {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px 25px;
    background: #2f2f2f;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  }

  h2 {
    text-align: center;
    color: #ffffff;
    font-size: 28px;
    margin-bottom: 25px;
  }

  .form-label {
    color: #ddd;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .form-select,
  .form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #444;
    border-radius: 8px;
    background-color: #1b1b1b;
    color: #fff;
    font-size: 16px;
    margin-bottom: 20px;
  }

  .form-select:focus,
  .form-control:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
  }

  .btn-primary {
    background-color: #3498db;
    border: none;
    padding: 12px 20px;
    width: 100%;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #2471a3;
  }

  .alert {
    padding: 10px 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 600;
  }

  .alert-success {
    background-color: #27ae60;
    color: #fff;
  }

  @media (max-width: 500px) {
    .page-content {
      margin: 30px 10px;
      padding: 25px 15px;
    }

    h2 {
      font-size: 24px;
    }

    .btn-primary {
      font-size: 15px;
    }
  }
</style>

<div class="page-content">
    <h2>Nouvelle Commande Multi-Plats</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('serveur.commande.storeMultiple') }}">
        @csrf

        <div class="mb-4">
            <label for="table_id" class="form-label">Table</label>
            <select name="table_id" id="table_id" class="form-select" required>
                <option value="">-- Choisir une table --</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->nom_table }}</option>
                @endforeach
            </select>
        </div>

        <div id="plats-container">
            <div class="row align-items-end plat-row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Plat</label>
                    <select name="food_id[]" class="form-select" required>
                        <option value="">-- Choisir un plat --</option>
                        @foreach($foods as $food)
                            <option value="{{ $food->id }}">{{ $food->title }} - {{ $food->price }} $</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Quantité</label>
                    <input type="number" name="quantite[]" class="form-control" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-plat">X</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-plat" class="btn btn-warning mb-3">+ Ajouter un autre plat</button>
        <button type="submit" class="btn btn-primary">✅ Valider la commande</button>
    </form>
</div>

<script>
    document.getElementById('add-plat').addEventListener('click', function () {
        const container = document.getElementById('plats-container');
        const row = document.querySelector('.plat-row');
        const clone = row.cloneNode(true);

        // Réinitialiser les champs
        clone.querySelectorAll('select, input').forEach(el => el.value = '');

        container.appendChild(clone);
    });

    // Supprimer un plat
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-plat')) {
            const rows = document.querySelectorAll('.plat-row');
            if (rows.length > 1) {
                e.target.closest('.plat-row').remove();
            }
        }
    });
</script>
@endsection