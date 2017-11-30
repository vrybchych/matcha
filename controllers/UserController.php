<?php

class UserController
{

    public function actionSign_up()
    {
        $result = false;

        if (isset($_POST['submit'])) {

            $errors = array();

            if ($e = User::checkUserName($_POST['user_name'])) {
                $errors[] = $e;
            }

            if (User::checkUserNameExists($_POST['user_name'])) {
                $errors[] = 'Such User name already exists';
            }

            if (User::checkEmail($_POST['email'])) {
                $errors[] = 'Please enter email';
            }

            if (User::checkEmailExists($_POST['email'])) {
                $errors[] = 'Such email already exists';
            }

            if ($e = User::checkNames($_POST['first_name'])) {
                $errors[] = $e;
            }

            if ($e = User::checkNames($_POST['last_name'])) {
                $errors[] = $e;
            }

            if ($e = User::checkPassword($_POST['password1'], $_POST['password2'])) {
                $errors[] = $e;
            }

            if (empty($errors)) {
                $result = User::register($_POST);
            }

        }

        require_once ROOT . '/views/user/sign_up.php';

        return true;
    }

    public function actionSign_in()
    {
        if (isset($_POST['submit'])) {

            $errors = array();

            if ($e = User::checkUserName($_POST['user_name'])) {
                $errors[] = $e;
            }

            if (!User::checkUserNameExists($_POST['user_name'])) {
                $errors[] = 'No such User';
            }

            if ($e = User::checkPasswordLogin($_POST['password'], $_POST['user_name'])) {
                $errors[] = $e;
            }

            if ($e = User::checkActivation($_POST['user_name'])) {
                $errors[] = $e;
            }

            if (empty($errors)) {
                User::login($_POST['user_name']);
                Search::deleteSearchTags($_COOKIE['user']);
                header("Location: /profile/");
                return true;
            }

        }

        require_once(ROOT . '/views/user/sign_in.php');

        return true;
    }

    public function actionLogout()
    {
        User::logout();

        header("Location: /");
        return true;
    }

    public function actionActivate($id, $token)
    {
        if (User::activate($id, $token)) {
            header("Location: /sign_in");
        } else {
            header("Location: /error");
        }
        return true;
    }

    public function actionForgot_password()
    {
        $result = false;


        if (isset($_POST['submit'])) {
            if (User::checkEmail($_POST['email'])) {
                $result[] = 'Please enter email';
            }
            if (!$result) {
                User::forgotPassword($_POST['email']);
                $result[] = 'Please check your email!';
            }
        }

        require_once (ROOT . '/views/user/forgot_password.php');

        return true;
    }

    public function actionReset_password($id, $token)
    {
        $errors = array();

        if (User::checkUserToken($id, $token)) {
            $_SESSION['reset_password_token'] = $token;
        }

        if (isset($_POST['submit']) && isset($_SESSION['reset_password_token']))
        {
            if ($e = User::checkPassword($_POST['password1'], $_POST['password2'])) {
                $errors[] = $e;
            }
            if (empty($errors)) {
                if (User::resetPassword($id, $_POST['password1'], $token)) {
                    header("Location: /");
                } else {
                    header("Location: /error");
                }
                return true;
            }
        } elseif(!isset($_SESSION['reset_password_token'])) {
            header("Location: /error");
        }

        require_once (ROOT . '/views/user/reset_password.php');

        return true;
    }

}