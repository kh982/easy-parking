<h2>Full Parking Locations</h2>
<h4>The list of all the parking locations with <u>NO</u> available spaces.</h4>

<?php

include("Class.php");
$obj = new Parking();
// get parking data
$parkings = $obj->getParkings();
// get capacity data
$parCapacityArray =  $obj->getParkingCapacity();

$available = true;

if (!empty($parkings)) {

    foreach ($parkings as $parking) {
        $parkingId = $parking['parking_id'];
        foreach ($parCapacityArray as $parCapacity)
            if (($parCapacity['parking_space'] <= $parCapacity['count']) && $parCapacity['parking_id'] == $parkingId) {
                include_once('admin_table.php');
                echo "<tr>";
                echo "<td align='center'>" . $parking['parking_id'] . "</td>";
                echo "<td>" . $parking['location'] . "</td>";
                echo "<td>" . $parking['description'] . "</td>";
                echo "<td align='center'>" . $parking['parking_space'] - $parCapacity['count'] . " / " . $parking['parking_space'] . "</td>";
                echo "<td align='center'>$" . $parking['cost_per_hour'] . "</td>";
                echo "</tr>";
                $available = false;
            }
    }
    echo "</table>";
    // if there's no full parking, no table is shown. 
    if ($available) {
        echo "<p>Currently there is no parking locations with no spaces.</p>";
    }
    // if there's no parking registered, no table is shown.
} else {
    echo "<p>Currently there is no parking locations registered in the system.</p>";
}

?>