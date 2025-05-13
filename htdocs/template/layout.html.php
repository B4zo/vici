<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <script src='https://www.hCaptcha.com/1/api.js' async defer></script>
        <link rel="stylesheet" type="text/css" href="template/css/stylesheet.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <title>Vici</title>
        <link rel="icon" href="../vici.si.ico" type="image/x-icon">
        <meta name="description" content="Deli svoje vice, z prijatelji in svetom.">
        <style>
            body {
            background-image: url('../img/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            }
            .dropdown-toggle::after {
                display: none !important;
            }
            .truncate-multiline {
                display: -webkit-box;
                -webkit-line-clamp: 10;
                line-clamp: 10;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .color {
                background-color:#FFDE00;
                color: white;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg sticky-top shadow-sm color">
            <div class="container-fluid">
                <a class="navbar-brand mx-2" href="/"><img src='../img/vici.si.png' alt="logo" type="image/png"></img></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="ms-auto d-flex">
                        <?php
                            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                                echo "
                                <div class=''><a class='btn btn-light btn-outline-dark me-1' href='/studio'><i class='fa fa-plus'></i></a></div>
                                ";
                            }

                            echo "
                            <div class='dropdown'>
                                <button class='btn btn-light btn-outline-dark dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <i class='fa fa-bars'></i>
                                </button>
                                <div class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownMenuButton'>
                            ";
                            if (isset($_SESSION['userUUID'])) {
                                echo "
                                    <a class='dropdown-item' href='/profile'>Profil</a>
                                    <a class='dropdown-item' href='/logout'>Odjava</a>
                                ";
                            } else {
                                echo "
                                    <a class='dropdown-item' href='/signup'>Registracija</a>
                                    <a class='dropdown-item' href='/login'>Prijava</a>
                                ";
                            }
                            echo "
                                </div>
                            </div>
                            ";
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <?php
            echo $content;
        ?>

    </body>
</html>