<?php

class TaskModel
{

    // ---- READ (lists) ----

    function getAllTasks($conn)
    {
        $sql = "SELECT t.*,
                       au.full_name AS assigned_to_name,
                       ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users au ON au.user_id = t.assigned_to
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function getTasksDueToday($conn)
    {
        $sql = "SELECT t.*, au.full_name AS assigned_to_name, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users au ON au.user_id = t.assigned_to
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.due_date = CURDATE()
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function getOverdueTasks($conn)
    {
        $sql = "SELECT t.*, au.full_name AS assigned_to_name, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users au ON au.user_id = t.assigned_to
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.due_date IS NOT NULL
                  AND t.due_date < CURDATE()
                  AND t.status != 'completed'
                ORDER BY t.due_date ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function getTasksNoDeadline($conn)
    {
        $sql = "SELECT t.*, au.full_name AS assigned_to_name, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users au ON au.user_id = t.assigned_to
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.due_date IS NULL
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function getTaskById($conn, $id)
    {
        $sql = "SELECT * FROM tasks WHERE task_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    function hasChildTasks($conn, $id)
    {
        $sql = "SELECT COUNT(*) AS total FROM tasks WHERE parent_task_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch()["total"] > 0;
    }


    // ---- COUNTS (dashboard / system monitoring) ----

    function countTasks($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks");
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    function countByStatus($conn, $status)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE status = ?");
        $stmt->execute([$status]);
        return $stmt->fetch()["total"];
    }


    function countDueToday($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE due_date = CURDATE()");
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    function countOverdue($conn)
    {
        $sql = "SELECT COUNT(*) AS total FROM tasks
                WHERE due_date IS NOT NULL AND due_date < CURDATE() AND status != 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    function countNoDeadline($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE due_date IS NULL");
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    // ---- WRITE ----

    function addTask($conn, $title, $description, $assigned_by, $assigned_to, $due_date, $parent_task_id = null)
    {
        $sql = "INSERT INTO tasks
                (title, description, assigned_by, assigned_to, parent_task_id, due_date)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $ok = $stmt->execute([
            $title,
            $description,
            $assigned_by,
            $assigned_to,
            $parent_task_id,
            $due_date ?: null
        ]);

        return $ok ? $conn->lastInsertId() : false;
    }


    function updateTask($conn, $id, $title, $description, $assigned_to, $due_date, $status)
    {
        $sql = "UPDATE tasks
                SET title = ?, description = ?, assigned_to = ?, due_date = ?, status = ?
                WHERE task_id = ?";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            $title,
            $description,
            $assigned_to,
            $due_date ?: null,
            $status,
            $id
        ]);
    }


    function deleteTask($conn, $id)
    {
        $sql = "DELETE FROM tasks WHERE task_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id]);
    }

}

?>
