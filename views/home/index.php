<?php if(isset($_COOKIE['user'])) header("Location: /profile/"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">

        </div>
        <div class="text-center">
            <img src="/template/pictures/matcha_main_text.jpg"><br><br>
            <a href="/sign_in"><button type="button" class="btn btn-warning">Sign in</button></a>
            <a href="/sign_up"><button type="button" class="btn btn-warning">Sign up</button></a>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>