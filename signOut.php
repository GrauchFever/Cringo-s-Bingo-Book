<?php
    // start session
    session_start();

    // clear all session variables
    session_unset();

    // destroy session
    session_destroy();

    // redirect to login page
    header("Location: signIn.html");
    exit;
?>