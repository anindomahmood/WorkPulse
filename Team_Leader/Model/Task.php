<?php

class Task
{

    // ---- Tasks assigned TO this team leader BY a manager ("View Manager Assigned Tasks") ----

    function getAssignedTasks($conn, $team_leader_id)
    {
        $sql = "SELECT t.*, m.full_name AS manager_name,
                       (SELECT COUNT(*) FROM tasks s WHERE s.parent_task_id = t.task_id) AS subtask_count
                FROM tasks t
                LEFT JOIN users m ON m.user_id = t.assigned_by
                WHERE t.assigned_to = ?
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetchAll();
    }


    // ownership-checked fetch of a manager-assigned task (used before creating a subtask under it)
    function getAssignedTaskById($conn, $task_id, $team_leader_id)
    {
        $sql = "SELECT t.*, m.full_name AS manager_name
                FROM tasks t
                LEFT JOIN users m ON m.user_id = t.assigned_by
                WHERE t.task_id = ? AND t.assigned_to = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$task_id, $team_leader_id]);
        return $stmt->fetch();
    }


    function countAssignedTasks($conn, $team_leader_id)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ?");
        $stmt->execute([$team_leader_id]);
        return $stmt->fetch()["total"];
    }


    // ---- Employees under this team leader ----

    function getEmployees($conn)
    {
        $sql = "SELECT * FROM users WHERE role = 'employee'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function countEmployees($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role='employee'");
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    // ---- Subtasks this team leader creates for employees ("Assign Tasks to Employees") ----

    function createSubtask($conn, $title, $description, $assigned_by, $assigned_to, $parent_task_id, $due_date)
    {
        $sql = "INSERT INTO tasks
                (title, description, assigned_by, assigned_to, parent_task_id, due_date)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $result = $stmt->execute([
            $title,
            $description,
            $assigned_by,
            $assigned_to,
            $parent_task_id,
            $due_date ?: null
        ]);

        return $result ? $conn->lastInsertId() : false;
    }


    // ---- Monitor Employee Progress: subtasks this team leader assigned out ----

    function getMySubtasks($conn, $team_leader_id)
    {
        $sql = "SELECT t.*, e.full_name AS employee_name, p.title AS parent_title
                FROM tasks t
                LEFT JOIN users e ON e.user_id = t.assigned_to
                LEFT JOIN tasks p ON p.task_id = t.parent_task_id
                WHERE t.assigned_by = ?
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetchAll();
    }


    function getMySubtasksDueToday($conn, $team_leader_id)
    {
        $sql = "SELECT t.*, e.full_name AS employee_name, p.title AS parent_title
                FROM tasks t
                LEFT JOIN users e ON e.user_id = t.assigned_to
                LEFT JOIN tasks p ON p.task_id = t.parent_task_id
                WHERE t.assigned_by = ? AND t.due_date = CURDATE()
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetchAll();
    }


    function getMySubtasksOverdue($conn, $team_leader_id)
    {
        $sql = "SELECT t.*, e.full_name AS employee_name, p.title AS parent_title
                FROM tasks t
                LEFT JOIN users e ON e.user_id = t.assigned_to
                LEFT JOIN tasks p ON p.task_id = t.parent_task_id
                WHERE t.assigned_by = ?
                  AND t.due_date IS NOT NULL
                  AND t.due_date < CURDATE()
                  AND t.status != 'completed'
                ORDER BY t.due_date ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetchAll();
    }


    function getMySubtasksNoDeadline($conn, $team_leader_id)
    {
        $sql = "SELECT t.*, e.full_name AS employee_name, p.title AS parent_title
                FROM tasks t
                LEFT JOIN users e ON e.user_id = t.assigned_to
                LEFT JOIN tasks p ON p.task_id = t.parent_task_id
                WHERE t.assigned_by = ? AND t.due_date IS NULL
                ORDER BY t.task_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetchAll();
    }


    // ownership-checked fetch of a subtask (for editing)
    function getSubtaskById($conn, $task_id, $team_leader_id)
    {
        $sql = "SELECT * FROM tasks WHERE task_id = ? AND assigned_by = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$task_id, $team_leader_id]);
        return $stmt->fetch();
    }


    function updateSubtask($conn, $title, $description, $assigned_to, $due_date, $task_id, $team_leader_id)
    {
        $sql = "UPDATE tasks
                SET title=?, description=?, assigned_to=?, due_date=?
                WHERE task_id=? AND assigned_by=?";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            $title,
            $description,
            $assigned_to,
            $due_date ?: null,
            $task_id,
            $team_leader_id
        ]);
    }


    function deleteSubtask($conn, $task_id, $team_leader_id)
    {
        $sql = "DELETE FROM tasks WHERE task_id=? AND assigned_by=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$task_id, $team_leader_id]);
    }


    // ---- dashboard counts (scoped to subtasks this team leader created) ----

    function countMySubtasks($conn, $team_leader_id)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_by=?");
        $stmt->execute([$team_leader_id]);
        return $stmt->fetch()["total"];
    }

    function countByStatus($conn, $team_leader_id, $status)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_by=? AND status=?");
        $stmt->execute([$team_leader_id, $status]);
        return $stmt->fetch()["total"];
    }

    function countOverdue($conn, $team_leader_id)
    {
        $sql = "SELECT COUNT(*) AS total FROM tasks
                WHERE assigned_by=? AND due_date IS NOT NULL AND due_date < CURDATE() AND status != 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetch()["total"];
    }

    function countDueToday($conn, $team_leader_id)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_by=? AND due_date = CURDATE()");
        $stmt->execute([$team_leader_id]);
        return $stmt->fetch()["total"];
    }

    function countNoDeadline($conn, $team_leader_id)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_by=? AND due_date IS NULL");
        $stmt->execute([$team_leader_id]);
        return $stmt->fetch()["total"];
    }

}

?>
