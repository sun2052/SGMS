<div id="content">
    <table  class="dataTable" summary="修改用户">
        <caption>修改用户</caption>
        <thead>
            <tr>
                <th>用户名</th>
                <th>密码</th>
                <th>确认密码</th>
                <th>权限</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <tr>
        <form id="updateuser" method="post" action="<?php echo WEB_FOLDER; ?>user/update/<?php echo $data['UserID']; ?>" enctype="multipart/form-data">
            <td><?php echo $data['UserName']; ?></td>
            <td><input id="password" name="password" type="password" /></td>
            <td><input id="repassword" name="repassword" type="password" /></td>
            <td>
                <select id="privilege" name="privilege">
                    <option value="1"<?php echo $data['Privilege'] == 1 ? ' selected="selected"' : ''; ?>>管理员</option>
                    <option value="2"<?php echo $data['Privilege'] == 2 ? ' selected="selected"' : ''; ?>>学生</option>
                </select>
            </td>
            <td><input type="submit" value="保存" /></td>
        </form>
        </tr>
        </tbody>
    </table>
</div>