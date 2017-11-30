<?php

class BlockController
{

    public function actionBlock()
    {
        if (isset($_POST['block'])) {
            BlockUser::block($_COOKIE['user'], $_SESSION['current_user']);
        }
    }

    public function actionUnblock()
    {
        if (isset($_POST['unblock'])) {
            BlockUser::unblock($_COOKIE['user'], $_SESSION['current_user']);
        }
    }

}