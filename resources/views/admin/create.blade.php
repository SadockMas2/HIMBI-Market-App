@extends('layouts.admin_layout')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-white">Ajouter un Ingrédient</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('ingredients.store') }}" method="POST" class="p-4 bg-gray-800 rounded-lg shadow-lg">
        @csrf
        <div class="form-group mb-3">
            <label class="text-white">Nom de l'ingrédient</label>
            <input type="text" name="name" class="form-control" placeholder="Ex: Tomates" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
    </form>
</div>
@endsection
