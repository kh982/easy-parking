<h2>All Parking Locations</h2>
<h4>The list of all the parking locations.</h4>
<a href='parking_insert.php' class='custom-button' style='width:150px;'>Add New Location</a>
<?php

include("Class.php");
$obj = new Parking();

// get parking data
$parkings = $obj->getParkings();
// get capacity data
$parCapacityArray = $obj->getParkingCapacity();

if (!empty($parkings)) {
    echo "<table border='1'";
    echo "<tr>";
    echo "<th>Parking ID</th>";
    echo "<th>Location</th>";
    echo "<th>Description</th>";
    echo "<th>Availability</th>";
    echo "<th>Hourly Price</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    foreach ($parkings as $parking) {
        $parkingId = $parking['parking_id'];
        foreach ($parCapacityArray as $parCapacity)
            if ($parCapacity['parking_id'] == $parkingId) {

                echo "<tr>";
                echo "<td align='center'>" . $parking['parking_id'] . "</td>";
                echo "<td>" . $parking['location'] . "</td>";
                echo "<td>" . $parking['description'] . "</td>";
                echo "<td align='center'>" . $parking['parking_space'] - $parCapacity['count'] . " / " . $parking['parking_space'] . "</td>";
                echo "<td align='center'>$" . $parking['cost_per_hour'] . "</td>";
                echo "<td align='center'><a href='parking_edit.php?id=" . $parking['parking_id'] . "'>Edit</a>" . "&nbsp;&nbsp;<a href='admin_checkedin_list.php?id=" . $parking['parking_id'] . "'>Current Users</a></td>";
                echo "</tr>";
            }
    }
    echo "</table>";
    // if there's no parking registered, no table is shown.
} else {
    echo "<p>Currently there is no parking locations registered in the system.</p>";
}

?>