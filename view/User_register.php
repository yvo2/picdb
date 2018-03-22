<div class="container formcontainer">
    <h1 class="jumbotron-heading">REGISTRIEREN</h1>
    <p class="lead text-muted">Registriere dich um alle Features zu nutzen! Bereits einen Account? <a href="/User/login">Anmelden.</a></p>
    <form method="post" class="rt-register">
        <label class="text-muted" for="rt-email">Email: </label><input value="<?= $email ?>" placeholder="Email-Adresse" class="form-control" id="rt-email" name="rt-email" type="email" onchange="emLength()"><br>
        <div class="rt-validation" id="validation-email"><?= $emailValidationMessage ?></div>
        <label class="text-muted" for="rt-password">Passwort: </label><input placeholder="Passwort" class="form-control" id="rt-password" name="rt-password" type="password" onchange="pwLength()"><br>
        <div class="rt-validation" id="validation-password"><?= $passwordValidationMessage ?></div>
        <label class="text-muted" for="rt-password">Passwort wiederholen: </label><input placeholder="Passwort" class="form-control" id="rt-password-repeat" name="rt-password-repeat" type="password" onchange="pwCompare()"><br>
        <div class="rt-validation" id="validation-password-repeat"><?= $passwordValidationRepeatMessage ?></div>
        <input class="rt-btn btn btn-primary" type="submit" value="Los gehts!">
    </form>
</div>