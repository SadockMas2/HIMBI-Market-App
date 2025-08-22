<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Admin </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="admin/css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="admin/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="admin/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="admin/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        
<style>
/* Fixer la navbar en haut */
.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1030; /* au-dessus de tout */
}

/* Fixer la sidebar sur la gauche */
#sidebar {
    position: fixed;
    top: 70px; /* hauteur de la navbar */
    left: 0;
    height: calc(100vh - 70px); /* hauteur totale moins la navbar */
    width: 250px;
    overflow-y: auto;
    z-index: 1020;
}

/* Ajuster le contenu principal pour qu’il ne soit pas caché */
.page-content {
    margin-left: 250px; /* largeur de la sidebar */
    padding-top: 80px; /* hauteur de la navbar */
    padding-right: 20px;
    padding-left: 20px;
}
</style>
  