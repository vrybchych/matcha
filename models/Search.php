<?php

class Search
{

    public static function setStartParams($user)
    {
        $param = array();

        if ($user['sexual_preferences'] == 'bisexual') {
            $param['sexual_preferences'] = 'bisexual';
        } elseif ($user['gender'] == 'male' && $user['sexual_preferences'] == 'heterosexual') {
            $param['gender'] = 'female';
            $param['sexual_preferences'] = 'heterosexual';
        } elseif ($user['gender'] == 'male' && $user['sexual_preferences'] == 'homosexual') {
            $param['gender'] = 'male';
            $param['sexual_preferences'] = 'homosexual';
        } elseif ($user['gender'] == 'female' && $user['sexual_preferences'] == 'heterosexual') {
            $param['gender'] = 'male';
            $param['sexual_preferences'] = 'heterosexual';
        } elseif ($user['gender'] == 'female' && $user['sexual_preferences'] == 'homosexual') {
            $param['gender'] = 'female';
            $param['sexual_preferences'] = 'homosexual';
        }
        $param['age_to'] = '';
        $param['age_from'] = '';
        $param['rating_to'] = '';
        $param['rating_from'] = '';
        $param['last_name'] = '';
        $param['first_name'] = '';

        return $param;
    }

    public static function setParams($params)
    {
        $_SESSION['search_params'] = $params;

        //set age_gap
        if ($params['age_from'] == '') {
            $age_from = 0;
        } else {
            $age_from = $params['age_from'];
        }

        $params['age_from'] = date((date('Y') - $age_from).'-m-d');

        if ($params['age_to'] == '') {
            $age_to = 200;
        } else {
            $age_to = $params['age_to'];
        }

        $params['age_to'] = date((date('Y') - $age_to - 1).'-m-d');

        //set rating params
        if ($params['rating_from'] == '') {
            $params['rating_from'] = 0;
        } else {
            $top_rating = Rating::getTopRating();
            $params['rating_from'] = round(($params['rating_from'] * $top_rating / 100), 0, PHP_ROUND_HALF_DOWN);
        }

        if ($params['rating_to'] == '') {
            $params['rating_to'] = 9999;
        } else {
            $top_rating = Rating::getTopRating();
            $params['rating_to'] = round(($params['rating_to'] * $top_rating / 100), 0, PHP_ROUND_HALF_UP);
        }

        //set first_name and last name
        $params['first_name'] = '%'.$params['first_name'].'%';
        $params['last_name'] = '%'.$params['last_name'].'%';

        return $params;
    }

    private static function getSearchingTagCount($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT COUNT(*) FROM searchtags WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result) {
            $result = array_shift($result);
        }

        return $result;
    }

    public static function searchByParams($params, $sort_type)
    {
        $time = time();
        $time_check = $time - 300;
        $pdo = Db::getConnection();

        if (isset($params['online'])) {
            $sql_online_part  = 'AND u.id IN (SELECT user_id FROM online WHERE time > :time_check)';
        } else {
            $sql_online_part = '';
        }

        //set tag search param
        $search_tag_count = self::getSearchingTagCount($_COOKIE['user']);
        if ($search_tag_count) {
            $sql_tag_part = ' AND u.id IN (
            SELECT u.id FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id 
                WHERE ut.tag_id IN (
                    SELECT id FROM tags WHERE tag_name IN (
                        SELECT tag FROM searchtags WHERE user_id = :user_id)) 
                            GROUP BY u.id HAVING COUNT(*) = :search_tag_count)';
        } else {
            $sql_tag_part = '';
        }

        $sql = '
            SELECT * FROM users u LEFT JOIN rating r ON u.id = r.user_id WHERE
            birthday BETWEEN :age_to AND :age_from
            AND rating BETWEEN :rating_from AND :rating_to
            AND first_name LIKE :first_name
            AND last_name LIKE :last_name
            AND gender = :gender
            AND sexual_preferences = :sexual_preferences
            AND u.id != :user_id
            AND u.id NOT IN (SELECT blocked_id FROM blocked WHERE user_id = :user_id)
            '.$sql_online_part.$sql_tag_part.'
            GROUP by u.id ORDER BY '.$sort_type.' DESC;
         ';


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':age_from', $params['age_from'], PDO::PARAM_STR);
        $stmt->bindParam(':age_to', $params['age_to'], PDO::PARAM_STR);
        $stmt->bindParam(':rating_from', $params['rating_from'], PDO::PARAM_STR);
        $stmt->bindParam(':rating_to', $params['rating_to'], PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $params['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':sexual_preferences', $params['sex_pref'], PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $_COOKIE['user'], PDO::PARAM_INT);
        if ($search_tag_count) {
            $stmt->bindParam(':search_tag_count', $search_tag_count, PDO::PARAM_INT);
        }
        if (isset($params['online'])) {
            $stmt->bindParam(':time_check', $time_check, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll();

    }

    public static function sortByMatchTags($params)
    {
        $time = time();
        $time_check = $time - 300;
        self::deleteSearchTags($_COOKIE['user']);

        $pdo = Db::getConnection();

        if (isset($params['online'])) {
            $sql_online_part  = 'AND u.id IN (SELECT user_id FROM online WHERE time > :time_check) ';
        } else {
            $sql_online_part = '';
        }

        $sql = '
            SELECT *, COUNT(*) AS count FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id LEFT JOIN rating r ON u.id = r.user_id WHERE
            birthday BETWEEN :age_to AND :age_from
            AND rating BETWEEN :rating_from AND :rating_to
            AND first_name LIKE :first_name
            AND last_name LIKE :last_name
            '.$sql_online_part.'
            AND gender = :gender
            AND sexual_preferences = :sexual_preferences
            AND u.id != :user_id
            AND u.id NOT IN (SELECT blocked_id FROM blocked WHERE user_id = :user_id)
            AND ut.tag_id IN 
            (SELECT ut.tag_id FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE u.id = :user_id)
            GROUP by u.id ORDER BY count DESC;
         ';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':age_from', $params['age_from'], PDO::PARAM_STR);
        $stmt->bindParam(':age_to', $params['age_to'], PDO::PARAM_STR);
        $stmt->bindParam(':rating_from', $params['rating_from'], PDO::PARAM_STR);
        $stmt->bindParam(':rating_to', $params['rating_to'], PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $params['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':sexual_preferences', $params['sex_pref'], PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $_COOKIE['user'], PDO::PARAM_INT);
        if (isset($params['online'])) {
            $stmt->bindParam(':time_check', $time_check, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function sortByLocation($params)
    {
        $time = time();
        $time_check = $time - 300;
        self::deleteSearchTags($_COOKIE['user']);

        $pdo = Db::getConnection();

        if (isset($params['online'])) {
            $sql_online_part  = 'AND u.id IN (SELECT user_id FROM online WHERE time > :time_check) ';
        } else {
            $sql_online_part = '';
        }

        $coord = LocationAndOnline::getLocation($_COOKIE['user']);

        $sql = '
            SELECT *, ( 3959 * acos( cos( radians(:lat) ) * cos( radians( l.lat ) ) *
            cos( radians( l.lng ) - radians(:lng) ) + sin( radians(:lat) ) *
            sin( radians( l.lat ) ) ) ) AS distance FROM users u LEFT JOIN location l ON u.id = l.user_id
            LEFT JOIN rating r ON u.id = r.user_id WHERE
            birthday BETWEEN :age_to AND :age_from
            AND rating BETWEEN :rating_from AND :rating_to
            AND first_name LIKE :first_name
            AND last_name LIKE :last_name
            AND gender = :gender
            AND sexual_preferences = :sexual_preferences
            AND u.id != :user_id
            AND u.id NOT IN (SELECT blocked_id FROM blocked WHERE user_id = :user_id)
            '.$sql_online_part.'
            ORDER BY distance
         ';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':age_from', $params['age_from'], PDO::PARAM_STR);
        $stmt->bindParam(':age_to', $params['age_to'], PDO::PARAM_STR);
        $stmt->bindParam(':rating_from', $params['rating_from'], PDO::PARAM_STR);
        $stmt->bindParam(':rating_to', $params['rating_to'], PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $params['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':sexual_preferences', $params['sex_pref'], PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $_COOKIE['user'], PDO::PARAM_INT);
        $stmt->bindParam(':lat', $coord['lat'], PDO::PARAM_STR);
        $stmt->bindParam(':lng', $coord['lng'], PDO::PARAM_STR);
        if (isset($params['online'])) {
            $stmt->bindParam(':time_check', $time_check, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function showBlockedUsers($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM users WHERE id IN (SELECT blocked_id FROM blocked WHERE user_id = :user_id)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function showAllUsers()
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM users";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function deleteTag($tag, $user_id)
    {
        $tag = htmlspecialchars($tag);
        $pdo = Db::getConnection();

        $sql = "DELETE FROM searchTags WHERE user_id = :user_id AND tag = :tag";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function addTag($tag, $user_id)
    {
        $tag = htmlspecialchars($tag);
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM searchTags WHERE user_id = :user_id AND tag = :tag";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result) {
            return true;
        }

        $sql = "INSERT INTO searchTags (user_id, tag) VALUE (:user_id, :tag)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }

    public static function getSearchTags($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT tag FROM searchTags WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function deleteSearchTags($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "DELETE FROM searchTags WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }


    public static function simpleSearch($user)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM users LIMIT 20";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public static function checkNames($name)
    {
        if (!preg_match("/^[a-zA-Z-]+$/", $name)) {
            return 'First name and last name must contain only letters';
        }

        return false;
    }

    public static function checkAge($age)
    {
        if (!preg_match("/^[0-9]+$/", $age)) {
            return 'Wrong age format!';
        }

        return false;
    }

    public static function checkRating($rating)
    {
        if (!preg_match("/^[0-9]+$/", $rating)) {
            return 'Wrong rating format!';
        }

        return false;
    }
}



/*
 * SELECT COUNT(*) FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE u.id = 3 AND ut.tag_id IN (SELECT ut.tag_id FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE u.id = 1)
 * SELECT *, COUNT(*) AS count FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE ut.tag_id IN (SELECT ut.tag_id FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE u.id = 1) GROUP by u.id ORDER BY count DESC
 * SELECT *, COUNT(*) AS count FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE u.id != 1 AND ut.tag_id IN (SELECT ut.tag_id FROM users u LEFT JOIN users_tags ut ON u.id = ut.user_id WHERE u.id = 1) GROUP by u.id ORDER BY count DESC
 */