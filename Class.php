<?php

class User
{
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "Major_Assignment";

        try {
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }

        $this->conn = $conn;
    }




    public function checkExistingUser($email)
    {
        try {
            $tableName = "User";

            $sql = ("SELECT email FROM $tableName WHERE (email = ?)");
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $existingEmail = $result->fetch_assoc();

                $result->free_result();
                $stmt->close();

                return $existingEmail;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
    }





    public function registerUser($name, $surname, $phone, $email, $password, $type)
    {

        try {
            $tableName = "User";

            $sql = ("INSERT INTO $tableName (name, surname, phone, email, password, type) VALUES( ?, ?, ?, ?, ?, ?)");
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $surname, $phone, $email, $password, $type);

            $stmt->execute();
            $userId = $stmt->insert_id;
            $stmt->close();

            return $userId;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();


        return false;
    }





    public function loginUser($email, $password)
    {
        try {
            $tableName = "User";

            $sql = ("SELECT * FROM $tableName WHERE (email = ?)");
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row['password'] == $password) {

                $result->free_result();
                $stmt->close();
                return $row;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }




    public function getUser($userId = null)
    {
        try {

            $type = "user";
            $tableName = "User";
            $users = array();
            $query = "SELECT * FROM $tableName WHERE type = ?";

            if ($userId !== null) {
                $query .= " AND user_id = ?";
            }

            $stmt = $this->conn->prepare($query);

            if ($userId !== null) {
                $stmt->bind_param('si', $type, $userId);
            } else {
                $stmt->bind_param('s', $type);
            }


            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
            }
            $stmt->close();

            if ($userId !== null) {
                return $users[0];
            } else {
                return $users;
            }
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }
}




class Parking
{
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "Major_Assignment";

        try {
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }

        $this->conn = $conn;
    }



    public function registerParking($location, $description, $space, $cost)
    {
        try {

            $tableName = "Parking";

            $sql = "INSERT INTO $tableName (location, description, parking_space, cost_per_hour) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssid", $location, $description, $space, $cost);

            $stmt->execute();
            $parkingId = $stmt->insert_id;
            $stmt->close();

            return $parkingId;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }


    public function setParking($location, $description, $space, $cost, $parkingId)
    {
        try {

            $tableName = "Parking";

            $sql = "UPDATE $tableName SET location = ?, description = ?, parking_space = ?, cost_per_hour = ? WHERE parking_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssidi", $location, $description, $space, $cost, $parkingId);

            $stmt->execute();
            $stmt->close();

            return true;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
    }




    public function getParkings($parkingId = null)
    {

        try {
            $tableName = "Parking";
            $parkings = array();
            $query = "SELECT * FROM $tableName";

            if ($parkingId !== null) {
                $query .= " WHERE parking_id = ?";
            }

            $stmt = $this->conn->prepare($query);

            if ($parkingId !== null) {
                $stmt->bind_param('i', $parkingId);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $parkings[] = $row;
                }
            }
            $stmt->close();
            if ($parkingId !== null) {
                return $parkings[0];
            } else {
                return  $parkings;
            }
        } catch (mysqli_sql_exception $e) {
            throw new Exception("Unable to execute the query: " . $e->getCode() . ": " . $e->getMessage());
        }
    }






    public function getParkingCapacity()
    {
        $parkings = $this->getParkings();

        try {
            $tableName = "Parking_history";
            $parCapacityArray = array();

            foreach ($parkings as $parking) {
                $parkingId = $parking["parking_id"];
                $parCount = 0;
                $parArray = array();

                $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE parking_id = ? AND checkout_date_time IS NULL");
                $stmt->bind_param("s", $parkingId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ++$parCount;
                    }
                }
                $parArray['parking_id'] = $parkingId;
                $parArray['parking_space'] = $parking['parking_space'];
                $parArray['count'] = $parCount;
                $parCapacityArray[] = $parArray;
                $stmt->close();
            }
            return $parCapacityArray;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }




    public function getCheckins($userId)
    {

        try {
            $tableName = "Parking_history";

            $currIns = array();
            $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE user_id = ? AND checkout_date_time IS NULL");
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $currIns[] = $row;
                }
                $result->free_result();
            }
            $stmt->close();
            return $currIns;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }





    public function getCurrentParkings($currIns)
    {

        try {
            $tableName = "Parking";
            $currParkings = array();

            foreach ($currIns as $currIn) {
                $parId = $currIn["parking_id"];
                $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE parking_id = ?");
                $stmt->bind_param("s", $parId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['history_id'] = $currIn['history_id'];
                        $row['checkin_date_time'] = $currIn['checkin_date_time'];
                        $currParkings[] = $row;
                    }
                    $result->free_result();
                }
                $stmt->close();
            }
            return $currParkings;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }




    public function getCheckouts($userId)
    {

        try {
            $tableName = "Parking_history";

            $pastIns = array();
            $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE user_id = ? AND checkout_date_time IS NOT NULL ORDER BY checkout_date_time DESC");
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pastIns[] = $row;
                }
                $result->free_result();
            }
            $stmt->close();
            return $pastIns;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }




    public function getPastParking($historyId)
    {

        try {
            $tableName = "Parking_history";

            $stmt = $this->conn->prepare("SELECT parking_id, checkin_date_time FROM $tableName WHERE history_id = ?");
            $stmt->bind_param("i", $historyId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $history_info = $result->fetch_assoc();
            }
            $result->free_result();
            $stmt->close();
            return $history_info;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }




    public function getPastParkings($pastIns)
    {

        try {
            $tableName = "Parking";
            $pastParkings = array();

            foreach ($pastIns as $pastIn) {
                $parId = $pastIn["parking_id"];
                $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE parking_id = ?");
                $stmt->bind_param("s", $parId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $row['history_id'] = $pastIn['history_id'];
                        $row['cost'] = $pastIn['cost'];
                        $row['checkin_date_time'] = $pastIn['checkin_date_time'];
                        $row['checkout_date_time'] = $pastIn['checkout_date_time'];

                        $pastParkings[] = $row;
                    }
                    $result->free_result();
                }
                $stmt->close();
            }
            return $pastParkings;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }


    public function getCheckedinUsers($parkingId, $users)
    {

        try {

            $tableName = "Parking_history";
            $checkinList = array();
            foreach ($users as $user) {

                $userId = $user['user_id'];
                $array = array();

                $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE parking_id = ? AND user_id =? AND checkout_date_time IS NULL");
                $stmt->bind_param("ss", $parkingId, $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $array['history_id'] = $row['history_id'];
                    $array['user_id'] = $user['user_id'];
                    $array['name'] = $user['name'];
                    $array['surname'] = $user['surname'];
                    $array['phone'] = $user['phone'];
                    $array['email'] = $user['email'];
                    $array['checkin_date_time'] = $row['checkin_date_time'];
                    $checkinList[] = $array;
                }
                $result->free_result();
                $stmt->close();
            }
            return $checkinList;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }





    public function checkin($userId, $parkingId)
    {
        try {
            $time = date('Y-m-d H:i:s');

            $tableName = "Parking_history";
            $stmt = $this->conn->prepare("INSERT INTO $tableName (user_id, parking_id, checkin_date_time) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $userId, $parkingId, $time);
            $stmt->execute();
            $stmt->close();
            return $time;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }



    public function checkout($historyId, $checkinTime, $cost)
    {
        try {
            $time = date('Y-m-d H:i:s');
            $checkoutTime = strtotime($time);
            $checkinTime = strtotime($checkinTime);

            $usageTimeSeconds = $checkoutTime - $checkinTime;
            $usageTimeHours = ceil($usageTimeSeconds / 3600);
            $totalCost = $cost + max(0, $usageTimeHours - 1) * $cost;


            $tableName = "Parking_history";

            $stmt = $this->conn->prepare("UPDATE $tableName SET checkout_date_time = ?, cost = ? WHERE history_id = ?");
            $stmt->bind_param("sds", $time, $totalCost, $historyId);
            $stmt->execute();

            $stmt->close();
            return $totalCost;
        } catch (mysqli_sql_exception $e) {
            die("Unable to execute the query" . $e->getCode() . ": " . $e->getMessage());
        }
        $this->conn->close();
    }


    public function searchParkings($id = null, $name = null, $description = null)
    {

        $tableName = "Parking";
        $parkings = array();

        $query = "SELECT * FROM $tableName WHERE 1";

        if ($id !== "") {
            $query .= " AND parking_id LIKE '$id'";
        }
        if ($name !== "") {
            $query .= " AND location LIKE '$name'";
        }
        if ($description !== "") {
            $query .= " AND description LIKE '$description'";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();


        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $resultFound = true;
            while ($row = $result->fetch_assoc()) {
                $parkings[] = $row;
            }
            $result->free_result();
        }
        $stmt->close();

        return $parkings;
    }
}
