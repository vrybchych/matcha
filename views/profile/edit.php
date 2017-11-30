<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-center">
        </div>
        <div class="container  col-md-6 text-center col-md-offset-3">
            <p class="bg-primary"><em><?php if (!empty($errors)) echo array_shift($errors); ?></em></p>
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <label for="first_name">First name</label>
                    <input type="text" class="form-control text-center" name="first_name"
                           value="<?php echo @$user['first_name'] ?>"><br>
                    <label for="last_name">Last name</label>
                    <input type="text" class="form-control text-center" name="last_name"
                           value="<?php echo @$user['last_name'] ?>"><br>
                    <label for="email">Email</label>
                    <input type="email" class="form-control text-center" id="email" name="email" placeholder="Email"
                           value="<?php echo @$user['email'] ?>">
                    <br>
                    <div class="container col-md-4">
                        <label for="date">Birthday</label><br>
                        <input id="date" type="date" name="birthday" value="<?php echo @$user['birthday'] ?>">
                    </div>
                    <div class="container col-md-4">
                    <h5>Gender</h5>
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" id="optionsRadios1" value="male"
                                <?php if (!isset($user['gender']) || $user['gender'] == 'male') echo 'checked'; ?> >
                            male
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" id="optionsRadios2" value="female"
                                <?php if (isset($user['gender']) && $user['gender'] == 'female') echo 'checked'; ?> >
                            female
                        </label>
                    </div>
                    </div>
                    <div class="container col-md-4">
                    <h5>Sexual Preferences</h5>
                    <div class="radio">
                        <label>
                            <input type="radio" name="sex_pref" id="optionsRadios1" value="heterosexual"
                                <?php if (!isset($user['sexual_preferences']) || $user['sexual_preferences'] == 'heterosexual') echo 'checked'; ?> >
                            heterosexual
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="sex_pref" id="optionsRadios2" value="homosexual"
                                <?php if (isset($user['sexual_preferences']) && $user['sexual_preferences'] == 'homosexual') echo 'checked'; ?> >
                            homosexual
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="sex_pref" id="optionsRadios3" value="bisexual"
                                <?php if (isset($user['sexual_preferences']) && $user['sexual_preferences'] == 'bisexual') echo 'checked'; ?> >
                            bisexual
                        </label>
                    </div>
                    <br>
                    </div>
                    <br>
                    <h5>About yourself<br>
                        <small>200 characters max</small>
                    </h5>
                    <textarea class="form-control" rows="5" name="about"><?php echo @$user['about'] ?></textarea><br>
                    <button type="submit" class="btn btn-success btn-block" name="save_btn">Save</button>
                </div>
            </form>
            <a href="/forgot_password" class="btn btn-danger btn-xs btn-block">Change password</a><br><br>
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">#</span>
                        <input type="text" class="form-control" aria-describedby="basic-addon1" name="tag">
                    </div>
                    <button type="submit" class="btn btn-warning btn-xs btn-block" name="add_tag">Add tag</button>
                </div>
            </form>
            <h5>Click on tag to remove</h5>
            <?php
            foreach ($tags as $tag) {
                if ($tag['tag_name']) {
                    echo '<a href="/delete_tag/' . $tag['id'] . '" style="color: red">#' . $tag['tag_name'] . '</a>&#32';
                }
            }
            ?>
        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/notifications_count.js"></script>
