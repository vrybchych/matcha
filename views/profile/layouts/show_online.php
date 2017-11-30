<?php
if ($online_time) {
    echo "<strong style='color: red'>online</strong>";
} else {
    $online_time = LocationAndOnline::getLastOnlineTime($user['id']);
    if ($online_time) {
        date_default_timezone_set('Europe/Kiev');
        $online_time = date ( "l jS \of F Y h:i A" , $online_time['time']);
        echo "<span style='color: lightseagreen'>Was online: </span>";
        echo $online_time;
    }
}