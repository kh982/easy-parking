<!DOCTYPE html>
<html>

<head>
    <title>Create DATABASE</title>
</head>

<body>
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";


    // Create connection
    try {
        $conn = new mysqli($servername, $username, $password);
    } catch (mysqli_sql_exception $e) {
        die("Connection failed: " . $e->getCode() . ": " . $e->getMessage());
    }

    // Create database
    $sql = "CREATE DATABASE Major_assignment";
    try {
        $conn->query($sql);
        echo "<p>Database created successfully.</p>";
    } catch (mysqli_sql_exception $e) {
        die("Error creating database: " . $e->getCode() . ": " . $e->getMessage());
    }

    $DBName = "Major_assignment";

    $conn->select_db($DBName);


    try {

        //create tables
        $sql_1 = "CREATE TABLE User (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        surname VARCHAR(50) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        type ENUM('admin', 'user') NOT NULL
        )";

        $sql_2 = "CREATE TABLE Parking (
        parking_id INT AUTO_INCREMENT PRIMARY KEY,
        location VARCHAR(100) NOT NULL,
        description TEXT,
        parking_space INT NOT NULL, 
        cost_per_hour DECIMAL(10, 2) NOT NULL
        )";


        $sql_3 = "CREATE TABLE Parking_history  (
        history_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        parking_id INT NOT NULL,
        checkin_date_time DATETIME NOT NULL,
        checkout_date_time DATETIME,
        cost DECIMAL(10, 2),
        FOREIGN KEY (user_id) REFERENCES User(user_id),
        FOREIGN KEY (parking_id) REFERENCES Parking(parking_id)
        )";

        $conn->query($sql_1);
        $conn->query($sql_2);
        $conn->query($sql_3);



        echo "<p>All the tables created successfully.</p>";
    } catch (mysqli_sql_exception $e) {
        die("Error creating table: " . $e->getCode() . ": " . $e->getMessage());
    }



    $conn->close();


    /*

    //Drop database
    $sql = "DROP DATABASE Assignment3";
    try {
        $conn->query($sql);
        echo "Database deleted successfully";
    } catch (mysqli_sql_exception $e) {
        die("Error deleting database: " . $e->getCode() . ": " . $e->getMessage());
    }

    $conn->close();


 */





    ?>
</body>

</html>