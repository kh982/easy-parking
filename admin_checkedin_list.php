<?php
session_start();

include("Class.php");
$userObj = new User();
$parkingObj = new Parking();

?>
<html>

<head>
    <title>Cheched in user list</title>
</head>

<body>
    <?php

    if (isset($_SESSION['userId'])) {

        $userId = $_SESSION['userId'];

        if (isset($_GET['id'])) {

            $parkingId = $_GET['id'];
            // get parking data
            $parking = $parkingObj->getParkings($parkingId);
            // get user data
            $users = $userObj->getUser();
            // get checked-in users data
            $checkinList = $parkingObj->getCheckedinUsers($parkingId, $users);
        }
    ?>
        <header>
            <?php
            include("admin_header.php");
            ?>
        </header>
        <div class="container">
            <h2>User List for "<?php echo $parking['location']; ?>"</h2>
            <h4>The list of users who are currently using this location.</h4>

            <?php
            if (!empty($checkinList)) {
            ?>

                <table border="1">
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Phone</th>
                        <th>User Email</th>

                    </tr>
                    <?php

                    foreach ($checkinList as $checkin) {

                        echo "<tr>";
                        echo "<td align='center'>" . $checkin['user_id'] .  "</td>";
                        echo "<td>" . $checkin['name'] . " " . $checkin['surname']  . "</td>";
                        echo "<td align='center'>" . $checkin['phone'] .  "</td>";
                        echo "<td>" . $checkin['email'] .  "</td>";
                        echo "</tr>";
                    }

                    ?>

                </table>
            <?php } else {
                // if no one has been checked in 
                echo "<p>Currently no one has checked in this parking.</p>";
            } ?>
            <p><a href="admin.php?content=All+Parking" class="custom-button">Go Back</a></p>
        <?php
    } else {
        echo "<p>User not found.</p>";
        echo "<p><a href='index.php'>Login Page</a></p>";
    } ?>
</body>

</html>