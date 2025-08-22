<!-- Bootstrap CSS-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    
    body {
        font-family: 'Inter', sans-serif;
        background: #1b1f2f; /* un gris bleu très sobre */
        color: #f8f9fa;      /* texte clair */
        margin: 0;
        padding: 0;
    }


    /* HEADER FIXE */
    .serveur-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: #000000;
        color: #fff;
        display: flex;
        align-items: center;
        padding:  20px;
        z-index: 1050;
        box-shadow: 0 2px 6px rgba(0,0,0,0.4);
    }

    .serveur-header .navbar-brand {
        font-weight: 700;
        font-size: 1.2rem;
        color: #fff;
    }

    /* SIDEBAR FIXE */
    .serveur-sidebar {
        position: fixed;
        top: 60px; /* sous le header */
        left: 0;
        width: 220px;
        height: 100%;
        background: #06060b;
        padding-top: 20px;
        overflow-y: auto;
        box-shadow: 2px 0 5px rgba(0,0,0,0.4);
    }

    .serveur-sidebar ul {
        list-style: none;
        padding: 05;
        margin: 0;
    }

    .serveur-sidebar ul li {
        margin: 10px 0;
    }

    .serveur-sidebar ul li a {
        display: block;
        padding: 10px 20px;
        color: #cfd4da;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .serveur-sidebar ul li a:hover,
    .serveur-sidebar ul li a.active {
        background: #a2a4aa;
        color: #fff;
        border-left: 4px solid #c1cad8;
    }

    /* CONTENT */
    .content {
        margin-left: 220px; /* largeur sidebar */
        margin-top: 60px;   /* hauteur header */
        padding: 20px;
        background-color: #181c07;
        color: #333;
        min-height: 100vh;
    }

    /* CARDS ET TABLES */
    .card {
        background: #fff;
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-header {
        background: #273469;
        color: #fff;
        font-weight: 600;
    }

    /* SCROLLBAR CUSTOM */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-thumb {
        background: #444b6e;
        border-radius: 10px;
    }
</style>
