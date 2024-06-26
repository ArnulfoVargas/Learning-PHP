<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://unpkg.com/htmx.org@1.9.11"></script>
    <title>PHP Course</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <label for="user">Username:</label><br>
        <input type="text" name="user"> <br>
        <label for="password">Password:</label> <br>
        <input type="password" name="password" /><br>
        <input type="submit" name="login" value="Log In">
    </form>

    <?php
        include("db.php");

        if (isset($db->err)) {
            echo "Couldnt Connect to DB <br>";
        } else {
            echo "Connection Succesfully <br>";
        }
    ?>

    <button hx-post="/htmx" hx-trigger="click" hx-targer="#target" hx-swap="innerHTML">Check</button>
    <div id="target">

    </div>

    <script>
        // Prevents form resubmitions on refresh
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>

<?php 
    $user = filter_input(INPUT_POST,"user", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = isset($_POST["password"]) 
                    ? $_POST["password"] 
                    : "";
    $can_store = true;

    if (isset($_POST["login"])) {
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
        }
    }
?>

<?php 
$route = $_SERVER['REQUEST_URI'];
ob_start();
    if (isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER('HTTP_HX_REQUEST') == true) {
        switch ($route) {
            case '/htmx':
                echo'Hello';
                break;
        }
    }

    ob_clean();
?>

<?php 
    $db->close_db();
?>