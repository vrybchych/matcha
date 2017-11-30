<?php

class BlockUser
{

    public static function isBlock($user_id, $blocked_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM blocked WHERE user_id = :user_id AND blocked_id = :blocked_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':blocked_id', $blocked_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function block($user_id, $blocked_id)
    {
        $pdo = Db::getConnection();

        $result = self::isBlock($user_id, $blocked_id);

        if (!$result) {
            $sql = "INSERT INTO blocked (user_id, blocked_id) VALUES (:user_id, :blocked_id)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':blocked_id', $blocked_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public static function unblock($user_id, $blocked_id)
    {
        $pdo = Db::getConnection();

        $sql = "DELETE FROM blocked WHERE user_id = :user_id AND blocked_id = :blocked_id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':blocked_id', $blocked_id, PDO::PARAM_INT);
        $stmt->execute();

    }

}