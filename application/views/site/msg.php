<div id="content">
    <?php
    if (!empty($msg)) {
        echo $msg;
    }
    ?>
    <p>请点击此处<a href="#" onclick="history.go(-1);return false;">返回上一页</a>，或者点击此处<a href="<?php echo WEB_FOLDER; ?>">返回首页</a>。</p>
</div>
