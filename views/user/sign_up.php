<?php if(isset($_COOKIE['user'])) header("Location: /profile/"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
        </div>

        <div class="text-center col-md-4 col-md-offset-4">
            <?php if ($result): ?>
                <p class="bg-primary"><em>Please check your email!</em></p>
            <?php else: ?>
                <p class="bg-primary"><em><?php if (!empty($errors)) echo array_shift($errors); ?></em></p>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                            <?php if (isset($_POST['email'])) echo 'value="' . $_POST['email'] . '"'; ?> >
                    </div>
                    <div class="form-group">
                        <label for="user_name">User name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User name"
                            <?php if (isset($_POST['user_name'])) echo 'value="' . $_POST['user_name'] . '"'; ?> >
                    </div>
                    <div class="form-group">
                        <label for="first_name">First name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               placeholder="First name"
                            <?php if (isset($_POST['first_name'])) echo 'value="' . $_POST['first_name'] . '"'; ?> >
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name"
                            <?php if (isset($_POST['last_name'])) echo 'value="' . $_POST['last_name'] . '"'; ?> >
                    </div>
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
            <?php endif; ?>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>