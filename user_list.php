<h2>User List</h2>
<h4>The list of all Users.</h4>

<?php
include("Class.php");
$obj = new User();
// get user data
$users = $obj->getUser();

if (!empty($users)) {

    echo "<table border='1'";
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>User Name</th>";
    echo "<th>User Phone</th>";
    echo "<th>User Email</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    foreach ($users as $user) {

        echo "<tr>";
        echo "<td align='center'>" . $user['user_id'] . "</td>";
        echo "<td>" . $user['name'] . " " . $user['surname'] . "</td>";
        echo "<td align='center'>" . $user['phone'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td align='center'><a href='admin_checkin.php?id=" . $user['user_id'] . "'>Check In</a>" . "&nbsp;&nbsp;&nbsp;<a href='admin_checkout.php?id=" . $user['user_id'] . "'>Check Out</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    // if there's no user registered. no table is shonw.
} else {
    echo "<p>Currently there is no users registered in the system.</p>";
}

?>