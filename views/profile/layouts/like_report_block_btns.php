<form method="post">
    <?php
    if (Profile::getAllPhoto($_COOKIE['user'])) {
        $like = 'inline';
        $unlike = 'none';
        if ($is_liked) {
            $unlike = 'inline';
            $like = 'none';
        }
        echo '<span id="like_span" style="display: ' . $like . ';"><button id="like" type="submit" class="btn btn-success btn-xs" name="like"><strong>L I K E</strong></button></span>&#32';
        echo '<span id="unlike_span" style="display: ' . $unlike . ';"><button id="unlike" type="submit" class="btn btn-warning btn-xs" name="unlike">Unlike</button></span>&#32';
    }

    $block = 'inline';
    $unblock = 'none';
    if ($is_blocked) {
        $block = 'none';
        $unblock = 'inline';
    }
    echo '<span id="block_span" style="display: '.$block.';"><button id="block" type="submit" class="btn btn-danger btn-xs" name="block">Block</button></span>';
    echo '<span id="unblock_span" style="display: '.$unblock.';"><button id="unblock" type="submit" class="btn btn-danger btn-xs" name="unblock">Unblock</button></span>';
    ?>
    <button type="submit" class="btn btn-danger btn-xs" name="report_fake">Report a fake account</button>
</form>