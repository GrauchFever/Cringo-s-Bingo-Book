<?php
    session_start();
    header('Content-Type: application/json');
    
    $response = ['isAdmin' => false];
    
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
        $response['isAdmin'] = true;
    }
    
    echo json_encode($response);
?>