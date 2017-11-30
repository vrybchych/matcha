<?php
if ($search_tags) {
    foreach ($search_tags as $tag) {
        if ($tag['tag']) {
            echo '<a href="/delete_search_tag/' . $tag['tag'] . '" style="color: red">#' . $tag['tag'] . '</a>&#32';
        }
    }
}
?>
<form class="form-horizontal" method="post" action="">
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">#</span>
            <input type="text" class="form-control" aria-describedby="basic-addon1" name="search_tag">
        </div>
        <button type="submit" class="btn btn-default btn-xs btn-block" name="add_search_tag">Add tag</button>
        <br>
    </div>
</form>