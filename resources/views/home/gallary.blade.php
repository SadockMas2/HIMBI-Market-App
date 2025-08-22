<style>
    /* Section Gallary - NOS MENUS */
    #gallary {
        position: relative;
        background: url('/images_sections/menu.jpg') center center/cover no-repeat;
        padding: 60px 20px;
        color: #f8f9fa;
        overflow: hidden;
        border-radius: 16px;
    }

    /* Overlay sombre */
    #gallary::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6);
        z-index: 0;
        border-radius: 16px;
    }

    /* Contenu au-dessus de l'overlay */
    #gallary > * {
        position: relative;
        z-index: 1;
    }

    /* Titre de la section */
    #gallary .section-title {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #ffc107;
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Grille responsive */
    .gallary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Chaque élément */
    .gallary-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallary-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.7);
        z-index: 10;
    }

    /* Image */
    .gallary-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
        border-radius: 12px;
        transition: transform 0.4s ease;
    }

    .gallary-item:hover .gallary-img {
        transform: scale(1.1);
    }

    /* Overlay + icon au survol */
    .gallary-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 193, 7, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
    }

    .gallary-item:hover .gallary-overlay {
        opacity: 1;
    }

    .gallary-icon {
        font-size: 2.5rem;
        color: #212529;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .gallary-img {
            height: 140px;
        }
        #gallary .section-title {
            font-size: 2rem;
            margin-bottom: 30px;
        }
    }
</style>

<div id="gallary" class="wow fadeIn">
    <h2 class="section-title">NOS MENUS</h2>
    <div class="gallary">
        <div class="gallary-item wow fadeIn">
            <img src="food_img/1.jpg" alt="Menu 1" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/3.webp" alt="Menu 2" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/4.webp" alt="Menu 3" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/5.webp" alt="Menu 4" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/6.webp" alt="Menu 5" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/19.jpg" alt="Menu 6" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/10.webp" alt="Menu 7" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/28.jpg" alt="Menu 8" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/23.jpg" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="food_img/32.jpeg" alt="Menu 10" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        {{-- <div class="gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-11.jpg" alt="Menu 11" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-12.jpg" alt="Menu 12" class="gallary-img" />
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div> --}}
    </div>
</div>
