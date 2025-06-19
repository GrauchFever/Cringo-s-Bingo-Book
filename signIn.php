<?php
    ini_set('session.cookie_path', '/');
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if(empty($email) || empty($password))
        {
            die("Error: All fields required");
        }

        $host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "cringo_db";
        // Establish Connection
        $conn = mysqli_connect($host, $db_user, $db_password, $db_name);

        // Check if connection was successful
        if (!$conn)
        {
            die("Connection Failed".mysqli_connect_error());
        }

        $sql = "SELECT * FROM accounts WHERE user_email = '$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0)
        {
            $user = mysqli_fetch_assoc($result);

            if(password_verify($password, $user["user_password"]))
            {
                $_SESSION["loggedIn"] = true;
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["user_name"] = $user["user_name"];
                $_SESSION["user_surname"] = $user["user_surname"];

                header("Location: index.html");
                exit();
            }
            else
            {
                echo "Error: Incorrect password";
            }
        }
        else
        {
            echo "Error: Email not found";
        }

        mysqli_close($conn);
    }
?>