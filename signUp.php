<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $name = trim($_POST["name"]);
        $surname = trim($_POST["surname"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $password = trim($_POST["password"]);

        if (empty($name) || empty($surname) || empty($email) || empty($phone) || empty($password))
        {
            die("Error: All fields required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            die("Error: Invalid Email");
        }

        if (!preg_match('/^\d{10,}$/', $phone))
        {
            die("Error: Invalid phone number format");
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

        // Since names and surnames are common, check if email already exists in database
        $sql = "SELECT * FROM accounts WHERE user_email = '$email'";
        $check = mysqli_query($conn, $sql);

        if (mysqli_num_rows($check) > 0)
        {
            die("Error: email already exists");
        }

        // Hashing password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $sql = "INSERT INTO accounts (user_name, user_surname, user_email, user_phone, user_password) VALUES ('$name', '$surname', '$email', '$phone', '$hash')";

        if (mysqli_query($conn, $sql))
        {
            header("Location: signIn.html");
            exit;
        }
        else
        {
            echo "Error: ".mysqli_error($conn);
        }

        // Close Connection
        mysqli_close($conn);
    }
?>