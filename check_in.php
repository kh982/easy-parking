<?php
session_start();

include("Class.php");
$userObj = new User();
$parkingObj = new Parking();

if (isset($_GET['id'])) {
    $type = "";

    $parkingId = $_GET['id'];
    if (isset($_GET['uid'])) {
        $userId = $_GET['uid'];
    } else {
        $userId = $_SESSION['userId'];
    }
    $type = $_GET['type'];

    // get user info
    $user_info = $userObj->getUser($userId);
    // insert a new checkin entry
    $time =  $parkingObj->checkin($userId, $parkingId);
    // get parking data
    $parking = $parkingObj->getParkings($parkingId);

    $location = $parking['location'];
    $cost = $parking['cost_per_hour'];

?>
    <html>

    <head>
        <title>Checkin</title>
    </head>

    <body>
        <link rel="stylesheet" href="styles.css">

        <?php
        // desplay notification
        echo "<div align='center' class='container'>";
        echo "<h3>The check-in has been successful.</h3>";

        // if it's user 
        if ($type == "user") {
            echo "<div class='container' style='background-color:white; width:50%;'>";
            echo "<p>Thank you for parking at \"<strong>" . $location . "</strong>\".</p>";
            echo "<p>Your check-in time is <strong>" . $time . "</strong>.</p>";
            echo "<p>You will be charged <strong>$" . $cost . "</strong> per hour.</p>";
            echo "<p><a href='user.php?content=Available+Parking' class='custom-button'>Go Back</a></p>";
            echo "</div></div>";
            // if it's admin
        } else {
            echo "<div class='container' style='background-color:white; width:50%;'>";
            echo "<p>User \"<strong>" . $user_info['name'] . " " . $user_info['surname'] . "</strong>\" has been checked in \"<strong>" . $location . "</strong>\".</p>";
            echo "<p>The check-in time is <strong>" . $time . "</strong>.</p>";
            echo "<p><a href='admin.php?content=User+List' class='custom-button'>Go Back</a></p>";
            echo "</div></div>";
        }

        ?>
    </body>

    </html>
<?php
}
