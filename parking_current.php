<h2>Current Parking Locations</h2>
<h4>The list of all the parking locations you're using.</h4>
<h4>Select "Check Out" when you're leaving a location.</h4>

<?php

include("Class.php");
$obj = new Parking();

$userId = $_SESSION['userId'];

// get active checkin data
$currIns = $obj->getCheckins($userId);

if (!empty($currIns)) {

    // get parking info currently using 
    $currParkings = $obj->getCurrentParkings($currIns);

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
        echo "<td align='center'><a href='check_out.php?id=" . $parking['history_id'] . "&type=user'>Check Out</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    // if no parking is used, no table is shown.
} else {
    echo "<p>You are not using any parking location at the moment.</p>";
}
?>