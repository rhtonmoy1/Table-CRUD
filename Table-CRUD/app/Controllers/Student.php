<?php

namespace Project\Controllers;

use Exception;
use PDO;

class Student
{
    public $id;
    public $name;
    public $conn;

    private $dbUserName = 'root';
    private $dbPassword = 'root';
    private $dbName = 'tonmoy-db';

    public function __construct()
    {
        session_start();
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=' . $this->dbName, $this->dbUserName, $this->dbPassword);
        } catch (Exception $ex) {
            echo 'Database connection failed. Error: ' . $ex->getMessage();
            die();
        }
    }

    public function index()
    {
        // select query
        $statement = $this->conn->query("SELECT * FROM students ORDER BY id desc");
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function store(array $data)
    {
        try {
            $_SESSION['old'] = $data;

            if (empty($data['student_id'])) {
                $_SESSION['errors']['student_id'] = 'Required';
            } elseif (!is_numeric($data['student_id'])) {
                $_SESSION['errors']['student_id'] = 'Must be an integer';
            }

            if (empty($data['name'])) {
                $_SESSION['errors']['name'] = 'Required';
            }

            if (isset($_SESSION['errors'])) {
                return false;
            }

            // todo database insert
            $statement = $this->conn->prepare("INSERT INTO students (name, student_id) VALUES (:s_name, :s_id)");

            $statement->execute([
                's_name' => $data['name'],
                's_id' => $data['student_id']
            ]);

            unset($_SESSION['old']);
            $_SESSION['message'] = 'Successfully Created';
            return true;
        } catch (Exception $th) {
            $_SESSION['errors']['sqlError'] = $th->getMessage();
        }
    }

    public function details(int $id)
    {
        // select query
        $statement = $this->conn->query("SELECT * FROM students where id=$id");
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update(array $data, int $id)
    {
        // todo database insert
        $statement = $this->conn->prepare("UPDATE students set name=:s_name, student_id=:s_id WHERE id=:r_id");

        $statement->execute([
            'r_id' => $id,
            's_name' => $data['name'],
            's_id' => $data['student_id']
        ]);

        $_SESSION['message'] = 'Successfully Updated';
    }

    public function destroy(int $id)
    {
        $statement = $this->conn->prepare("DELETE FROM  students where id=:s_id");
        $statement->execute([
            's_id' => $id
        ]);

        $_SESSION['message'] = 'Successfully Deleted';
    }
}
