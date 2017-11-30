<h4><em><?= $user['first_name'] ?>
        <?= $user['last_name'] ?></em></h4><br>
<?php

if ($age) {
    echo "<em>Age: </em><strong>$age</strong><br>";
}

if (isset($user['gender'])) {
    echo "<em>Gender: </em><strong>{$user['gender']}</strong><br>";
}

if (isset($user['sexual_preferences'])) {
    echo "<em>Sexual preferences: </em><strong>{$user['sexual_preferences']}</strong><br>";
}

if (isset($user['about'])) {
    $about = nl2br($user['about']);
    echo "<br><em>$about</em>";
}
?>