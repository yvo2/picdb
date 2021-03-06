<h1>Upload a picture</h1>
<h5>into <strong>"<?= $gallery->Name ?>"</strong></h5>

<form action="/Gallery/doUpload" method="post" enctype="multipart/form-data">
    <label for="description">Beschreibung (Optional):</label>
    <input id="description" name="description" class="validate" type="text">
    <div class="file-field input-field">
        <div class="btn">
            <span>Select picture</span>
            <input type="file" name="picture" id="pictureUpload">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>

        <input class="btn" type="submit" value="Upload">
        <a href="/Gallery/single?id=<?= $gallery->Id ?>" class="btn" style="margin-left: 20px;">Zurück</a>

        <input name="galleryId" type="hidden" value="<?= $gallery->Id ?>">
    </div>
</form>