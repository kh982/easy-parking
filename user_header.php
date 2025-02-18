<div class="head_test-wrap">
    <h1 class="head_test">EASY PARKING</h1>
</div>
<link rel="stylesheet" href="styles.css">
<form align="center" action="user.php" method="GET">
    <input type="submit" name="content" value="Available Parking" class="custom-button" />
    <input type="submit" name="content" value="My Parking History" class="custom-button" />
    <input type="submit" name="content" value="Current Parking" class="custom-button" />
    <input type="submit" name="content" value="Search Location" class="custom-button" />
    <br /><br />

    <a href="logout.php?type=user" class="custom-button">Logout</a>
</form>
<?php
echo "<p align='center'>You're logged in as <strong>" . $_SESSION['name'] . "</strong></p>";
?>
<hr>