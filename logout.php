<?php
session_start();
?>
<html>

<head>
    <link rel="stylesheet" href="styles.css">
    <title>Logout</title>
</head>

<body>

    <?php
    if (isset($_POST['confirm'])) {

        // if user comfirms the logout
        session_destroy();
        echo "<div align='center' class='container'>";
        echo "<h4>You have been successfully logged out.</h4>";
        echo "<br /><br />";
        echo "<p><a href='index.php' class='custom-button'>Back to Login</a></p>";
    } else {

        if (isset($_SESSION['userId'])) {

            $type = $_GET['type'];

            // display the message asking for confirmation
    ?>
            <div class="container" align="center">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h4>Are you sure you want to log out?</h4><br /><br />
                    <input type="submit" name="confirm" value="Confirm" class="custom-button" />
                    <?php
                    if ($type == "user") {
                        echo "<a href='user.php?content=Available+Parking' class='custom-button'>Go Back</a>";
                    } else {
                        echo "<a href='admin.php?content=All+Parking' class='custom-button'>Go Back</a>";
                    }
                    ?>
                </form>
            </div>
    <?php
            // if user is not logged in
        } else {
            echo "<div align='center' class='container'>";
            echo "<h4>User not found.</h4>";
            echo "<br /><br />";
            echo "<p><a href='index.php' class='custom-button'>Back to Login</a></p>";
        }
    }
    ?>


</body>

</html>