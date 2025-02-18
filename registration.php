<?php
session_start();
include("Class.php");
$obj = new User();

?>
<html>

<head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    if (isset($_POST['register'])) {

        echo "<div align='center' class='container'>";

        // validation
        $errors = 0;

        if (empty($_POST['firstname'])) {
            ++$errors;
            echo "<p>Please enter your first name.<p>";
        } else {
            $name = stripslashes($_POST['firstname']);
        }


        if (empty($_POST['lastname'])) {
            ++$errors;
            echo "<p>Please enter your last name.<p>";
        } else {
            $surname = stripslashes($_POST['lastname']);
        }


        if (empty($_POST['phone'])) {
            ++$errors;
            echo "<p>Please enter your phone number.<p>";
        } else {
            $phone = stripslashes($_POST['phone']);
            if (preg_match("/^04\d{8}$/", $phone) == 0) {
                ++$errors;
                echo "<p>You need to enter a valid Australian mobile number.</p>";
                $phone = "";
            }
        }


        if (empty($_POST['email'])) {
            ++$errors;
            echo "<p>Please enter email address.<p>";
        } else {
            $email = stripslashes($_POST['email']);
            if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email) == 0) {
                ++$errors;
                echo "<p>You need to enter a valid email address.</p>";
                $email = "";
            }
        }

        if (empty($_POST['password1'])) {
            ++$errors;
            echo "<p>You need to enter a password.</p>";
            $password1 = "";
        } else {
            $password1 = stripslashes($_POST['password1']);
        }

        if (empty($_POST['password2'])) {
            ++$errors;
            echo "<p>You need to enter a confirmation password.</p>";
            $password2 = "";
        } else {
            $password2 = stripslashes($_POST['password2']);
        }

        if ((!empty($password1)) && (!empty($password2))) {
            if (strlen($password1) < 8) {
                ++$errors;
                echo "<p>The password has to be at least 8 character long.</p>";
                $password1 = "";
                $password2 = "";
            } else {
                $password = md5($password1);
            }
            if ($password1 !== $password2) {
                ++$errors;
                echo "<p>The passwords do not match.</p>";
                $password1 = "";
                $password2 = "";
            } else {
                $password = md5($password1);
            }
        }

        $type = $_POST['type'];

        // if passed the validation
        if ($errors == 0) {

            // check if the email address is already registered
            $result = $obj->checkExistingUser($email);

            // if email is already used
            if ($result) {

                echo "<p>Email address: '" . $result['email'] . "' is already registered. Use another email address.<p>";
                echo "<p>Please go back to the registration page, using your browser's BACK button.</p>";

                // if email is new
            } else {
                // insert the user data into database
                $userId = $obj->registerUser($name, $surname, $phone, $email, $password, $type);

                $_SESSION['userId'] = $userId;
                $_SESSION['name'] = $name;
                $_SESSION['type'] = $type;

                echo "<p>Welcome to Easy Parking, <strong>" . $name . "</strong>!";

                // navigate to different pages depending on the user type
                if ($type == "user") {
                    echo "<p><a href='user.php?content=Available+Paarking' class='custom-button'>Go to Main Page</a></p>";
                } else {
                    echo "<p><a href='admin.php?content=All+Parking' class='custom-button'>Go to Main Page</a></p>";
                }
            }
        }

        // if didn't pass the validation
        if ($errors > 0) {
            echo "<p>Please go back to the registration page, using your browser's BACK button.</p>";
            ++$errors;
        }
        echo "</div>";
    } else {

        // registration form

    ?>

        <div align="center" class="container">
            <div class="head_test-wrap">
                <h1 class="head_test">EASY PARKING</h1>
            </div>
            <h1>User Registration</h1>
            <form class="login-form" style="width:60%;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                First Name: <br />
                <input type="text" name="firstname" /><br />
                Last Name: <br />
                <input type="text" name="lastname" /><br />
                Phone: <br />
                <em>(Australian mobile number (10 digits starting with 04))</em><br />
                <input type="text" name="phone" /><br />
                Email: <br />
                <input type="text" name="email" /><br />
                User Type:
                <br />
                <select name="type">
                    <option value="user">User</opsion>
                    <option value="admin">Admin</option>
                </select><br /><br />
                Password: <br /><em>(case-sensitive, must be at least 8 characters long)</em><br />
                <input type="password" name="password1" /><br />
                Confirm password: <br />
                <input type="password" name="password2" /><br /><br />
                <input type="submit" name="register" value="Register" class="custom-button" />
                <input type="reset" value="Clear form" class="custom-button" />
            </form>

            <br>
            <p>Already have an account? <a href="index.php">Login Page</a></p>
        </div>
    <?php } ?>
</body>

</html>