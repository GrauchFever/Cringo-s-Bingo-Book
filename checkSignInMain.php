<?php
    ini_set('session.cookie_path', '/');
    session_start();

    header('Content-Type: application/json');

    $response = [
        "loggedIn" => isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true,
        "name" => isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : null,
        "surname" => isset($_SESSION["user_surname"]) ? $_SESSION["user_surname"] : null,
        "profilePic" => "images/default-profile-picture.webp"
    ];

    echo json_encode($response);
?>