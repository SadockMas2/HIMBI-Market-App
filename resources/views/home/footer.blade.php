<!-- STYLES CSS -->
<style>
    #contact {
        background-color: #111;
        color: #f8f9fa;
        padding: 60px 0;
    }

    #contact h3 {
        font-size: 2rem;
        font-weight: bold;
        color: #ffc107;
        margin-bottom: 20px;
    }

    #contact p {
        font-size: 1rem;
        line-height: 1.6;
    }

    #contact .text-muted p {
        margin-bottom: 10px;
        font-size: 0.95rem;
        color: #ccc;
    }

    #contact .ti-location-pin,
    #contact .ti-support,
    #contact .ti-email {
        color: #17a2b8;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        min-height: 400px;
        border: 0;
        border-radius: 12px 0 0 12px;
    }

    @media (max-width: 767px) {
        .map-container iframe {
            border-radius: 12px 12px 0 0;
        }

        #contact .col-md-6 {
            padding: 20px;
        }
    }
</style>

<!-- SECTION CONTACT -->
<div id="contact" class="container-fluid border-top wow fadeIn">
    <div class="row">
        <!-- Carte Google Maps -->
        <div class="col-md-6 px-0 map-container">

                <iframe
                    src="https://www.google.com/maps?q=-1.657325143827208,29.1946202444160935&z=16&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0; border-radius: 12px 0 0 12px;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
        </div>

        <!-- Infos de Contact -->
        <div class="col-md-6 px-5 d-flex align-items-center">
            <div>
                <h3>NOUS TROUVER</h3>
                <p>
                    Vous pouvez nous rendre visite à notre restaurant pour déguster de bons plats faits maison !<br>
                    Pour toute information ou réservation, n'hésitez pas à nous contacter.
                </p>
                <div class="text-muted mt-4">
                    <p><i class="ti-location-pin"></i> 85VV+3R9 HIMBI KATINDO, Goma</p>
                    <p><i class="ti-support"></i> +243 977 654 321</p>
                    <p><i class="ti-email"></i> contact@himbimarket.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
