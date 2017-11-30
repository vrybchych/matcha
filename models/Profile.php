<?php

class Profile
{

    public static function getUserInfo($id)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user_info = $stmt->fetch();
        return $user_info;
    }

    public static function getAge($birthday)
    {
        $date = new DateTime($birthday);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y;
    }

    public static function checkAboutInfo($about)
    {
        if (strlen(trim($about)) > 200) {
            return 'Information about yourself can not be longer than 200 characters.';
        }
    }

    public static function updateFirstName($id, $first_name)
    {
        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET first_name = :first_name WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateLastName($id, $last_name)
    {
        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET last_name = :last_name WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateEmail($id, $email)
    {
        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET email = :email WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateBirthday($id, $birthday)
    {
        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET birthday = :birthday WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateGender($id, $gender)
    {
        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET gender = :gender WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateSexualPreferences($id, $sex_pref)
    {
        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET sexual_preferences = :sexual_preferences WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':sexual_preferences', $sex_pref, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateAboutInfo($id, $about)
    {
        $about = htmlspecialchars($about);

        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET about = :about WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':about', $about, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    private static function checkPhotosCount($user_id)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT * FROM photos WHERE user_id = :user_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        if (count($result) >= 5) {
            return false;
        }

        return true;
    }

    public static function getPhotoIdByName($src)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT id FROM photos WHERE src = :src';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':src', $src, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function addPhoto($user_id)
    {
        //if numbens of photo >= 5 return false
        if (!self::checkPhotosCount($user_id)) {
            return false;
        }

        $user = self::getUserInfo($user_id);
        $path = ROOT . '/src/users_photos/'.$user['user_name'].'/';

        if (!file_exists($path)) {
            mkdir($path);
        }

        $photo_src = $_FILES['picture']['name'];

        if (self::getPhotoIdByName($_FILES['picture']['name'])) {
            $counter = 1;
            while (self::getPhotoIdByName($counter . $_FILES['picture']['name'])) {
                $counter++;
            }
            $photo_src = $counter . $_FILES['picture']['name'];
        }

        if (!@copy($_FILES['picture']['tmp_name'], $path . $photo_src)) {
            return true;
        }
        else {
            $pdo = Db::getConnection();

            $sql = 'INSERT INTO photos (user_id, src) VALUES (:user_id, :src)';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':src', $photo_src, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }

    }

    public static function getAllPhoto($user_id)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT * FROM photos WHERE user_id = :user_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getPhotoSrc($photo_id, $user_id)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT src FROM photos WHERE id = :id AND user_id = :user_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $photo_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['src'];
    }

    public static function deletePhoto($photo_id, $user_id)
    {
        $src = self::getPhotoSrc($photo_id, $user_id);

        $pdo = Db::getConnection();

        $sql = 'DELETE FROM photos WHERE id = :id AND user_id = :user_id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $photo_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $result =  $stmt->execute();

        if (!$result) {
            return false;
        }

        $user = self::getUserInfo($user_id);
        $file_to_delete = ROOT . '/src/users_photos/' . $user['user_name'] . '/'.$src;
        unlink($file_to_delete);

        /** UPDATE USERS AVATAR */
        $sql = 'UPDATE users SET avatar = NULL WHERE avatar = :avatar';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avatar', $photo_id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public static function setAvatar($photo_id, $user_id)
    {
        if (!self::getPhotoSrc($photo_id, $user_id))
            return false;

        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET avatar = :avatar WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':avatar', $photo_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }
}