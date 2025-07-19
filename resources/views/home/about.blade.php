<style>
    #about {
        position: relative;
        background-image: url('/images_sections/about.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 600px;
        padding: 80px 20px;
        border-radius: 16px;
        color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: left;
    }

    /* Overlay sombre */
    #about::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 16px;
        z-index: 0;
    }

    /* Contenu au-dessus de l'overlay */
    #about > .content {
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    #about h2 {
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #ffc107; /* jaune doux */
    }

    #about p, #about li {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #f0f0f0;
    }

    #about ul {
        margin-bottom: 1.5rem;
        padding-left: 20px;
    }

    #about em {
        color: #ddd;
        font-style: italic;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #about {
            padding: 40px 15px;
            min-height: auto;
        }
        #about > .content {
            max-width: 100%;
        }
    }
</style>

<div id="about" class="wow fadeIn" data-wow-duration="1.5s">
    <div class="content">
        <h2>À propos de Himbi Market</h2>
        <p>
            Bienvenue sur <strong>Himbi Market</strong>, votre compagnon digital pour une expérience de restauration plus simple, plus rapide et plus agréable.
        </p>
        <ul>
            <li>Consultez le menu complet à tout moment</li>
            <li>Réservez facilement une table en ligne</li>
            <li>Commandez vos plats préférés sans attendre</li>
            <li>Suivez l’état de votre commande en temps réel</li>
            <li>Recevez votre facture ou reçu depuis votre compte</li>
        </ul>
        <p>
            Plus besoin de faire la queue ou de chercher un serveur : tout se passe depuis votre téléphone ou votre ordinateur, en quelques clics.
        </p>
        <p>
            <strong>Notre objectif</strong> : vous offrir une expérience fluide, moderne et confortable, que vous soyez sur place ou en commande à emporter.
        </p>
        <p class="mt-4">
            <em>🍽️ Himbi Market, c’est votre restaurant… dans votre poche.</em>
        </p>
    </div>
</div>
