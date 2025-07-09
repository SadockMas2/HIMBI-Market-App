<div id="blog" class="container-fluid bg-dark text-light py-5 text-center">
    <h2 class="section-title mb-5">NOS PLATS</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form action="{{ url('add_cart_multiple') }}" method="POST">
        @csrf

        <div class="row justify-content-center">

            {{-- Colonne Nourritures --}}
            <div class="col-md-6 mb-5">
                <h3 class="text-warning mb-4">🍛 Nourritures</h3>
                <div class="row">
                    @foreach($data as $item)
                        @if(!Str::contains(Str::lower($item->detail), 'boisson'))
                        <div class="col-md-6 mb-4">
                            <div class="card bg-dark border-light h-100">
                                <img src="food_img/{{ $item->image }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                                <div class="card-body text-start text-white">
                                    <h6 class="card-title">{{ $item->title }}</h6>
                                    <p class="mb-2 small">{{ $item->detail }}</p>
                                    <span class="badge bg-info text-dark mb-2">${{ $item->price }}</span>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="food_ids[]" value="{{ $item->id }}" id="food-{{ $item->id }}">
                                        <label class="form-check-label small" for="food-{{ $item->id }}">Sélectionner</label>
                                    </div>
                                    <input type="number" name="qty[{{ $item->id }}]" value="1" min="1" class="form-control form-control-sm" style="width: 80px;">
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Colonne Boissons --}}
            <div class="col-md-6 mb-5">
                <h3 class="text-info mb-4">🥤 Boissons</h3>
                <div class="row">
                    @foreach($data as $item)
                        @if(Str::contains(Str::lower($item->detail), 'boisson'))
                        <div class="col-md-6 mb-4">
                            <div class="card bg-dark border-light h-100">
                                <img src="food_img/{{ $item->image }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                                <div class="card-body text-start text-white">
                                    <h6 class="card-title">{{ $item->title }}</h6>
                                    <p class="mb-2 small">{{ $item->detail }}</p>
                                    <span class="badge bg-info text-dark mb-2">${{ $item->price }}</span>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="food_ids[]" value="{{ $item->id }}" id="drink-{{ $item->id }}">
                                        <label class="form-check-label small" for="drink-{{ $item->id }}">Sélectionner</label>
                                    </div>
                                    <input type="number" name="qty[{{ $item->id }}]" value="1" min="1" class="form-control form-control-sm" style="width: 80px;">
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Bouton ajouter au panier fixé --}}
               </div> <!-- fin des colonnes -->
        
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-lg btn-success px-5">✅ Ajouter au Panier</button>
        </div>

        </div>
    </form>
</div>
