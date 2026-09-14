<?php

class NotificationModel
{

    function getMyNotifications($conn, $employeeId)
    {
        $sql = "SELECT * FROM notifications WHERE recipient_id = ? ORDER BY notification_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetchAll();
    }


    function countUnread($conn, $employeeId)
    {
        $sql = "SELECT COUNT(*) AS total FROM notifications WHERE recipient_id = ? AND is_read = 0";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$employeeId]);
        return $stmt->fetch()["total"];
    }


    // used to notify the manager/leader who assigned the task when status changes
    function addNotification($conn, $message, $recipient_id, $type)
    {
        $sql = "INSERT INTO notifications (message, recipient_id, type, is_read)
                VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$message, $recipient_id, $type]);
    }


    function markAsRead($conn, $id, $employeeId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ? AND recipient_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id, $employeeId]);
    }


    function markAllAsRead($conn, $employeeId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE recipient_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$employeeId]);
    }

}

?>
