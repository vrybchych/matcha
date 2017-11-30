<?php

class Rating
{

    private static function getLikesCount($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT COUNT(*) FROM likes WHERE target_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

       $result = $stmt->fetch();

       if ($result) {
           $result = array_shift($result);
       }

       return $result;
    }

    private static function updateRating($rating, $user_id)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT rating FROM rating WHERE user_id = :user_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if (!$result) {
            $sql = 'INSERT INTO rating (user_id, rating) VALUES (:user_id, :rating)';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }

        $sql = "UPDATE rating SET rating = :rating WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public static function getTopRating()
    {
        $pdo = Db::getConnection();

        $sql = "SELECT MAX(rating) FROM rating";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result) {
            $result = array_shift($result);
        }

        return $result;
    }

    public static function setRating($user_id)
    {
        $user = Profile::getUserInfo($user_id);
        $rating = 10;

        if (isset($user['gender'])) {
            $rating += 10;
        }
        if (isset($user['sexual_preferences'])) {
            $rating += 10;
        }
        if (isset($user['birthday'])) {
            $rating += 10;
        }
        if (isset($user['about'])) {
            $rating += 10;
        }
        if (isset($user['avatar'])) {
            $rating += 10;
        }

        $photos = Profile::getAllPhoto($user_id);
        if ($photos) {
            $rating += count($photos) * 10;
        }

        $tags = Tags::getTagsByUserId($user_id);
        if ($tags) {
            $rating += count($tags) * 3;
        }

        $likesCount = self::getLikesCount($user_id);
        if ($likesCount) {
            $rating += $likesCount;
        }

        self::updateRating($rating, $user_id);

        $top_rating = self::getTopRating();

        $rating = round($rating / $top_rating * 100);

        return $rating;
    }
}