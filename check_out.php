<?php
session_start();

include("Class.php");
$userObj = new User();
$parkingObj = new Parking();

if (isset($_GET['id'])) {
    $type = "";

    $historyId = $_GET['id'];
    $type = $_GET['type'];

    if (isset($_GET['uid'])) {
        $userId = $_GET['uid'];
    } else {
        $userId = $_SESSION['userId'];
    }

    // get check in data
    $history_info = $parkingObj->getPastParking($historyId);

    $parkingId = $history_info['parking_id'];
    $checkinTime = $history_info['checkin_date_time'];

    // get parking data
    $parking = $parkingObj->getParkings($parkingId);

    $location = $parking['location'];
    $cost = $parking['cost_per_hour'];


    if (isset($_GET['uid'])) {
        $userId = $_GET['uid'];

        // get user info
        $user_info = $userObj->getUser($userId);
    }

    // checkout and get total cost
    $totalCost = $parkingObj->checkout($historyId, $checkinTime, $cost);


?>
    <html>

    <head>
        <title>Checkout</title>
    </head>

    <body>
        <link rel="stylesheet" href="styles.css">

        <?php
        // display notification
        echo "<div align='center' class='container'>";
        echo "<h3>The check-out has been successful.</h3>";

        // if it's user
        if ($type == "user") {

            echo "<div class='container' style='background-color:white; width:50%;'>";
            echo "<p>Thank you for using \"<strong>" . $location . "</strong>\".</p>";
            echo "<p>You will be charged <strong>$" . number_format($totalCost, 2) . "</strong>.</p>";

            echo "<p><a href='user.php?content=Current+Parking' class='custom-button'>Go Back</a></p>";
            echo "</div></div>";
            // if it's admin
        } else {
            echo "<div class='container' style='background-color:white; width:50%;'>";
            echo "<p>User \"<strong>" . $user_info['name'] . " " . $user_info['surname'] . "\" </strong>has been successfully checked out from \"<strong>" . $location . "</strong>\".</p>";
            echo "<p>The user will be charged <strong>$" . number_format($totalCost, 2) . "</strong>.</p>";
            echo "<p><a href='admin.php?content=User+List' class='custom-button'>Go Back</a></p>";
            echo "</div></div>";
        }

        ?>
    </body>

    </html>
<?php
}
