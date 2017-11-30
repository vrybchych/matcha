<?php
    $src = "/template/pictures/no_photo.svg.png";

    $path = '/src/users_photos/' . $user['user_name'] . '/';

    if (isset($user['avatar'])) {
        $src = $path . Profile::getPhotoSrc($user['avatar'], $user['id']);
    } else if ($photos = Profile::getAllPhoto($user['id'])){
        Profile::setAvatar($photos['0']['id'], $user['id']);
        $src = $path . Profile::getPhotoSrc($photos['0']['id'], $user['id']);
    }

    echo '<img class="img-responsive" src="'.$src.'" alt="avatar">';
?>