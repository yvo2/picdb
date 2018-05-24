<form action="/Gallery/doDelete" method="post">
    <input type="hidden" name="id" value="<?= $gallery->Id ?>">
    <h1><?= $gallery->Name ?></h1>
    <p><?= $gallery->Description ?></p>
    <p>Diese Galerie permanent löschen? (Inklusive Bilder!)</p>
    <input type="submit" class="btn" value="Löschen">
</form>