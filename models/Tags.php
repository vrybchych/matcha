<?php

class Tags
{

    public static function getTagIdByTagName($tag)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT id FROM tags WHERE tag_name = :tag_name";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tag_name', $tag, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function addTag($tag, $user_id)
    {
        $tag = htmlspecialchars($tag);
        $pdo = Db::getConnection();
        $tag_id = self::getTagIdByTagName($tag);

        if ($tag_id) {
            $tag_id = $tag_id['id'];
            $sql = "SELECT * FROM users_tags WHERE user_id = :user_id AND tag_id = :tag_id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch();

            if ($result) {
                return true;
            }
        } else {
            $sql = "INSERT INTO tags (tag_name) VALUES (:tag_name)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':tag_name', $tag, PDO::PARAM_STR);
            $stmt->execute();
        }

        $tag_id = self::getTagIdByTagName($tag);
        $tag_id = $tag_id['id'];

        $sql = "INSERT INTO users_tags (user_id, tag_id) VALUES (:user_id, :tag_id)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return true;
    }

    public static function delete($tag_id, $user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT * FROM users_tags WHERE user_id = :user_id AND tag_id = :tag_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result) {
            $sql = "DELETE FROM tags WHERE id = :tag_id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "DELETE FROM users_tags WHERE user_id = :user_id AND tag_id = :tag_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        return true;
    }

    public static function getTagsByUserId($user_id)
    {
        $pdo = Db::getConnection();

        $sql = "SELECT t.id, t.tag_name FROM users u
                LEFT JOIN users_tags ut ON u.id = ut.user_id
                LEFT JOIN tags t ON ut.tag_id = t.id
                WHERE u.id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function checkTagValid($tag)
    {
        if (strlen(trim($tag)) < 1 || strlen(trim($tag)) > 20) {
            return 'Tag must contain from 1 to 20 characters';
        }

        if (preg_match("/#/", $tag)) {
            return 'U can\'t use # symbol for tags';
        }

        return false;
    }
}