<?php if(isset($_COOKIE['user'])) header("Location: /profile/"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
        </div>
        <div class="text-center col-md-4 col-md-offset-4">
            <p class="bg-primary"><em><?php if (!empty($errors)) echo array_shift($errors); ?></em></p>
            <form method="post" action="">
                <div class="form-group">
                    <label for="user_name">User name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User name"
                        <?php if (isset($_POST['user_name'])) echo 'value="' . $_POST['user_name'] . '"'; ?> >
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-warning" name="submit">Submit</button>
            </form>
            <br><a href="/forgot_password">Forgot password?</a>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>