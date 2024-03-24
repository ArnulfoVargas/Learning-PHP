<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>PHP Course</title>
</head>
<body>
    <form action="index.php" method="post">
        <label for="user">Username:</label><br>
        <input type="text" name="user"> <br>
        <label for="password">Password:</label> <br>
        <input type="password" name="password" /><br>
        <input type="submit" value="Log In">
    </form>

    <?php
        include("db.php");

        $db = new DB();
        if (isset($db->err)) {
            echo "Couldnt Connect to DB <br>";
        } else {
            echo "Connection Succesfully <br>";
        }
    ?>
</body>
</html>

<?php 
    $user = filter_input(INPUT_POST,"user", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = isset($_POST["password"]) 
                    ? $_POST["password"] 
                    : "";
    $can_store = true;

    if (empty($user)) {
        echo "<p>Type a valid Username</p>";
        $can_store = false;
    }
    if (empty($password) || strlen($password) <= 0) {
        echo "<p>Type a valid Password</p>";
        $can_store = false;
    }

    if ($can_store) {
        $db->insert_user($user, $password);
        if (empty($db->err)) {
            echo "Unexpected Error";
        }

        header("Location: index.php");
    }
?>