<?php
require_once './lib/SessionManager.php';

$sessionManager = new SessionManager();
?>
<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/frontend/css/materialize.min.css"  media="screen" />
    <link type="text/css" rel="stylesheet" href="/frontend/css/style.css"  media="screen" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>PicDB</title>
</head>
<body>
<!--Import jQuery before materialize.js-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<nav>
    <div class="nav-wrapper">
        <a href="/" class="brand-logo center">PicDB</a>
        <ul class="left">
            <li><a href="/">Home</a></li>
            <li><a href="/Gallery">Galerien</a></li>
            <li><a href="/User">Profil</a></li>
            <?php /* if ($sessionManager->isSignedIn()) { ?>
                <li><a href="/blog?blogId=<?= $sessionManager->getUserId() ?>">Member-Bereich</a></li>
            <?php } */ ?>
        </ul>
        <?php
        if (!isset($viewCompatMode) || !$viewCompatMode) {
            if ($sessionManager->isSignedIn()) { ?>
                <ul class="right">
                    <li><a href="/User">Hallo <?= $sessionManager->getUser()->Displayname ?></a></li>
                    <li><a href="/User/logout">Abmelden</a></li>
                </ul
            <?php } else { ?>
                <ul class="right">
                    <li><a href="/User/login">Anmelden</a></li>
                    <li><a href="/User/register">Registrieren</a></li>
                </ul>
            <?php }
        }
        ?>

    </div>
</nav>

<div class="container">
    <div class="section">