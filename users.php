<?php
    include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label for="id">Find by ID:</label>
        <input type="number" min="0" name="id">
        <input type="submit" name="find" value="Find">
    </form>

    <?php 
        if (isset($_POST["find"])) {
            $user = $db->get_user($_POST["id"]);
            unset($_POST);
            if (isset($user)) {
                echo "ID: ".$user["id"]."<br>Name:".$user["username"]."<br>";
            } else {
                echo "Invalid ID";
            }
        }
    ?>
    <br>

    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label for="id_update">Update By ID:</label>
        <input type="number" name="id_update" min="0">
        <label for="username_update">New Username:</label>
        <input type="text" name="username_update">
        <input type="submit" name="update" value="Update">
    </form>

    <?php 
        if (isset($_POST['update'])) {
            $username = filter_input(INPUT_POST,'username_update', FILTER_SANITIZE_SPECIAL_CHARS);
            
            if (!empty($username)) { 
                if ($db->update_user($_POST['id_update'], $username)) {
                    echo 'Succesfullly Updated';
                } else {
                    echo 'Unexpected Error';
                }
            } else {
                echo 'Type a username';
            }
        }
    ?>

    <br>

    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label for="id_delete">ID to Delete: </label>
        <input type="number" min="0" name="id_delete">
        <input type="submit" value="delete" name="delete">
    </form>

    <?php 
        if (isset($_POST['delete'])) {
            if ($db->delete_user($_POST['id_delete'])) {
                echo 'Succesfully Deleted';
            } else {
                echo 'Unexpected Error';
            }
        }
    ?>

    <br>
    <?php 
        $users = $db->get_users();
        foreach ($users as $user) {
            echo "ID: ". $user["id"] ."<br>Name:". $user["username"] ."<br><hr>";
        }
    ?>

    <script>
        // Prevents form resubmitions on refresh
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>

<?php 
    $db->close_db();
?>