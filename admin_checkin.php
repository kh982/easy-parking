<?php
session_start();

include("Class.php");
$userObj = new User();
$parkingObj = new Parking();

?>
<html>

<head>
    <title>Admin Checkin</title>
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
            <h2>Available Parking Locations</h2>

        <?php
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            // get user info
            $user_info = $userObj->getUser($userId);
            $userName = $user_info['name'] . " " . $user_info['surname'];

            echo "<p>Select the location to check the user \"<strong>" . $userName . "</strong>\" in.</p>";

            // get parking data
            $parkings = $parkingObj->getParkings();
            // get capacity data
            $parCapacityArray =  $parkingObj->getParkingCapacity();

            $available = false;

            if (!empty($parkings)) {

                foreach ($parkings as $parking) {
                    $parkingId = $parking['parking_id'];
                    foreach ($parCapacityArray as $parCapacity)
                        if (($parCapacity['parking_space'] > $parCapacity['count']) && $parCapacity['parking_id'] == $parkingId) {
                            echo "<tr>";
                            include_once("user_table.php");
                            echo "<td align='center'>" . $parking['parking_id'] . "</td>";
                            echo "<td>" . $parking['location'] . "</td>";
                            echo "<td>" . $parking['description'] . "</td>";
                            echo "<td align='center'>" . $parking['parking_space'] - $parCapacity['count'] . " / " . $parking['parking_space'] . "</td>";
                            echo "<td align='center'>$" . $parking['cost_per_hour'] . "</td>";
                            echo "<td align='center'><a href='check_in.php?id=" . $parking['parking_id'] . "&uid=" . $userId . "&type=admin' >Check In</a></td>";
                            echo "</tr>";
                            $available = true;
                        }
                }
                echo "</table>";

                // if there's no parking available, no table is shown
                if (!$available) {
                    echo "<p>Currently there is no parking locations availabe. Please come back later.</p>";
                }
                // if there's no parking registered, no table is shown
            } else {
                echo "<p>Currently there is no parking locations registered in the system.</p>";
            }
            echo "<p><a href='admin.php?content=User+List' class='custom-button'>Go Back</a></p>";
        }
    } else {
        echo "<p>User not found.</p>";
        echo "<p><a href='index.php'>Login Page</a></p>";
    }
        ?>
        </div>
</body>

</html>