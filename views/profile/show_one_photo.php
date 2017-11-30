<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
        </div>
        <div class="container  col-md-6 text-center col-md-offset-3">
            <div class="container">
                <?php
                $user = Profile::getUserInfo($_COOKIE['user']);
                $path = '/src/users_photos/' . $user['user_name'] . '/';
                echo '<div class="container col-md-4"><a href="/photos/">
                    <img class="img-responsive" src="' . $path . $src . '"></a><br>';
                ?>
                <a href="/set_avatar/<?= $photo_id ?>">
                    <button type="button" class="btn btn-info">Set as avatar</button>
                </a>
                <a href="/delete_photo/<?= $photo_id ?>">
                    <button type="button" class="btn btn-danger">Delete photo</button>
                </a></div>
        </div>
    </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/notifications_count.js"></script>
