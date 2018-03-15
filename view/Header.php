<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/frontend/css/materialize.min.css"  media="screen"/>
    <link type="text/css" rel="stylesheet" href="/frontend/css/style.css"  media="screen"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Blog</title>
</head>
<body>
<nav>
    <div class="nav-wrapper">
        <a href="/" class="brand-logo center">PicDB</a>
        <ul class="left">
            <li><a href="/">Home</a></li>
            <li><a href="/galeries">Galerien ansehen</a></li>
            <li><a href="/user">Profil</a></li>
            <?php /* if ($sessionManager->isSignedIn()) { ?>
                <li><a href="/blog?blogId=<?= $sessionManager->getUserId() ?>">Member-Bereich</a></li>
            <?php } */ ?>
        </ul>
        <?php if (false) { ?>
            <ul class="right">
                <li><a href="/member<?php if (isset($selectedBlog)) { echo "?blogId=".$selectedBlog; } ?>">Hallo <?= $sessionManager->getUser()->name ?></a></li>
                <li><a href="/user/logout<?php if (isset($selectedBlog)) { echo "?blogId=".$selectedBlog; } ?>">Abmelden</a></li>
            </ul
        <?php } else { ?>
            <ul class="right">
                <li><a href="/user/login">Anmelden</a></li>
                <li><a href="/user/register">Registrieren</a></li>
            </ul>
        <?php } ?>

    </div>
</nav>

<div class="container">
    <div class="section">