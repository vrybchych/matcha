<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

<div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron text-right">

    </div>
    <div class="container">
        <div class="col-md-8">
            <form method="post">
            <kbd>sort:</kbd>
                <button type="submit" class="btn btn-info btn-xs" name="tag_sort">Match tags</button>
                <button type="submit" class="btn btn-info btn-xs" name="loc_sort">Location</button>
                <button type="submit" class="btn btn-info btn-xs" name="rating_sort"">Rating</button>
                <button type="submit" class="btn btn-info btn-xs" name="age_sort"">Age</button>
            </form>
            <br><br>
            <?php require_once ROOT . '/views/search/show_search_result.php'; ?>
        </div>
        <div class="col-md-4">
            <p class="bg-danger text-center"><em><?php if (!empty($errors)) echo array_shift($errors); ?></em></p>
            <h1>
                <small>Search parameters:</small>
            </h1>
            <?php require_once ROOT . '/views/search/tags_search_form.php'; ?>
            <?php require_once ROOT . '/views/search/search_form.php'; ?>
        </div>
    </div>
</div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/notifications_count.js"></script>
