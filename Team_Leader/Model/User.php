<?php

class User
{

    function getUserById($conn, $id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    function updateFullName($conn, $id, $full_name)
    {
        $sql = "UPDATE users SET full_name = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$full_name, $id]);
    }


    function updatePassword($conn, $id, $newPassword)
    {
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$newPassword, $id]);
    }

}

?>
