<?php


class ReportFakeAccount
{

    public static function addUser($user_id)
    {

        $pdo = Db::getConnection();

        $sql = "SELECT * FROM fakeAccounts WHERE user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if (!$result) {
            $sql = "INSERT INTO fakeAccounts (user_id) VALUE(:user_id)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        return true;
    }

}