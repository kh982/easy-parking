<?php
session_start();

?>
<html>

<head>
    <title>User main page</title>
</head>

<body>
    <header>
        <?php
        if (isset($_SESSION['userId'])) {
            include("user_header.php");

        ?>
    </header>
    <div class="container">
    <?php
            switch ($_GET['content']) {
                case ("Available Parking"):
                    include("parking_available.php");
                    break;
                case ("My Parking History"):
                    include("parking_history.php");
                    break;
                case ("Current Parking"):
                    include("parking_current.php");
                    break;
                case ("Search Location"):
                    include("search.php");
                    break;

                default:
                    include("parking_available.php");
            }
        } else {
            echo "<p>User not found.</p>";
            echo "<p><a href='index.php'>Login Page</a></p>";
        }
    ?>
    </div>

</body>

</html>