<?php

class Database
{

    function connect()
    {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "taskflow_db";


        try
        {

            $conn = new PDO(
                "mysql:host=$servername;dbname=$dbname",
                $username,
                $password
            );


            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );


            return $conn;


        }
        catch(PDOException $e)
        {

            echo "Database Connection Failed: " . $e->getMessage();
            exit;

        }

    }

}

?>
