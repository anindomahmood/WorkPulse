<?php

class Task
{


    function getTeamLeaders($conn)
    {

        $sql = "SELECT * FROM users 
                WHERE role='team_leader'";


        $stmt = $conn->prepare($sql);


        $stmt->execute();


        $teamLeaders = $stmt->fetchAll();


        return $teamLeaders;

    }




    function createTask($conn, $title, $description, $assigned_by, $assigned_to, $due_date)
    {

        $sql = "INSERT INTO tasks
                (title, description, assigned_by, assigned_to, due_date)
                VALUES
                (?, ?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);


        $result = $stmt->execute([
            $title,
            $description,
            $assigned_by,
            $assigned_to,
            $due_date
        ]);



        if($result)
        {

            $task_id = $conn->lastInsertId();



            $sql = "SELECT title FROM tasks 
                    WHERE task_id=?";


            $stmt = $conn->prepare($sql);


            $stmt->execute([
                $task_id
            ]);


            $task = $stmt->fetch();



            $message = "New task assigned: " . $task["title"];



            $sql = "INSERT INTO notifications
                    (message, recipient_id, type)
                    VALUES
                    (?, ?, ?)";


            $stmt = $conn->prepare($sql);


            $stmt->execute([
                $message,
                $assigned_to,
                "New Task Assigned"
            ]);

        }



        return $result;

    }




    function getManagerTasks($conn, $manager_id)
    {

        $sql = "SELECT tasks.*, users.full_name 
                FROM tasks
                JOIN users
                ON tasks.assigned_to = users.user_id
                WHERE tasks.assigned_by=?";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        $tasks = $stmt->fetchAll();


        return $tasks;

    }




    function getTaskById($conn, $task_id, $manager_id)
    {

        $sql = "SELECT * FROM tasks
                WHERE task_id=?
                AND assigned_by=?";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $task_id,
            $manager_id
        ]);


        $task = $stmt->fetch();


        return $task;

    }





    function updateTask($conn, $title, $description, $assigned_to, $due_date, $task_id, $manager_id)
    {

        $sql = "UPDATE tasks
                SET title=?,
                    description=?,
                    assigned_to=?,
                    due_date=?
                WHERE task_id=?
                AND assigned_by=?";


        $stmt = $conn->prepare($sql);


        $result = $stmt->execute([
            $title,
            $description,
            $assigned_to,
            $due_date,
            $task_id,
            $manager_id
        ]);


        return $result;

    }





    function deleteTask($conn, $task_id, $manager_id)
    {

        $sql = "DELETE FROM tasks
                WHERE task_id=?
                AND assigned_by=?";


        $stmt = $conn->prepare($sql);


        $result = $stmt->execute([
            $task_id,
            $manager_id
        ]);


        return $result;

    }



}

?>