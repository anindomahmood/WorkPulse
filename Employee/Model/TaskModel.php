<?php

class TaskModel
{

    // ---- READ (lists, scoped to one employee) ----

    function getMyTasks($conn, $employeeId)
    {
        $sql = "SELECT t.*, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.assigned_to = ?
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetchAll();
    }


    function getMyTasksDueToday($conn, $employeeId)
    {
        $sql = "SELECT t.*, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.assigned_to = ? AND t.due_date = CURDATE()
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetchAll();
    }


    function getMyTasksOverdue($conn, $employeeId)
    {
        $sql = "SELECT t.*, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.assigned_to = ?
                  AND t.due_date IS NOT NULL
                  AND t.due_date < CURDATE()
                  AND t.status != 'completed'
                ORDER BY t.due_date ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetchAll();
    }


    function getMyTasksNoDeadline($conn, $employeeId)
    {
        $sql = "SELECT t.*, ab.full_name AS assigned_by_name
                FROM tasks t
                LEFT JOIN users ab ON ab.user_id = t.assigned_by
                WHERE t.assigned_to = ? AND t.due_date IS NULL
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetchAll();
    }


    // fetch a single task but ONLY if it belongs to this employee (ownership check)
    function getMyTaskById($conn, $taskId, $employeeId)
    {
        $sql = "SELECT * FROM tasks WHERE task_id = ? AND assigned_to = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$taskId, $employeeId]);
        return $stmt->fetch();
    }


    // ---- COUNTS (dashboard) ----

    function countMyTasks($conn, $employeeId)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ?");
        $stmt->execute([$employeeId]);
        return $stmt->fetch()["total"];
    }


    function countMyByStatus($conn, $employeeId, $status)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ? AND status = ?");
        $stmt->execute([$employeeId, $status]);
        return $stmt->fetch()["total"];
    }


    function countMyDueToday($conn, $employeeId)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ? AND due_date = CURDATE()");
        $stmt->execute([$employeeId]);
        return $stmt->fetch()["total"];
    }


    function countMyOverdue($conn, $employeeId)
    {
        $sql = "SELECT COUNT(*) AS total FROM tasks
                WHERE assigned_to = ? AND due_date IS NOT NULL AND due_date < CURDATE() AND status != 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetch()["total"];
    }


    function countMyNoDeadline($conn, $employeeId)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ? AND due_date IS NULL");
        $stmt->execute([$employeeId]);
        return $stmt->fetch()["total"];
    }


    // ---- WRITE ----

    // employee may ONLY change status, and only on their own task
    function updateStatus($conn, $taskId, $employeeId, $status)
    {
        $sql = "UPDATE tasks SET status = ? WHERE task_id = ? AND assigned_to = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$status, $taskId, $employeeId]);
    }

}

?>
