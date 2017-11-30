<?php

class MessageController
{

    public static function actionCheckupdate()
    {
        if (isset($_POST['check'])) {
            if ($result = Message::checkNewMessage($_COOKIE['user'], $_POST['id'])) {

                $user = Profile::getUserInfo($_POST['id']);
                $avatar = Message::getAvatarSrc($user['id']);
                $time = time();
                $time = date("Y-m-d H:i:s", $time);

                $message = '<li class="left clearfix"><span class="chat-img1 pull-left"><img src="'.$avatar.'" alt="User Avatar" class="img-circle">
                         </span><div class="chat-body1 clearfix"><p>'.$result['0']['message'].'</p><div class="chat_time pull-right">'.$time.'</div>';


                echo $message;
            }
            exit();
        }
    }

    public static function actionAddmessage()
    {
        if ( isset($_POST['message_text']) && $_POST['message_text'] != '') {
            $_POST['message_text'] = htmlspecialchars($_POST['message_text']);
            Message::addMessage($_COOKIE['user'], $_POST['id'], $_POST['message_text']);

            $user = Profile::getUserInfo($_COOKIE['user']);
            $avatar = Message::getAvatarSrc($user['id']);
            $time = time();
            $time = date("Y-m-d H:i:s", $time);

            $message = '<li class="left clearfix"><span class="chat-img1 pull-right"><img src="'.$avatar.'" alt="User Avatar" class="img-circle">
                         </span><div class="chat-body1 clearfix"><p>'.$_POST['message_text'].'</p><div class="chat_time pull-right">'.$time.'</div>';

            echo $message;
            exit();
        }
    }

    public static function actionIndex($reciver = NULL)
    {
        date_default_timezone_set('Europe/Kiev');
        LocationAndOnline::setOnlineStatus();
        $recivers = Message::getAllRecivers($_COOKIE['user']);
        if (!$reciver) {
            $reciver = $recivers['0']['user_id'];
        }
        $messages = Message::getMessages($_COOKIE['user'], $reciver);

        $userAvatar = Message::getAvatarSrc($_COOKIE['user']);
        $reciverAvatar = Message::getAvatarSrc($reciver);

        require_once(ROOT . '/views/message/index.php');

        return true;
    }
}