<?php

class ProfileController
{
    public static function actionIndex($user_id = NULL)
    {
        if (!isset($user_id)) {
            $user_id = $_COOKIE['user'];
        } else {
            Notification::addNotification($_COOKIE['user'], $user_id, 'check_profile');
        }

        $_SESSION['current_user'] = $user_id;

        if (!$user = Profile::getUserInfo($user_id)) {
            require_once(ROOT . '/views/error.php');
            return true;
        }
        $age = Profile::getAge($user['birthday']);
        $tags = Tags::getTagsByUserId($user_id);
        LocationAndOnline::setOnlineStatus();
        $rating = Rating::setRating($user_id);
        $online_time = LocationAndOnline::isOnline($user_id);
        $is_liked = Like::isLiked($_COOKIE['user'], $_SESSION['current_user']);
        $is_blocked = BlockUser::isBlock($_COOKIE['user'], $_SESSION['current_user']);

        if (isset($_POST['report_fake'])) {
            ReportFakeAccount::addUser($_SESSION['current_user']);
        }


        require_once(ROOT . '/views/profile/index.php');

        return true;
    }

    public static function actionEdit()
    {
        $tags = Tags::getTagsByUserId($_COOKIE['user']);
        $user = Profile::getUserInfo($_COOKIE['user']);

        if (isset($_POST['save_btn'])) {

            $errors = array();

            if ($e = User::checkNames($_POST['first_name'])) {
                $errors[] = $e;
            }

            if ($e = User::checkNames($_POST['last_name'])) {
                $errors[] = $e;
            }

            if ($e = Profile::checkAboutInfo($_POST['about'])) {
                $errors[] = $e;
            }

            if (empty($errors)) {
                Profile::updateFirstName($_COOKIE['user'], $_POST['first_name']);
                Profile::updateLastName($_COOKIE['user'], $_POST['last_name']);
                Profile::updateEmail($_COOKIE['user'], $_POST['email']);
                Profile::updateBirthday($_COOKIE['user'], $_POST['birthday']);
                Profile::updateGender($_COOKIE['user'], $_POST['gender']);
                Profile::updateSexualPreferences($_COOKIE['user'], $_POST['sex_pref']);
                Profile::updateAboutInfo($_COOKIE['user'], $_POST['about']);

                header('Location: /profile/');
            }
        }

        if (isset($_POST['add_tag'])) {

            $errors = array();

            if ($e = Tags::checkTagValid($_POST['tag'])) {
                $errors[] = $e;
            }

            if (empty($errors)) {
                Tags::addTag($_POST['tag'], $_COOKIE['user']);

                header('Location: /edit_profile/');
            }
        }

        require_once(ROOT . '/views/profile/edit.php');

        return true;
    }

    public static function actionPhotos()
    {
        $errors = array();

        $photos = Profile::getAllPhoto($_COOKIE['user']);

        if (isset($_POST['add_photo'])) {
            if (!Profile::addPhoto($_COOKIE['user'])) {
                $errors[] = 'You can add maximum 5 photo';
            }

            if (empty($errors)) {
                header('Location: /photos');
            }
        }

        require_once(ROOT . '/views/profile/photos.php');

        return true;
    }

    public static function actionPhoto($photo_id)
    {
        $src = Profile::getPhotoSrc($photo_id, $_COOKIE['user']);

        if (!$src) {
//            header('Location: /error');
        }

        require_once(ROOT . '/views/profile/show_one_photo.php');

        return true;
    }

    public static function actionDelete_photo($photo_id)
    {

        if (!Profile::deletePhoto($photo_id, $_COOKIE['user'])) {
            header('Location: /error');
        }

        header('Location: /photos');

        return true;
    }

    public static function actionSet_avatar($photo_id)
    {

        Profile::setAvatar($photo_id, $_COOKIE['user']);

        header('Location: /photos');

        return true;
    }


    public static function actionSet_location()
    {

        $loc = LocationAndOnline::getLocation($_SESSION['current_user']);

        if (isset($_POST['change_loc']) && isset($_POST['lat']) && isset($_POST['lng'])) {
            $loc['lat'] = $_POST['lat'];
            $loc['lng'] = $_POST['lng'];
            if ($_SESSION['current_user'] == $_COOKIE['user']) {
                LocationAndOnline::setLocation($_COOKIE['user'], $loc['lat'], $loc['lng']);
            }
        } elseif ($loc) {
            echo json_encode($loc);
            exit;
        } elseif (isset($_POST['lat']) && isset($_POST['lng'])) {
            $loc['lat'] = $_POST['lat'];
            $loc['lng'] = $_POST['lng'];
            if ($_SESSION['current_user'] == $_COOKIE['user']) {
                LocationAndOnline::setLocation($_COOKIE['user'], $loc['lat'], $loc['lng']);
            }
        }

        echo json_encode($loc);
        exit;
    }

    public static function actionDelete_tag($tag_id)
    {
        Tags::delete($tag_id, $_COOKIE['user']);

        header('Location: /edit_profile/');
    }

}