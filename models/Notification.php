<?php

class Notification
{

    public static function getUnreadNotifications($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM notifications WHERE id_to = :user_id AND read_status = '0'
        AND id_from NOT IN (SELECT b.blocked_id FROM blocked b
        LEFT JOIN notifications n ON b.user_id = n.id_to WHERE b.blocked_id = n.id_from)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getLastNotifications($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM notifications WHERE id_to = :user_id 
                AND id_from NOT IN (SELECT blocked_id FROM blocked WHERE user_id = :id_from) LIMIT 15";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getNotifications($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM notifications WHERE id_to = :user_id AND read_status = '0'
                AND id_from NOT IN (SELECT b.blocked_id FROM blocked b
                LEFT JOIN notifications n ON b.user_id = n.id_to WHERE b.blocked_id = n.id_from)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    private static function checkCheckedProfile($id_from, $id_to, $subject)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM notifications WHERE id_from = :id_from AND id_to = :id_to AND
                subject = :subject AND read_status = '0'";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_from', $id_from, PDO::PARAM_INT);
        $stmt->bindParam(':id_to', $id_to, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function addNotification($id_from, $id_to, $subject)
    {
        $time = time();

        $pdo = Db::getConnection();

        $sql = "INSERT INTO notifications (id_from, id_to, subject, time)
                VALUES (:id_from, :id_to, :subject, :time)";

        if ($subject == 'check_profile') {
            if (self::checkCheckedProfile($id_from, $id_to, $subject)) {
                return true;
            }
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_from', $id_from, PDO::PARAM_INT);
        $stmt->bindParam(':id_to', $id_to, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function updateStatus($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "UPDATE notifications SET read_status = '1' WHERE id_to = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

}