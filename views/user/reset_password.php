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
                        <label for="password1">Password</label>
                        <input type="password" class="form-control" id="password1" name="password1"
                               placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password2">Confirm password</label>
                        <input type="password" class="form-control" id="password2" name="password2"
                               placeholder="Confirm password">
                    </div>
                    <button type="submit" class="btn btn-warning" name="submit">Submit</button>
                </form>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>