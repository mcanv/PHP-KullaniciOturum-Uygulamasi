<?php

require_once __DIR__ . '/core/db.php';

if(isset($_SESSION['id'])) {
    $authenticated_user_query = $db->prepare("SELECT * FROM users WHERE id = :id");
    $authenticated_user_query->bindParam(":id", $_SESSION['id']);
    $authenticated_user_query->execute();
    $auth = $authenticated_user_query->fetch(PDO::FETCH_OBJ);

    if($auth == null) {
        header("Location: logout.php");
    }

    if($auth->is_admin == 0) {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

?>

<h3>Admin Panel</h3>