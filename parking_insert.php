<?php
session_start();
include("Class.php");
$obj = new Parking();

?>
<html>

<head>
    <title>Add Parking Location</title>
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
        <?php
        if (isset($_POST['register'])) {

            echo "<div  class='container'>";

            // validation
            $errors = 0;

            if (empty($_POST['location'])) {
                ++$errors;
                echo "<p>Please enter the location name.<p>";
            } else {
                $location = stripslashes($_POST['location']);
            }


            if (empty($_POST['description'])) {
                ++$errors;
                echo "<p>Please enter the description.<p>";
            } else {
                $description = stripslashes($_POST['description']);
            }


            if (empty($_POST['space'])) {
                ++$errors;
                echo "<p>Please enter the number of parking space.<p>";
            } else {
                $space = stripslashes($_POST['space']);
                if (preg_match("/^\d{1,3}$/", $space) == 0) {
                    ++$errors;
                    echo "<p>You need to enter a 1 to 3 digit number(s).</p>";
                    $space = "";
                }
            }


            if (empty($_POST['cost'])) {
                ++$errors;
                echo "<p>Please enter the cost.<p>";
            } else {
                $cost = stripslashes($_POST['cost']);
                if (preg_match("/^\d{1,3}(?:\.\d{0,2})?$/", $cost) == 0) {
                    ++$errors;
                    echo "<p>You need to enter valid numbers.</p>";
                    $cost = "";
                } else {
                    $cost = number_format($cost, 2);
                }
            }

            // if passed the validation
            if ($errors == 0) {

                echo "<h2>Confirmation of registraion</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Location</th><td>" . $location . "</td></tr>";
                echo "<tr><th>Description</th><td>" . $description . "</td></tr>";
                echo "<tr><th>Parking Space</th><td>" . $space . "</td></tr>";
                echo "<tr><th>Cost per hour ($)</th><td>" . $cost . "</td></tr>";
                echo "</table>";


                echo "<br />";
                echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='POST'>";
                echo "<input type='hidden' name='location' value='" . $location . "' />";
                echo "<input type='hidden' name='description' value='" . $description . "' />";
                echo "<input type='hidden' name='space' value='" . $space . "' />";
                echo "<input type='hidden' name='cost' value='" . $cost . "' />";

                echo "<input type='submit' name='confirm' value='Confirm' class='custom-button' />";
                echo "<a href='parking_insert.php' class='custom-button'>Cancel</a>";
                echo "</form>";

                // if didn't pass the validation
            } else {
                echo "<p>Please go back to the previous page, using your browser's BACK button.</p>";
                echo "</div>";
                ++$errors;
            }
        } elseif (isset($_POST['confirm'])) {

            $location = $_POST['location'];
            $description = $_POST['description'];
            $space = $_POST['space'];
            $cost = $_POST['cost'];

            // insert new parking info
            $result = $obj->registerParking($location, $description, $space, $cost);

            // display the message
            echo "<div align='center' class='container'>";
            echo "<p>The new location \"<strong>" . $location . "\"</strong>' has been successfully added to the list.</p>";
            echo "<br /><br />";
            echo "<p><a href='admin.php?content=All+Parking' class='custom-button' style='width:200px;'>Go Back to Parking List</a></p>";
            echo "</div>";
        } else {

            // new parkin gregistration form
        ?>
            <div class="container">
                <h2>Parking Registration</h2>
                <div class="container">
                    <form class="login-form" style="width:90%;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        Parking Location: <br />
                        <input type="text" name="location" /><br />
                        Description: <br />
                        <textarea name="description" cols="50"></textarea><br /><br />
                        The number of parking spaces: <em>(Enter digit number(s))</em><br />
                        <input type="number" name="space" /><br /><br />
                        Cost per hour ($): <br />
                        <input type="float" name="cost" /><br /><br />

                        <input type="submit" name="register" value="Register" class="custom-button" />
                        <input type="reset" value="Clear form" class="custom-button" />

                    </form>
                </div>

                <p><a href="admin.php?content=All+Parking" class="custom-button">Go Back</a></p>
            </div>
    <?php }
    } else {
        echo "<p>User not found.</p>";
        echo "<p><a href='index.php'>Login Page</a></p>";
    } ?>
</body>

</html>