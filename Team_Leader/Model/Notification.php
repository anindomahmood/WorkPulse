<?php

class Notification
{

    function getMyNotifications($conn, $team_leader_id)
    {
        $sql = "SELECT * FROM notifications WHERE recipient_id=? ORDER BY notification_id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetchAll();
    }


    function countUnread($conn, $team_leader_id)
    {
        $sql = "SELECT COUNT(*) AS total FROM notifications WHERE recipient_id=? AND is_read=0";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$team_leader_id]);
        return $stmt->fetch()["total"];
    }


    function addNotification($conn, $message, $recipient_id, $type)
    {
        $sql = "INSERT INTO notifications (message, recipient_id, type, is_read)
                VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$message, $recipient_id, $type]);
    }


    function markAllAsRead($conn, $team_leader_id)
    {
        $sql = "UPDATE notifications SET is_read=1 WHERE recipient_id=?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$team_leader_id]);
    }

}

?>
