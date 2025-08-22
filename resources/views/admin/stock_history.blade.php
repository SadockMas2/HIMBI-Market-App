@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="page-header py-3">
        <h2 class="text-center">Historique du Stock</h2>
    </div>

    <!-- 🔍 Formulaire de filtre -->
    <form method="GET" action="{{ route('admin.stock_history') }}" class="row g-3 mb-4 bg-light p-3 rounded shadow-sm">
        <div class="col-md-4">
            <label for="food_id" class="form-label fw-bold">Filtrer par Plat</label>
            <select name="food_id" id="food_id" class="form-select">
                <option value="">-- Tous les plats --</option>
                @foreach($foods as $f)
                    <option value="{{ $f->id }}" {{ request('food_id') == $f->id ? 'selected' : '' }}>
                        {{ $f->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="date" class="form-label fw-bold">Filtrer par Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
        </div>

        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-search me-1"></i> Rechercher
            </button>
            <a href="{{ route('admin.stock_history') }}" class="btn btn-secondary w-100">
                <i class="fa fa-undo me-1"></i> Réinitialiser
            </a>
        </div>
    </form>

    <!-- 📄 Bouton Export PDF -->
    <div class="mb-3 text-end">
        <a href="{{ route('admin.stock_history.pdf', request()->only(['food_id','date'])) }}" class="btn btn-danger">
            <i class="fa fa-file-pdf me-1"></i> Exporter en PDF
        </a>
    </div>

    <!-- 📋 Tableau de l'historique du stock -->
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Plat</th>
                    <th>Type</th>
                    <th>Quantité</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr>
                        <td>{{ $item->food->title ?? 'N/A' }}</td>
                        <td>{{ ucfirst($item->type) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun historique trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
