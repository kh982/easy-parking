<?php
session_start();

?>
<html>

<head>
    <title>Admin main page</title>
</head>

<body>
    <header>
        <?php
        if (isset($_SESSION['userId'])) {
            include("admin_header.php");

        ?>
    </header>
    <div class="container">

    <?php
            switch ($_GET['content']) {
                case ("All Parking"):
                    include("parking_list.php");
                    break;

                case ("Available Parking"):
                    include("admin_available.php");
                    break;

                case ("Full Parking"):
                    include("admin_full.php");
                    break;

                case ("User List"):
                    include("user_list.php");
                    break;

                case ("Search Location"):
                    include("search.php");
                    break;


                default:
                    include("parking_list.php");
            }
        } else {
            echo "<p>User not found.</p>";
            echo "<p><a href='index.php'>Login Page</a></p>";
        }

    ?>
    </div>

</body>

</html>