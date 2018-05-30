<div class="container formcontainer">
    <h1 class="jumbotron-heading">Hallo, <?= $displayname ?></h1>
    <p class="lead text-muted">Deine Daten bearbeiten</p>

    <div class="rt-success"><?= $changeSuccess ?></div>
    <div class="rt-success"><?= $passwordChangeSuccess ?></div>

    <form method="post" class="rt-register">
        <label class="text-muted" for="rt-password">Anzeigenamen: </label><input value="<?= $displayname ?>" placeholder="Anzeigenamen" class="form-control" id="rt-displayname" name="rt-displayname" type="text"><br>
        <div class="rt-validation" id="validation-displayname"><?= $displayNameValidationMessage ?></div>
        <label class="text-muted" for="rt-email">Email: </label><input value="<?= $email ?>" placeholder="Email-Adresse" class="form-control" id="rt-email" name="rt-email" type="email" onchange="emLength()"><br>
        <div class="rt-validation" id="validation-email"><?= $emailValidationMessage ?></div>
        <label class="text-muted" for="rt-password">Passwort: </label><input placeholder="Passwort" class="form-control" id="rt-password" name="rt-password" type="password" onchange="pwLength()"><br>
        <div class="rt-validation" id="validation-password"><?= $passwordValidationMessage ?></div>
        <label class="text-muted" for="rt-password">Passwort wiederholen: </label><input placeholder="Passwort" class="form-control" id="rt-password-repeat" name="rt-password-repeat" type="password" onchange="pwCompare()"><br>
        <div class="rt-validation" id="validation-password-repeat"><?= $passwordValidationRepeatMessage ?></div>
        <input class="rt-btn btn btn-primary" type="submit" value="Speichern">
    </form>

    <br>

    <form method="post" action="/User/doDelete" onsubmit="return show_alert()">
        <input class="rt-btn btn red" type="submit" value="Account löschen">
    </form>

    <script>
        function show_alert() {
            if(confirm("Möchtest du deinen Account wirklich permanent löschen? Alle Galerien und deren Bilder werden permanent mitgelöscht."))
                document.forms[0].submit();
            else
                return false;
        }
    </script>
</div>