<?php
session_start();
include("Class.php");
$obj = new User();

?>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    if (isset($_POST['login'])) {

        // validation
        $errors = 0;

        echo "<div align='center' class='container'>";

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


        if (empty($_POST['password'])) {
            ++$errors;
            echo "<p>You need to enter a password.</p>";
            $password1 = "";
        } else {
            $password = md5(stripslashes($_POST['password']));
        }


        // if passed the validation
        if ($errors == 0) {

            // login function
            $row = $obj->loginUser($email, $password);

            if ($row) {

                $_SESSION['userId'] = $row['user_id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['type'] = $row['type'];

                echo "<h3>Welcome back, <strong>" . $row['name'] . "</strong>!</h3>";

                // navigate to different page depending on the user
                if ($row['type'] == "user") {
                    echo "<p><a href='user.php?content=Available+Paarking' class='custom-button'>Go to Main Page</a></p>";
                } else {
                    echo "<p><a href='admin.php?content=All+Parking'class='custom-button'>Go to Main Page</a></p>";
                }

                // if email or password doesn't match
            } else {
                echo "<p>Invalid email or password.</p>";
                ++$errors;
            }
        }

        // if didn't pass the validation
        if ($errors > 0) {
            echo "<p>Please go back to the registration page, using your browser's BACK button.</p>";
            ++$errors;
        }
        echo "</div>";
    } else {

        // destroy session info if user landed this page.
        $_SESSION = array();
        session_destroy();

        // lgoin form
    ?>
        <div align="center" class="container">
            <div class="head_test-wrap">
                <h1 class="head_test">EASY PARKING</h1>
            </div>

            <h1>User Login</h1>

            <form class="login-form" style="width:60%;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                Email: <br />
                <input type="text" name="email" /><br />
                Password: <br />
                <input type="password" name="password" /><br /><br />
                <input type="submit" name="login" value="Login" class="custom-button" />
                <input type="reset" value="Clear form" class="custom-button" />

            </form>
            <br />
            <p>Don't have an account yet? <a href="registration.php">Registration Page</a></p>

        </div>
    <?php } ?>
</body>