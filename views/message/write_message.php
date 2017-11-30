<!--<form class="form-horizontal text-center" method="post" action="">-->
<!--    <div class="message_write">-->
<!--        <textarea class="form-control" placeholder="type a message" name="message_text"></textarea>-->
<!--        <div class="clearfix"></div>-->
<!--        <div class="chat_bottom">-->
<!--            <button type="submit" class="pull-right btn btn-success" name="send">Send</button>-->
<!--        </div>-->
<!--    </div>-->
<!--</form>-->

<div class="message_write">
    <textarea class="form-control" id="message" data-text="<?= $reciver?>" placeholder="type a message"></textarea>
    <div class="clearfix"></div>
    <div class="chat_bottom">
<!--        <a href="#" class="pull-right btn btn-success">-->
<!--            Send</a></div>-->
        <input type="submit" name="send" id="send" class="btn btn-success pull-right">
</div>