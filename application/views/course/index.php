<div id="content">
    <table  class="dataTable" summary="课程管理">
        <caption>课程管理</caption>
        <thead>
            <tr>
                <th>课程名称</th>
                <th>课程学分</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value): ?>
                <tr>
                    <td><?php echo $value['CourseName']; ?></td>
                    <td><?php echo $value['CourseCredit']; ?></td>
                    <td><a href="<?php echo WEB_FOLDER . 'course/delete/' . $value['CourseID']; ?>">删除</a></td>
                </tr>
            <?php endforeach; ?>
            <tr>
        <form id="addCourse" method="post" action="<?php echo WEB_FOLDER; ?>course/add" enctype="multipart/form-data">
            <td><input id="coursename" name="coursename" type="input" /></td>
            <td><input id="coursecredit" name="coursecredit" type="input" /></td>
            <td><input type="submit" value="添加" /></td>
        </form>
        </tr>
        </tbody>
    </table>
</div>