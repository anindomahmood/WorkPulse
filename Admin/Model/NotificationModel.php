<?php

class NotificationModel
{

    function getAllNotifications($conn)
    {
        $sql = "SELECT n.*, u.full_name AS recipient_name
                FROM notifications n
                LEFT JOIN users u ON u.user_id = n.recipient_id
                ORDER BY n.notification_id DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function countUnread($conn)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM notifications WHERE is_read = 0");
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    function addNotification($conn, $message, $recipient_id, $type)
    {
        $sql = "INSERT INTO notifications (message, recipient_id, type, is_read)
                VALUES (?, ?, ?, 0)";

        $stmt = $conn->prepare($sql);
        return $stmt->execute([$message, $recipient_id, $type]);
    }


    function markAsRead($conn, $id)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id]);
    }

}

?>
