<a href="/Gallery/create">+ Galerie erstellen</a>

<div class="row">
    <?php
    foreach($galleries as $gallery) {
        ?>
        <div class="col s3">
            <div class="card">
                <div class="card-image">
                    <img src="http://materializecss.com/images/sample-1.jpg">
                    <span class="card-title"><?= $gallery['Name'] ?></span>
                </div>
                <div class="card-action">
                    <a href="/Gallery/single?id=<?= $gallery['Id'] ?>">Open</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>