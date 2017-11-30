<?php
foreach ($tags as $tag) {
    if ($tag['tag_name']) {
        echo '<a href="#">#' . $tag['tag_name'] . '</a>&#32';
    }
}