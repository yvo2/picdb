<form method="post" action="/Gallery/doEdit">
    <h1>Galerie bearbeiten</h1>
    <input name="id" value="<?= $gallery->Id ?>" type="hidden">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" class="validate" value="<?= $gallery->Name ?>">
    <label for="description">Beschreibung (Optional):</label>
    <input id="description" name="description" type="text" class="validate" value="<?= $gallery->Description ?>">

    <input class="rt-btn btn btn-primary" type="submit" value="Bearbeiten">
</form>