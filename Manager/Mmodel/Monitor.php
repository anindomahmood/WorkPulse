
<?php

class Monitor
{

    function countTotalTasks($conn, $manager_id)
    {

        $sql = "SELECT COUNT(*) FROM tasks 
                WHERE assigned_by=?";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        return $stmt->fetchColumn();

    }



    function countPendingTasks($conn, $manager_id)
    {

        $sql = "SELECT COUNT(*) FROM tasks 
                WHERE assigned_by=?
                AND status='pending'";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        return $stmt->fetchColumn();

    }



    function countInProgressTasks($conn, $manager_id)
    {

        $sql = "SELECT COUNT(*) FROM tasks 
                WHERE assigned_by=?
                AND status='in_progress'";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        return $stmt->fetchColumn();

    }



    function countCompletedTasks($conn, $manager_id)
    {

        $sql = "SELECT COUNT(*) FROM tasks 
                WHERE assigned_by=?
                AND status='completed'";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        return $stmt->fetchColumn();

    }



    function countOverdueTasks($conn, $manager_id)
    {

        $sql = "SELECT COUNT(*) FROM tasks
                WHERE assigned_by=?
                AND due_date < CURDATE()
                AND status!='completed'";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        return $stmt->fetchColumn();

    }



    function countDueTodayTasks($conn, $manager_id)
    {

        $sql = "SELECT COUNT(*) FROM tasks
                WHERE assigned_by=?
                AND due_date = CURDATE()";


        $stmt = $conn->prepare($sql);


        $stmt->execute([
            $manager_id
        ]);


        return $stmt->fetchColumn();

    }


}

?>