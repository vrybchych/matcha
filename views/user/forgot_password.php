<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
        </div>
        <div class="text-center col-md-4 col-md-offset-4">
            <?php if ($result): ?>
                <p class="bg-primary"><em><?php if (!empty($result)) echo array_shift($result); ?></em></p>
            <?php endif; ?>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-warning" name="submit">Reset password</button>
                </form>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>