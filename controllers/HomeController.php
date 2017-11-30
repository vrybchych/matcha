<?php

class HomeController
{

    public function actionIndex()
    {
        if (isset($_COOKIE['user'])) {
            require_once ROOT . '/views/home/index.php';
        } else {
            require_once ROOT . '/views/home/index.php';
        }

        return true;
    }

    public function actionError()
    {
        require_once ROOT . '/views/error.php';

        return true;
    }

}