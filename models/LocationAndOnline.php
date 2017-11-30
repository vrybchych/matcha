<?php

class LocationAndOnline
{
    public static function setLocation($user_id, $lat, $lng)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM location WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if (!$result) {
            $sql = "INSERT INTO location (user_id, lat, lng) VALUES(:user_id, :lat, :lng)";

        } else {
            $sql = "UPDATE location SET lat = :lat, lng = :lng WHERE user_id = :user_id";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
        $stmt->bindParam(':lng', $lng, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }

    public static function getLocation($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM location WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    }

    public static function setOnlineStatus()
    {
        if (isset($_COOKIE['user'])) {
            $user_id = $_COOKIE['user'];
            $time = time();
            $pdo = Db::getConnection();


            $sql = 'SELECT * FROM online WHERE user_id = :user_id';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch();


            if (!$result) {
                $sql = 'INSERT INTO online (user_id, time) VALUES (:user_id, :time)';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':time', $time, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $sql = 'UPDATE online SET time = :time WHERE user_id = :user_id';

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':time', $time, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        return true;
    }

    public static function isOnline($user_id)
    {
        $time = time();
        $time_check = $time - 300;

        $pdo = Db::getConnection();

        $sql = "SELECT time FROM online WHERE user_id = :user_id AND time > :time_check";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':time_check', $time_check, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getLastOnlineTime($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT time FROM online WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

}