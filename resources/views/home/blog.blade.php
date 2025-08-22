<style>
    /* Section avec image de fond */
    #blog {
        background-image: url('/images_sections/plat.jpg'); /* Remplace par ton image */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        padding: 80px 0;
        z-index: 1;
    }

    #blog::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 0;
    }

    #blog .section-title {
        position: relative;
        z-index: 1;
        font-size: 2.5rem;
        color: #ffc107;
        font-weight: bold;
    }

    .food-card {
        background-color: rgba(30, 30, 30, 0.95);
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.3);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .food-card:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 35px rgba(255, 193, 7, 0.6);
    }

    .food-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .food-card .card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        color: white;
        flex-grow: 1;
    }

    .food-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .food-card .badge {
        background-color: #ffc107;
        color: #000;
        font-size: 0.85rem;
        padding: 0.4em 0.8em;
    }

    .food-card input[type="number"] {
        width: 70px;
        margin-top: auto;
        font-size: 0.9rem;
        padding: 4px 6px;
        background: #333;
        color: #fff;
        border: 1px solid #555;
        border-radius: 6px;
    }

    .food-card .form-check-input {
        background-color: #ffc107;
        border: none;
    }

    .food-card .form-check-label {
        font-size: 0.85rem;
        color: #ccc;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .food-card img {
            height: 120px;
        }
    }

    /* Bouton panier */
    .btn-panier {
        margin-right: 00px;
        background-color: #28a745;
        border: none;
        padding: 12px 40px;
        font-size: 1.1rem;
        font-weight: bold;
        border-radius: 50px;
        color: white;
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-panier:hover {

        background-color: #218838;
        box-shadow: 0 8px 20px rgba(40,167,69,0.5);
    }

    .text-light-position {
        position: relative;
        z-index: 1;
    }
</style>

<!-- SECTION PLATS -->
<!-- SECTION PLATS -->
<div id="blog" class="container-fluid text-light text-center">
    <div class="text-light-position">

        <form action="{{ url('add_cart_multiple') }}" method="POST">
            @csrf

            <!-- Titre + bouton sur la même ligne -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="section-title m-0">NOS PLATS</h2>
                <button type="submit" class="btn btn-panier">✅ Ajouter au Panier</button>
            </div>

            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <div class="row">
                <!-- NOURRITURES -->
                <div class="col-md-6 mb-5">
                    <h3 class="text-warning mb-4">🍛 Nourritures</h3>
                    <div class="row">
                        @foreach($data as $item)
                            @if(!Str::contains(Str::lower($item->detail), 'boisson'))
                                <div class="col-sm-6 mb-4">
                                    <div class="food-card">
                                        <img src="food_img/{{ $item->image }}" alt="{{ $item->title }}">
                                        <div class="card-body text-start">
                                            <h6 class="card-title">{{ $item->title }}</h6>
                                            <p class="small">{{ $item->detail }}</p>
                                            <span class="badge mb-2">${{ $item->price }}</span>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="food_ids[]" value="{{ $item->id }}" id="food-{{ $item->id }}">
                                                <label class="form-check-label" for="food-{{ $item->id }}">Sélectionner</label>
                                            </div>
                                            <input type="number" name="qty[{{ $item->id }}]" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- BOISSONS -->
                <div class="col-md-6 mb-5">
                    <h3 class="text-info mb-4">🥤 Boissons</h3>
                    <div class="row">
                        @foreach($data as $item)
                            @if(Str::contains(Str::lower($item->detail), 'boisson'))
                                <div class="col-sm-6 mb-4">
                                    <div class="food-card">
                                        <img src="food_img/{{ $item->image }}" alt="{{ $item->title }}">
                                        <div class="card-body text-start">
                                            <h6 class="card-title">{{ $item->title }}</h6>
                                            <p class="small">{{ $item->detail }}</p>
                                            <span class="badge mb-2">${{ $item->price }}</span>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="food_ids[]" value="{{ $item->id }}" id="drink-{{ $item->id }}">
                                                <label class="form-check-label" for="drink-{{ $item->id }}">Sélectionner</label>
                                            </div>
                                            <input type="number" name="qty[{{ $item->id }}]" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
