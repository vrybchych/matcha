<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Matcha</title>
    <link rel="shortcut icon" href="/template/pictures/matcha_ico.ico" type="image/x-icon">
    <link rel="stylesheet" href="/template/css/style.css">
    <link rel="stylesheet" href="/template/css/chat.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
          crossorigin="anonymous">
</head>
<header>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                            aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="<?= '/' ?>">Matcha</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= '/' ?>">Home</a></li>
                        <?php if (isset($_COOKIE['user'])): ?>
                            <li><a href="<?= '/notifications/' ?>">Notifications
                                    <span id="notifications_count" class="badge"></span></a></li>
                            <li><a href="<?= '/message/' ?>">Message</a></li>
                            <li><a href="<?= '/search/' ?>">Search</a></li>
                            <li><a href="<?= '/photos/' ?>">Photos</a></li>
                            <li><a href="<?= '/edit_profile/' ?>">Edit profile</a></li>
                            <li><a href="<?= '/logout/' ?>">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
</header>
<body>