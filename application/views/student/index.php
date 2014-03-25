<div id="content">
    <table  class="dataTable" summary="学生管理">
        <caption>学生管理</caption>
        <thead>
            <tr>
                <th>学号</th>
                <th>姓名</th>
                <th>性别</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value): ?>
                <tr>
                    <td><?php echo $value['StudentNumber']; ?></td>
                    <td><?php echo $value['StudentName']; ?></td>
                    <td><?php echo $value['Gender'] == 1 ? '男' : '女'; ?></td>
                    <td><a href="<?php echo WEB_FOLDER . 'student/delete/' . $value['StudentID']; ?>">删除</a></td>
                </tr>
            <?php endforeach; ?>
            <tr>
        <form id="addStudent" method="post" action="<?php echo WEB_FOLDER; ?>student/add" enctype="multipart/form-data">
            <td><input id="studentnumber" name="studentnumber" type="input" /></td>
            <td><input id="studentname" name="studentname" type="input" /></td>
            <td>
                <select id="gender" name="gender">
                    <option value="1">男</option>
                    <option value="2">女</option>
                </select>
            </td>
            <td><input type="submit" value="添加" /></td>
        </form>
        </tr>
        </tbody>
    </table>
</div>