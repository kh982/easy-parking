<?php

include("Class.php");
$obj = new Parking();

$type = $_SESSION['type'];

// if reset button is selected
if (isset($_POST['reset'])) {
    $searchId = "";
    $searchName = "";
    $searchDescription = "";
}

// if search button is selented
if (isset($_POST['search'])) {

    $searchId = $_POST['id'];
    $searchName = $_POST['name'];
    $searchDescription = $_POST['description'];

    // if fields are not empty, create sql string for seach function, using %%
    $id = ($searchId !== "") ? "%" . $searchId . "%" : "";
    $name = ($searchName !== "") ? "%" . $searchName . "%" : "";
    $description = ($searchDescription !== "") ? "%" . $searchDescription . "%" : "";

    $resultFound = false;
    $noFill = false;

    // send sql strings to the function
    $parkings = $obj->searchParkings($id, $name, $description);

    // if nothing matches
    if (!empty($parkings)) {
        $resultFound = true;
    }

    // fields are left empty by the user
    if (($id == '') && ($name == '') && ($description == '')) {
        $noFill = true;
    }

    // get capacity data
    $parCapacityArray = $obj->getParkingCapacity();
}

// search form
?>

<h2>Search Parking Locations</h2>
<h4>You can search for parking locations with parking ID and/or keywords.</h4>
<h4>Fill in the space and select "Search" to show the result.</h4>

<form action="<?php echo ($type == "user") ? "user.php" : "admin.php"; ?>?content=Search+Location" method="POST">
    <table>
        <tr>
            <th>
                Location ID:
            </th>
            <td>
                <input style="width:100%;" type="text" name="id" value="<?php echo (!empty($searchId)) ? $searchId : ""; ?>" />
            </td>
        </tr>
        <tr>
            <th>
                Location Name:
            </th>
            <td>
                <input style="width:100%;" type="text" name="name" value="<?php echo (!empty($searchName)) ? $searchName : ""; ?>" />
            </td>
        </tr>
        <tr>
            <th>
                Location Description:
            </th>
            <td>
                <input style="width:100%;" type="text" name="description" value="<?php echo (!empty($searchDescription)) ? $searchDescription : ""; ?>" />
            </td>
        </tr>
    </table>
    <br />
    <input type="submit" name="search" value="Search" class="custom-button" />
    <input type="submit" name="reset" value="Reset" class="custom-button" />

</form>
<?php


if (isset($_POST['search'])) {

    // if user didn't type anything 
    if ($noFill) {
        echo "<p>Please fill out at least one area.</p>";

        // if something matched
    } elseif ($resultFound) {
        echo "<table border='1'";
        echo "<tr>";
        echo "<th>Parking ID</th>";
        echo "<th>Location</th>";
        echo "<th>Description</th>";
        echo "<th>Availability</th>";
        echo "<th>Hourly Price</th>";
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
                    echo "</tr>";
                }
        }
        // if there's no match
    } else {
        echo "<p>No matching results. Please try different keywords.</p>";
    }
}
