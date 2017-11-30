<?php

class NotificationController
{

    public static function actionCount()
    {
        if (isset ($_POST['check'])) {
            $notifications = Notification::getUnreadNotifications($_COOKIE['user']);
            $count = count($notifications);
            echo $count;
            exit();
        }
    }

    public static function actionIndex()
    {
        date_default_timezone_set('Europe/Kiev');
        LocationAndOnline::setOnlineStatus();
        $notifications = Notification::getNotifications($_COOKIE['user']);
        Notification::updateStatus($_COOKIE['user']);

        require_once(ROOT . '/views/notification/index.php');

        return true;
    }

}