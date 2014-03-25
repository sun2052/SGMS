<div id="content">
    <form id="login" method="post" action="<?php echo WEB_FOLDER; ?>user/login" enctype="multipart/form-data">
        <fieldset>  
            <legend>登录</legend>
            <label for="username">用户名</label>
            <input id="username" name="username"type="text" value="<?php
if (isset($_POST['username'])) {
    echo $_POST['username'];
}
?>" />
            <label for="password">密码</label>
            <input id="password" name="password" type="password" />
            <br />
            <input id="submit" type="submit" value="登录" />
        </fieldset>
    </form>
</div>
