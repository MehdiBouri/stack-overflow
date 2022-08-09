<?php

$userModel = new \App\Model\UserModel;
$user = $userModel->isLogged();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/logo" href="https://upload.wikimedia.org/wikipedia/commons/e/ef/Stack_Overflow_icon.svg">

    <title>Stackoverflow</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- CSS perso -->
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css">

    <!-- Script pour les logos-->
    <script src="https://kit.fontawesome.com/14fbcf0019.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="?page=index"><img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/f/f7/Stack_Overflow_logo.png" alt="stackoverflow image"></a>
    
        <?php if ($user) :?>
            <div>
                <span><?= ucfirst($user->getNickname()) ?></span>
                <a href="?page=logout"><i class="fas fa-power-off"></i></a>
            </div>
        <?php else :?>
        <a href="?page=login"><i class="fas fa-user"></i></a>
        <?php endif ?>


        <?php if ($user && $user->getStatus()) {
            ?><a href="?page=admin">Tableau de bord</a><?php
        }
        ?>
    </nav>

    <div id="content">