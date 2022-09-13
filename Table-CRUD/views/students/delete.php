<?php
include_once './../../vendor/autoload.php';

use Project\Controllers\Student;

$student = new Student();

$student->destroy($_GET['id']);

header('Location: ./index.php');