<?php

class UserModel
{

    // ---- READ ----

    function getAllUsers($conn)
    {
        $sql = "SELECT * FROM users ORDER BY user_id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    function getUserById($conn, $id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    function countUsers($conn)
    {
        $sql = "SELECT COUNT(*) AS total FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()["total"];
    }


    function checkUsernameExists($conn, $username, $excludeUserId = null)
    {
        if($excludeUserId)
        {
            $sql = "SELECT * FROM users WHERE username = ? AND user_id != ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $excludeUserId]);
        }
        else
        {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
        }

        return $stmt->fetch();
    }


    // ---- WRITE ----

    function addUser($conn, $full_name, $username, $password, $role)
    {
        $sql = "INSERT INTO users
                (full_name, username, password, role)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            $full_name,
            $username,
            $password,
            $role
        ]);
    }


    function updateUser($conn, $id, $full_name, $username, $role)
    {
        $sql = "UPDATE users
                SET full_name = ?, username = ?, role = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            $full_name,
            $username,
            $role,
            $id
        ]);
    }


    function updatePassword($conn, $id, $newPassword)
    {
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$newPassword, $id]);
    }


    function updateProfile($conn, $id, $full_name, $username)
    {
        $sql = "UPDATE users SET full_name = ?, username = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$full_name, $username, $id]);
    }


    function deleteUser($conn, $id)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$id]);
    }

}

?>
