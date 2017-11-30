<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-right">

        </div>
        <div class="container">

            <?php

            if (!$notifications) {
                echo '<div class="bg-warning text-center"><p>NO NEW NOTIFICATIONS</p></div>';
            }

            foreach ($notifications as $notification) {
                $time = date("H:i:s d-m-Y", $notification['time']);
                $user = Profile::getUserInfo($notification['id_from']);
                $user_name = $user['first_name'].' '.$user['last_name'];

                if ($notification['subject'] == 'check_profile') {
                    $subject = $user_name.' checked your profile.';
                } elseif ($notification['subject'] == 'message') {
                    $subject = 'You have new message from '.$user_name;
                } elseif ($notification['subject'] == 'like') {
                    $subject = $user_name.' liked you.';
                } elseif ($notification['subject'] == 'unlike') {
                    $subject = $user_name.' unliked you.';
                } elseif ($notification['subject'] == 'like_back') {
                    $subject = 'Now you matched with '.$user_name;
                } else {
                    $subject = 'You have new notification.';
                }

                echo '<div class="bg-primary text-center"><p>'.$subject.'</p><p>'.$time.'</p></div>';

            }
            ?>

        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/notifications_count.js"></script>
