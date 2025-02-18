<div class="head_test-wrap">
    <h1 class="head_test">EASY PARKING</h1>
</div>
<link rel="stylesheet" href="styles.css">
<form align="center" action="admin.php" method="GET">
    <input type="submit" name="content" value="All Parking" class="custom-button" />
    <input type="submit" name="content" value="Available Parking" class="custom-button" />
    <input type="submit" name="content" value="Full Parking" class="custom-button" />
    <input type="submit" name="content" value="User List" class="custom-button" />
    <input type="submit" name="content" value="Search Location" class="custom-button" />


    <br /><br />
    <a href="logout.php?type=admin" class="custom-button">Logout</a></p>
</form>
<?php
echo "<p align='center'>You're logged in as <strong>" . $_SESSION['name'] . "</strong></p>";
?>


<hr>