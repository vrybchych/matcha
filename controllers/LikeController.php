<?php

class LikeController
{

    public function actionLike()
    {
        if (isset($_POST['like'])) {
            Like::addLike($_COOKIE['user'], $_SESSION['current_user']);
        }
    }

    public function actionUnlike()
    {
        if (isset($_POST['unlike'])) {
            Like::unlike($_COOKIE['user'], $_SESSION['current_user']);
        }
    }

}