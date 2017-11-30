<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>
<div id="large-photo"><img id="my_image" class="img-responsive" src="#"/></div>
<div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron text-right">
        <div id="online">
            <?php require_once ROOT . '/views/profile/layouts/show_online.php'; ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php require_once ROOT . '/views/profile/layouts/show_rating.php'; ?>
                <?php if ($_SESSION['current_user'] != $_COOKIE['user'] && Profile::getAllPhoto($_COOKIE['user'])) require_once ROOT . '/views/profile/layouts/matched.php'; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php require_once ROOT . '/views/profile/layouts/show_avatar.php'; ?>
            </div>
            <div class="col-md-4">
                <?php require_once ROOT . '/views/profile/layouts/show_info.php'; ?>
                <br><br>
                <?php require_once ROOT . '/views/profile/layouts/show_tags.php'; ?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <?php if ($_SESSION['current_user'] != $_COOKIE['user']) require_once ROOT . '/views/profile/layouts/like_report_block_btns.php'; ?>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            $photos = Profile::getAllPhoto($user['id']);
            $path = '/src/users_photos/' . $user['user_name'] . '/';
            $i = 1;
            foreach ($photos as $photo) {
                echo '<div class="container col-md-2 photo-preview" id="img' . $i . '"><img class="img-responsive" src="' . $path . $photo['src'] . '"></div>';
                $i++;
            }
            ?>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <?php require_once ROOT . '/views/profile/layouts/show_map.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/show_image.js?1500"></script>
<script src="/template/js/location.js"></script>
<script src="/template/js/like.js"></script>
<script src="/template/js/block.js"></script>
<script src="/template/js/notifications_count.js"></script>