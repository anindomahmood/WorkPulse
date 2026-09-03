<?php

class User
{

    function register($conn, $full_name, $username, $password, $role)
    {

        $sql = "INSERT INTO users
                (full_name, username, password, role)
                VALUES
                (?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);


        $result = $stmt->execute([
            $full_name,
            $username,
            $password,
            $role
        ]);


        return $result;

    }


    function login($conn, $username, $password)
{

    $sql = "SELECT * FROM users 
            WHERE username = ?
            AND password = ?";


    $stmt = $conn->prepare($sql);


    $stmt->execute([
        $username,
        $password
    ]);


    $user = $stmt->fetch();


    return $user;

}


}

?>