<?php

class SearchController
{

    public static function actionIndex()
    {
        $user = Profile::getUserInfo($_COOKIE['user']);
        $users = Search::simpleSearch($user);
        LocationAndOnline::setOnlineStatus();
        $errors = array();

        if (!isset($_SESSION['search_params'])) {
            $_SESSION['search_params'] = Search::setStartParams($user);
        }

        $search_params = Search::setParams($_SESSION['search_params']);

        /**
         * choose sort type
         */
        if (isset($_POST['tag_sort'])) {
            $search_tags = null;
            $users = Search::sortByMatchTags($search_params);
        } elseif (isset($_POST['loc_sort'])) {
            $search_tags = null;
            $users = Search::sortByLocation($search_params);
        } elseif (isset($_POST['age_sort'])) {
            $search_tags = Search::getSearchTags($user['id']);
            $users = Search::searchByParams($search_params, "birthday");
        } elseif (isset($_POST['show_blocked_user'])) {
            $search_tags = null;
            $users = Search::showBlockedUsers($user['id']);
        } elseif (isset($_POST['show_all_user'])) {
            $search_tags = null;
            $users = Search::showAllUsers();
        } else {
            $search_tags = Search::getSearchTags($user['id']);
            $users = Search::searchByParams($search_params, "rating");
        }

        if (isset($_POST['search'])) {

            if (($e = Search::checkNames($_POST['first_name'])) && $_POST['first_name'] != '') {
                $errors[] = $e;
            }

            if (($e = Search::checkNames($_POST['last_name'])) && $_POST['last_name'] != '') {
                $errors[] = $e;
            }

            if (($e = Search::checkAge($_POST['age_from'])) && $_POST['age_from'] != '') {
                $errors[] = $e;
            }

            if (($e = Search::checkAge($_POST['age_to'])) && $_POST['age_to'] != '') {
                $errors[] = $e;
            }

            if (($e = Search::checkRating($_POST['rating_from'])) && $_POST['rating_from'] != '') {
                $errors[] = $e;
            }

            if (($e = Search::checkRating($_POST['rating_to'])) && $_POST['rating_to'] != '') {
                $errors[] = $e;
            }

            if (empty($errors)) {
                Search::setParams($_POST);
                header('Location: /search/');
            }

        }

        if (isset($_POST['add_search_tag'])) {

            if ($e = Tags::checkTagValid($_POST['search_tag'])) {
                $errors[] = $e;
            }

            if (empty($errors)) {
                Search::addTag($_POST['search_tag'], $user['id']);

                header('Location: /search/');
            }
        }

        require_once (ROOT . '/views/search/index.php');

        return true;
    }

    public static function actionDelete_search_tag($tag)
    {
        Search::deleteTag($tag, $_COOKIE['user']);
        header('Location: /search/');
    }

}