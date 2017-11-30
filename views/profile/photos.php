<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
        </div>
            <div class="container">
                <div class="row">
                    <div class="container col-md-2">
                        <p class="bg-primary"><em><?php if (!empty($errors)) echo array_shift($errors); ?></em></p>
                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="">
                            <div class="form-group">
                                <label for="exampleInputFile">Add photo</label>
                                <input type="file" id="upload_photo" name="picture" accept="image/*">
                                <p class="help-block">You can upload up to 5 photo</p>
                                <button type="submit" class="btn btn-success" name="add_photo">Add</button>
                            </div>
                        </form>
                    </div>
                    <?php
                    $user = Profile::getUserInfo($_COOKIE['user']);
                    $path = '/src/users_photos/' . $user['user_name'] . '/';
                    foreach ($photos as $photo) {
                        echo '<div class="container col-md-2"><a href="/photo/' . $photo['id'] . '">
                    <img class="img-responsive" src="' .$path.$photo['src'] . '"></a></div>';
                    }
                    ?>
                </div>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/notifications_count.js"></script>
