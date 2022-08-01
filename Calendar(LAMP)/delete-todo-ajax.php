<?php

    require 'database.php';

    session_start();


if (!$_SESSION['user-logged-in']) {

    echo json_encode(array(
        "success" => false,
        "user_logged_in" => false
    ));
    session_destroy();
    exit;
}

if(!hash_equals($_SESSION['token'], $_POST['token'])){
    echo json_encode(array(
        "success" => false,
        "user_logged_in" => false
    ));
    die("Request forgery detected");
}

if (isset($_POST['dateFormatted'])) {


        $stmt = $mysqli->prepare("delete from events where todo='checked' and date=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }        
        $stmt->bind_param('s', $_POST['dateFormatted']);
        
        $stmt->execute();
        
        $stmt->close();
    
        echo json_encode(array(
            "success" => true,
            "user_logged_in" => true
        ));


    }
    else {
        echo "cannot execute insert query";
    }
?>