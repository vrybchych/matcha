<!--<li class="left clearfix">-->
<!--                     <span class="chat-img pull-left">-->
<!--                     <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">-->
<!--                     </span>-->
<!--    <div class="chat-body clearfix">-->
<!--        <div class="header_sec">-->
<!--            <strong class="primary-font">Jack Sparrow</strong>-->
<!--        </div>-->
<!--    </div>-->
<!--</li>-->

<?php foreach ($recivers as $r): ?>
    <?php   $r = Profile::getUserInfo($r['user_id']);?>
    <a href="/message/<?= $r['id']?>" style="text-decoration: none">
    <li class="left clearfix">
                     <span class="chat-img pull-left">
                     <img src="<?= Message::getAvatarSrc($r['id']) ?>">
                     </span>
        <div class="chat-body clearfix">
            <div class="header_sec">
                <strong class="primary-font">
                <?= $r['first_name'].' '.$r['last_name'] ?>
                </strong>
            </div>
        </div>
    </li>
    </a>
<?php endforeach; ?>
