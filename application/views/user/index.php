<div id="content">
    <table  class="dataTable" summary="用户管理">
        <caption>用户管理</caption>
        <thead>
            <tr>
                <th>用户名</th>
                <th>密码</th>
                <th>权限</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value): ?>
                <tr>
                    <td><?php echo $value['UserName']; ?></td>
                    <td><?php echo '-'; ?></td>
                    <td><?php echo $value['Privilege'] > 1 ? '学生' : '管理员'; ?></td>
                    <td><a href="<?php echo WEB_FOLDER . 'user/update/' . $value['UserID']; ?>">修改</a>|<a href="<?php echo WEB_FOLDER . 'user/delete/' . $value['UserID']; ?>">删除</a></td>
                </tr>
            <?php endforeach; ?>
            <tr>
        <form id="addUser" method="post" action="<?php echo WEB_FOLDER; ?>user/add" enctype="multipart/form-data">
            <td><input id="username" name="username" type="input" /></td>
            <td><input id="password" name="password" type="password" /></td>
            <td>
                <select id="privilege" name="privilege">
                    <option value="1">管理员</option>
                    <option value="2" selected="selected">学生</option>
                </select>
            </td>
            <td><input type="submit" value="添加" /></td>
        </form>
        </tr>
        </tbody>
    </table>
</div>