<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>

<body>

    <?php
    include_once './../../vendor/autoload.php';

    use Project\Controllers\Student;

    $studentObj = new Student();

    $students = $studentObj->index();

    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    ?>

    <a href="./create.php">Create </a>
    <table border="1" style="width: 100%;">
        <thead>
            <tr>
                <th>SL</th>
                <th>Student Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 0;
            foreach ($students as $student) { ?>
                <tr>
                    <td><?= ++$sl ?></td>
                    <td><?= $student['student_id'] ?></td>
                    <td><?= $student['name'] ?></td>
                    <td>
                        <a href="show.php?id=<?= $student['id'] ?>">Show</a>
                        <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                        <a href="delete.php?id=<?= $student['id'] ?>" onclick="return confirm('Are You Sure Want to Delete ?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>