<?php

class Like
{

    public static function isLiked($user_id, $target_id)
    {
        $pdo= Db::getConnection();

        $sql = "SELECT * FROM likes WHERE user_id = :user_id AND target_id = :target_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }


    public static function addLike($user_id, $target_id)
    {
        $pdo= Db::getConnection();

        $result = self::isLiked($user_id, $target_id);

        if (!$result) {
            $sql = "INSERT INTO likes (user_id, target_id) VALUES (:user_id, :target_id)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
            $stmt->execute();

            if (self::isLiked($target_id, $user_id)) {
                Notification::addNotification($user_id, $target_id, 'like_back');
            } else {
                Notification::addNotification($user_id, $target_id, 'like');
            }
        }

        return true;
    }

    public static function unlike($user_id, $target_id)
    {
        $pdo= Db::getConnection();

        $sql = "DELETE FROM likes WHERE user_id = :user_id AND target_id = :target_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
        $stmt->execute();

        Notification::addNotification($user_id, $target_id, 'unlike');
    }

    public static function matched($user1, $user2)
    {
        if (self::isLiked($user1, $user2) && self::isLiked($user2, $user1)) {
            return true;
        }
        return false;
    }
}