<h2>Edit description</h2>
<form action="/Picture/doEdit" method="post">
    <input name="id" type="hidden" value="<?= $picture["Id"] ?>">
    <img id="picture" src="/Picture/single?id=<?= $picture["Id"] ?>"><br>
    <label for="description">Beschreibung:</label>
    <input id="description" name="description" value="<?= $picture["Description"] ?>">
    <input class="waves-effect waves-light btn" type="submit" value="Edit">
</form>