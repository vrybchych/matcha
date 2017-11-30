<?php

class Message
{
    public static function checkNewMessage($id_to, $id_from)
    {
        $pdo = Db::getConnection();
        $time = time();
        $time = $time - 5;

        $sql = "SELECT * FROM messages WHERE id_to = :id_to AND id_from = :id_from AND send_time > :send_time";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_to', $id_to, PDO::PARAM_INT);
        $stmt->bindParam(':id_from', $id_from, PDO::PARAM_INT);
        $stmt->bindParam(':send_time', $time, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getAvatarSrc($user_id)
    {
        $user = Profile::getUserInfo($user_id);
        $src = "/template/pictures/no_photo.svg.png";
        $path = '/src/users_photos/' . $user['user_name'] . '/';

        if (isset($user['avatar'])) {
            $src = $path . Profile::getPhotoSrc($user['avatar'], $user['id']);
        } else if ($photos = Profile::getAllPhoto($user['id'])){
            Profile::setAvatar($photos['0']['id'], $user['id']);
            $src = $path . Profile::getPhotoSrc($photos['0']['id'], $user['id']);
        }

        return $src;
    }

    public static function getAllRecivers($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT user_id FROM likes WHERE user_id IN (SELECT target_id FROM likes WHERE user_id = :user_id) AND target_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getMessages ($user1, $user2)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM messages WHERE id_from IN (:user1, :user2) AND id_to IN (:user1, :user2) ORDER BY send_time DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user1', $user1, PDO::PARAM_INT);
        $stmt->bindParam(':user2', $user2, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function addMessage($from, $to, $message)
    {
        Notification::addNotification($from, $to, 'message');

        $pdo = Db::getConnection();
        $time = time();

        $sql = "INSERT INTO messages (id_from, id_to, message, send_time) VALUES (:id_from, :id_to, :message, :send_time)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_from', $from, PDO::PARAM_INT);
        $stmt->bindParam(':id_to', $to, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->bindParam(':send_time', $time, PDO::PARAM_INT);

        $stmt->execute();
    }
}