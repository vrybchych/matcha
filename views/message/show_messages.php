<!--<li class="left clearfix">-->
<!--                     <span class="chat-img1 pull-left">-->
<!--                     <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">-->
<!--                     </span>-->
<!--    <div class="chat-body1 clearfix">-->
<!--        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>-->
<!--        <div class="chat_time pull-right">09:40PM</div>-->
<!--    </div>-->
<!--</li>-->

<?php foreach ($messages as $message): ?>

    <li class="left clearfix">
        <?php if ($message['id_from'] == $_COOKIE['user']) : ?>
            <span class="chat-img1 pull-right">
                <img src="<?= $userAvatar ?>"
                     alt="User Avatar" class="img-circle">
                         </span>
        <?php else : ?>
            <span class="chat-img1 pull-left">
                <img src="<?= $reciverAvatar ?>"
                     alt="User Avatar" class="img-circle">
                         </span>
        <?php endif; ?>

        <div class="chat-body1 clearfix">
            <p><?= $message['message'] ?></p>
            <div class="chat_time pull-right">
                <?php
                    $time = date("Y-m-d H:i:s", $message['send_time']);
                    echo $time;
                ?></div>
        </div>
    </li>

<?php endforeach; ?>