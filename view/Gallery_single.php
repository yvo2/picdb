<script>

    function showModal(image, description, id) {
        $("#picture").attr("src", image);
        $("#description").text(description);
        $("#edit").attr("href", "/Picture/edit?id=" + id)
        $('.modal').modal('open');
    }

</script>
<h1><?= $gallery->Name ?></h1>
<p><?= $gallery->Description ?></p>
<a class="btn" href="/Gallery/upload?id=<?= $_GET['id'] ?>">Upload</a>
<a class="waves-effect waves-light btn" href="/Gallery/edit?id=<?= $_GET['id'] ?>">Edit</a>
<a class="waves-effect waves-light btn" href="/Gallery/delete?id=<?= $_GET['id'] ?>">Delete</a>
<div class="row">
    <?php
    foreach($pictures as $picture) {
        ?>
        <div class="col s3">
            <div class="card">
                <div class="card-image">
                    <img src="/Picture/single?id=<?= $picture["Id"] ?>&thumb=true">
                </div>
                <div class="card-action">
                    <button class="waves-effect waves-light btn" onclick="showModal('<?php echo "/Picture/single?id=".$picture["Id"]; ?>', '<?php echo $picture["Description"]; ?>', '<?= $picture["Id"] ?>')">Open</button>
                    <a href="/Picture/delete?id=<?= $picture["Id"] ?>" class="waves-effect waves-light btn">Delete</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div id="modal" class="modal">
        <img src="" alt="content" id="picture" />
        <p id="description"></p>
        <a id="edit" class="waves-effect waves-light btn" href="" style="float: right;">Edit</a>
    </div>

    <script>
        $(document).ready(function(){
            $('.modal').modal();
        });
    </script>

</div>