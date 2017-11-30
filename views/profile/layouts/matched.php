<?php
    if (Like::matched($_COOKIE['user'], $_SESSION['current_user'])) {
        echo '<div><button type="button" class="btn btn-lg btn-success btn-sm btn-block" disabled="disabled">Matched</button></div>';
    }