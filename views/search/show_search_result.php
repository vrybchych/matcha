<?php foreach ($users as $u): ?>

    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <a href="/profile/<?= $u['id'] ?>" style="text-decoration: none">
                    <?php
                    $src = "/template/pictures/no_photo.svg.png";

                    $path = '/src/users_photos/' . $u['user_name'] . '/';

                    if (isset($u['avatar'])) {
                        $src = $path . Profile::getPhotoSrc($u['avatar'], $u['id']);
                    } else if ($photos = Profile::getAllPhoto($u['id'])) {
                        $src = $path . Profile::getPhotoSrc($photos['0']['id'], $u['id']);
                    }

                    echo '<img class="img-responsive" src="' . $src . '" alt="avatar" width="60">';

                    //SHOW ONLINE STATUS
                    $online_time = LocationAndOnline::isOnline($u['id']);
                    if ($online_time) {
                        echo "<span style='color: coral'>online</span>";
                    }
                    ?>
                </a>
            </div>
            <div class="col-md-8">
                <strong><em><?= $u['first_name'] ?>
                        <?= $u['last_name'] ?></em></strong><br>
                <?php

                $age = Profile::getAge($u['birthday']);

                if ($age) {
                    echo "<em>$age</em><br>";
                }

                if (isset($u['gender'])) {
                    echo "<em>{$u['gender']}</em><br>";
                }

                if (isset($u['sexual_preferences'])) {
                    echo "<em>{$u['sexual_preferences']}</em><br>";
                }
                ?>
            </div>
        </div>
    </div>
    <br>
<?php endforeach; ?>