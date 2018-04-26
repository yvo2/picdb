<h1>Upload a picture</h1>
<h5>into <strong>"<?= $gallery->Name ?>"</strong></h5>

<form action="/Gallery/doUpload" method="post" enctype="multipart/form-data">
    <div class="file-field input-field">
        <div class="btn">
            <span>Select picture</span>
            <input type="file" name="picture" id="pictureUpload">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
        <input class="btn" type="submit" value="Upload">
        <input name="galleryId" type="hidden" value="<?= $gallery->Id ?>">
    </div>
</form>