<h2>My Parking History</h2>
<h4>The list of all the parking locations you have checked out in the past.</h4>

<?php

include("Class.php");
$obj = new Parking();

$userId = $_SESSION['userId'];

// get checkout data 
$pastIns = $obj->getCheckouts($userId);

if (!empty($pastIns)) {

    // get checkedout parking data 
    $pastParkings = $obj->getPastParkings($pastIns);

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Parking ID</th>";
    echo "<th>Location</th>";
    echo "<th>Description</th>";
    echo "<th>Total Cost</th>";
    echo "<th>Check-in Time</th>";
    echo "<th>Check-out Time</th>";
    echo "</tr>";

    foreach ($pastParkings as $parking) {
        echo "<tr>";
        echo "<td align='center'>" . $parking['parking_id'] . "</td>";
        echo "<td>" . $parking['location'] . "</td>";
        echo "<td>" . $parking['description'] . "</td>";
        echo "<td align='center'>$" . $parking['cost'] . "</td>";
        echo "<td>" . $parking['checkin_date_time'] . "</td>";
        echo "<td>" . $parking['checkout_date_time'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    // if no checkout, no table is shown.
} else {
    echo "<p>You haven't checked out from any parking locations yet.</p>";
}

?>