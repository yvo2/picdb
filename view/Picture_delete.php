<h2>Are you sure?</h2>
<form action="/Picture/doDelete" method="post">
    <input name="id" type="hidden" value="<?= $picture["Id"] ?>">
    <img id="picture" src="/Picture/single?id=<?= $picture["Id"] ?>"><br>
    <input class="waves-effect waves-light btn" type="submit" value="Delete">
</form>