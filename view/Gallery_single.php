<h1><?= $gallery->Name ?></h1>
<a class="btn" href="/Gallery/upload?id=<?= $_GET['id'] ?>">Upload</a>
<div class="row">
    <?php
    foreach($pictures as $picture) {
        ?>
        <div class="col s3">
            <div class="card">
                <div class="card-image">
                    <img src="/Picture/single?id=<?= $picture->Id ?>&thumb=true">
                    <!--<span class="card-title"><?= $picture->Id ?></span>-->
                </div>
                <div class="card-action">
                    <a href="/Picture/single?id=<?= $picture->Id ?>" target="_blank">Open</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>