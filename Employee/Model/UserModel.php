<?php

class UserModel
{

    function getUserById($conn, $id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    // employees can edit their full name, but not their username or role
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
