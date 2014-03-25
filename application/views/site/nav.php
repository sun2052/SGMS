<div id="nav">
    <ul>
        <li><a href="<?php echo WEB_FOLDER . 'site'; ?>">首页</a></li>
        <li><a href="<?php echo WEB_FOLDER . 'user'; ?>">用户管理</a></li>
        <li><a href="<?php echo WEB_FOLDER . 'student'; ?>">学生管理</a></li>
        <li><a href="<?php echo WEB_FOLDER . 'course'; ?>">课程管理</a></li>
        <li><a href="<?php echo WEB_FOLDER . 'grade'; ?>">成绩管理</a></li>
        <li><a href="<?php echo WEB_FOLDER . 'search'; ?>">成绩查询</a></li>
        <?php if (isset($_SESSION['Authenticated']) && $_SESSION['Authenticated'] == true): ?>
            <li class="last"><a href="<?php echo WEB_FOLDER . 'user/logout'; ?>">退出<?php echo '(' . ($_SESSION['Privilege'] > 1 ? '权限:学生' : '权限:管理员') . ')'; ?></a></li>
        <?php else: ?>
            <!-- <li class="last"><a href="<?php echo WEB_FOLDER . 'user/login'; ?>">登录</a></li> -->
        <?php endif; ?>
    </ul>
</div>
