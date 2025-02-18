<?php
session_start();

include("Class.php");
$userObj = new User();
$parkingObj = new Parking();

?>
<html>

<head>
    <title>Admin Checkout</title>
</head>

<body>
    <?php
    if (isset($_SESSION['userId'])) {
    ?>
        <header>
            <?php
            include("admin_header.php");
            ?>
        </header>

        <div class="container">
            <h2>Parking List This User is Currently Using</h2>

        <?php
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            // get user info
            $user_info = $userObj->getUser($userId);
            $userName = $user_info['name'] . " " . $user_info['surname'];

            echo "<p>Select the location to check the user \"<strong>" . $userName . "</strong>\" out from.</p>";

            // get active checkin data
            $currIns = $parkingObj->getCheckins($userId);

            if (!empty($currIns)) {

                // get the user's currently using parking data
                $currParkings = $parkingObj->getCurrentParkings($currIns);

                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Parking ID</th>";
                echo "<th>Location</th>";
                echo "<th>Description</th>";
                echo "<th>Hourly Price</th>";
                echo "<th>Check-in Time</th>";
                echo "<th>Action</th>";
                echo "</tr>";

                foreach ($currParkings as $parking) {
                    echo "<tr>";
                    echo "<td align='center'>" . $parking['parking_id'] . "</td>";
                    echo "<td>" . $parking['location'] . "</td>";
                    echo "<td>" . $parking['description'] . "</td>";
                    echo "<td align='center'>$" . $parking['cost_per_hour'] . "</td>";

                    echo "<td>" . $parking['checkin_date_time'] . "</td>";

                    echo "<td align='center'><a href='check_out.php?id=" . $parking['history_id'] . "&uid=" . $userId . "&type=admin'>Check Out</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                // if the user is not using any parking, no table is shown.
            } else {
                echo "<p>This user curently has't checked-in any parkings.</p>";
            }
            echo "<p><a href='admin.php?content=User+List' class='custom-button'>Go Back</a></p>";
        }
    } else {
        echo "<p>User not found.</p>";
        echo "<p><a href='index.php'>Login Page</a></p>";
    } ?>
        </div>
</body>

</html>