<?php if (!isset($_COOKIE['user'])) header("Location: /"); ?>
<?php require_once ROOT . '/views/layouts/header.php'; ?>

    <div class="container theme-showcase" role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron text-right">

        </div>
        <div class="container">


            <script src="https://use.fontawesome.com/45e03a14ce.js"></script>
            <div class="main_section">
                <div class="container">
                    <div class="chat_container">
                        <div class="col-sm-3 chat_sidebar">
                            <div class="row">
                                <div id="custom-search-input">
                                    Conversations
                                </div>
                                <div class="member_list">
                                    <ul class="list-unstyled">
                                        <?php require_once ROOT . '/views/message/show_recivers.php'; ?>
                                    </ul>
                                </div></div>
                        </div>
                        <!--chat_sidebar-->


                        <div class="col-sm-9 message_section">
                            <div class="row">
                                <div class="chat_area">
                                    <ul class="list-unstyled append_message">
                                        <?php require_once ROOT . '/views/message/show_messages.php'; ?>
                                    </ul>
                                </div><!--chat_area-->
                                <?php require_once ROOT . '/views/message/write_message.php'; ?>
                            </div>
                        </div> <!--message_section-->
                    </div>
                </div>
            </div>


        </div>
    </div>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/message.js"></script>
<script src="/template/js/notifications_count.js"></script>