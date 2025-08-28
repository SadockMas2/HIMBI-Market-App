@extends('layouts.app')

@section('content')

<style>
/* === Section principale === */
#gallary {
    position: relative;
    background: url('/images_sections/11.jpg') center/cover no-repeat fixed;
    padding: 40px 20px;
    color: #fff;
}
#gallary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.65);
    z-index: 0;
}
#gallary > * {
    position: relative;
    z-index: 1;
}

/* === Section header === */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    flex-wrap: wrap;
    padding: 0px;
}
.section-title {
    font-size: 2rem;
    font-weight: bold;
    color: #c15e75;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
}

/* === Bouton commander === */
.btn-panier-top {
    background: #28a745;
    color: #fff;
    font-weight: bold;
    padding: 10px 25px;
    border-radius: 50px;
    border: none;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    white-space: nowrap;
    margin-top: 10px;
}
.btn-panier-top:hover {
    background: #218838;
    transform: translateY(-2px);
}

/* === Message erreur sélection === */
.error-msg {
    color: #ff6b6b;
    font-weight: bold;
    margin-top: 10px;
    text-align: center;
    display: none;
}

/* === Carrousels === */
.scroll-row {
    display: flex;
    overflow-x: auto;
    gap: 15px;
    padding: 15px 0;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
}
.scroll-row::-webkit-scrollbar {
    height: 6px;
}
.scroll-row::-webkit-scrollbar-thumb {
    background: #ffc107;
    border-radius: 6px;
}

/* === Cartes nourriture/boisson === */
.food-card {
    flex: 0 0 auto;
    width: 180px;
    background: rgba(30, 30, 30, 0.95);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.6);
    transition: transform 0.4s ease;
    scroll-snap-align: center;
}
.food-card img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    transition: height 0.4s ease;
}
.food-card.active {
    transform: scale(1.05);
    z-index: 2;
}
.card-body {
    padding: 10px;
    text-align: center;
}
.card-body h6 {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 4px;
    color: #ffc107;
}
.card-body p {
    font-size: 0.8rem;
    opacity: 0.8;
}
.badge {
    background: #ffc107;
    color: #000;
    padding: 3px 6px;
    font-size: 0.8rem;
    border-radius: 5px;
    margin-bottom: 6px;
    display: inline-block;
}
.card-body input[type="number"] {
    width: 50px;
    font-size: 0.85rem;
    border-radius: 6px;
    border: 1px solid #555;
    background: #222;
    color: #fff;
    margin-top: 4px;
    text-align: center;
}

/* === Responsive mobile === */
@media (max-width: 768px) {
    .food-card { width: 140px; }
    .food-card img { height: 100px; }
    .section-title { font-size: 1.5rem; text-align: center; }
    .section-header { flex-direction: column; gap: 8px; }
    .btn-panier-top { width: 100%; font-size: 0.95rem; padding: 8px 20px; }
}
</style>

<div id="gallary" class="wow fadeIn">
    <form id="form-commande" action="{{ url('add_cart_multiple') }}" method="POST">
        @csrf

        <!-- Message erreur -->
        <div id="error-msg" class="error-msg">Veuillez sélectionner au moins un plat avant de commander !</div>

        <!-- Section plats -->
        <div class="section-header">
            <h2 class="section-title">🍛 Nos Plats</h2>
            <button type="submit" class="btn-panier-top">✅ Commander</button>
        </div>
        <div class="scroll-row" id="carousel-plats">
            @foreach($data as $item)
                @if(!Str::contains(Str::lower($item->detail), 'boisson'))
                <div class="food-card">
                    <img src="food_img/{{ $item->image }}" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h6>{{ $item->title }}</h6>
                        <p class="small">{{ $item->detail }}</p>
                        <span class="badge">${{ $item->price }}</span><br>
                        <label>
                            <input type="checkbox" name="food_ids[]" value="{{ $item->id }}"> Sélectionner
                        </label>
                        <input type="number" name="qty[{{ $item->id }}]" value="1" min="1">
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Section boissons -->
        <div class="section-header" style="margin-top:10px;">
            <h2 class="section-title">🥤 Nos Boissons</h2>
        </div>
        <div class="scroll-row" id="carousel-boissons">
            @foreach($data as $item)
                @if(Str::contains(Str::lower($item->detail), 'boisson'))
                <div class="food-card">
                    <img src="food_img/{{ $item->image }}" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h6>{{ $item->title }}</h6>
                        <p class="small">{{ $item->detail }}</p>
                        <span class="badge">${{ $item->price }}</span><br>
                        <label>
                            <input type="checkbox" name="food_ids[]" value="{{ $item->id }}"> Sélectionner
                        </label>
                        <input type="number" name="qty[{{ $item->id }}]" value="1" min="1">
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Bouton Commander en bas -->
        <div class="text-center" style="margin-top:15px;">
            <button type="submit" class="btn-panier-top">✅ Commander</button>
        </div>
    </form>
</div>

<script>
    // Validation sélection
    const form = document.getElementById('form-commande');
    const errorMsg = document.getElementById('error-msg');

    form.addEventListener('submit', function(e){
        const checkboxes = form.querySelectorAll('input[name="food_ids[]"]');
        let checked = false;
        checkboxes.forEach(cb => { if(cb.checked) checked = true; });

        if(!checked){
            e.preventDefault();
            errorMsg.style.display = 'block';
            errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Carrousels
    function initCarousel(carouselId) {
        const container = document.getElementById(carouselId);
        let autoScrollInterval;
        let pauseTimeout;

        function updateActiveCard() {
            const cards = container.querySelectorAll('.food-card');
            const containerCenter = container.scrollLeft + container.offsetWidth / 2;

            cards.forEach(card => {
                const cardCenter = card.offsetLeft + card.offsetWidth / 2;
                card.classList.toggle('active', Math.abs(containerCenter - cardCenter) < card.offsetWidth / 2);
            });
        }

        function startAutoScroll() {
            autoScrollInterval = setInterval(() => {
                const cardWidth = container.querySelector('.food-card')?.offsetWidth + 15 || 180;
                let nextScroll = container.scrollLeft + cardWidth;
                if (nextScroll >= container.scrollWidth - container.clientWidth) nextScroll = 0;
                container.scrollTo({ left: nextScroll, behavior: 'smooth' });
            }, 3000);
        }

        function stopAutoScroll() { clearInterval(autoScrollInterval); }

        container.addEventListener('scroll', () => {
            stopAutoScroll();
            clearTimeout(pauseTimeout);
            pauseTimeout = setTimeout(() => startAutoScroll(), 10000);
            updateActiveCard();
        });

        updateActiveCard();
        startAutoScroll();
    }

    initCarousel("carousel-plats");
    initCarousel("carousel-boissons");
</script>
