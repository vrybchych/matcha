<?php


class User
{

    public static function register($data)
    {

        $token = md5(uniqid(rand(), true));

        $pdo = Db::getConnection();

        $sql = 'INSERT INTO users (user_name, email, password, first_name, last_name, token)
                  VALUES (:user_name, :email, :password, :first_name, :last_name, :token)';

        $hash_password = hash('whirlpool', $data['password1']);

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $data['user_name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $hash_password, PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);

        $result = $stmt->execute();

        $sql = 'SELECT id FROM users WHERE user_name = :user_name';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $data['user_name'], PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();
        $id = $row['id'];

        //send mail
        $subject = 'Matcha confirmation link';
        $activation_link = 'http://' . $_SERVER['HTTP_HOST'] . '/auth/' . $id . '/' . $token;
        $message = 'Hi! Help us secure your account by verifying your email address (' . $data['email'] . '):  ' . $activation_link;
        mail($data['email'], $subject, $message);

        return $result;
    }

    public static function checkUserName($user_name)
    {
        if (strlen(trim($user_name)) < 4 || strlen(trim($user_name)) > 12) {
            return 'User name must contain from 4 to 12 characters';
        }

        if (!preg_match("/^[a-zA-Z0-9]+$/", $user_name)) {
            return 'User name must contain only letters and numbers';
        }

        return false;
    }

    public static function checkUserNameExists($user_name)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE user_name = :user_name';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result['user_name'] == $user_name) {
            return true;
        }
        return false;
    }

    public static function checkEmail($email)
    {
        if ($email == '')
            return true;
        return false;
    }


    public static function checkEmailExists($email)
    {

        $pdo = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetchColumn())
            return true;
        return false;
    }

    public static function checkNames($name)
    {
        if ($name == '' || strlen(trim($name)) > 30) {
            return 'First name and last name must contain from 1 to 30 characters';
        }

        if (!preg_match("/^[a-zA-Z-]+$/", $name)) {
            return 'First name and last name must contain only letters';
        }

        return false;
    }

    public static function checkPassword($p1, $p2)
    {
        if (strlen(trim($p1)) < 6 || strlen(trim($p1)) > 12)
            return 'Password must contain from 6 to 12 characters';

        if ($p1 != $p2)
            return 'Passwords do not match';

        return false;
    }

    public static function checkPasswordLogin($password, $user_name)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT password FROM users WHERE user_name = :user_name';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();
        $password_db = $row['password'];
        $password = hash('whirlpool', $password);

        if ($password_db != $password) {
            return 'Wrong password!';
        }
        return false;
    }

    public static function checkActivation($user_name)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT confirm FROM users WHERE user_name = :user_name';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();
        $confirm = $row['confirm'];

        if ($confirm == '0') {
            return 'You must activate your account!';
        }
        return false;
    }

    public static function login($user_name)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT id FROM users WHERE user_name = :user_name';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();
        $id = $row['id'];

        setcookie("user", $id);
    }

    public static function logout()
    {
        session_destroy();
        setcookie("user", "", time() - 3600, "/");
    }

    public static function activate($id, $token)
    {
        $confirm = '1';

        $pdo = Db::getConnection();

        $sql = 'UPDATE users SET confirm = :confirm WHERE id = :id AND token = :token';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':confirm', $confirm, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        $sql = 'SELECT * FROM users WHERE id=' . $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result['confirm']) {

            $token = md5(uniqid(rand(), true));

            $sql = 'UPDATE users SET token = :token WHERE id = :id';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $result['id'], PDO::PARAM_INT);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        }
        return false;
    }

    public static function forgotPassword($email)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        //send mail
        $subject = 'Matcha. Reset password.';
        $activation_link = 'http://' . $_SERVER['HTTP_HOST'] . '/reset_password/' . $user['id'] . '/' . $user['token'];
        $message = 'Reset password: ' . $activation_link;
        mail($email, $subject, $message);
        self::logout();
    }

    public static function checkUserToken($id, $token)
    {
        $pdo = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user['token'] != $token) {
            return false;
        }
        return true;
    }

    public static function resetPassword($id, $password, $token)
    {
        $pdo = Db::getConnection();

        if (isset($_SESSION['reset_password_token']) && $_SESSION['reset_password_token'] == $token) {
            unset($_SESSION['reset_password_token']);

            $token = md5(uniqid(rand(), true));
            $password = hash('whirlpool', $password);

            $sql = 'UPDATE users SET token = :token, password = :password WHERE id = :id';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        }
        return false;
    }
}