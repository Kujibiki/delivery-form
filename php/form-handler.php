<?php
//very simple handler for storing data to DB
//#todo server side validation

sleep (2); //artificial pause

$name = $country = $city = $street = $apartment = $deliveryDate = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_POST = json_decode(file_get_contents('php://input'), true); //decode JSON into POST
    var_dump ($_POST);
    $name = test_input($_POST["name"]);
    $country = test_input($_POST["country"]);
    $city = test_input($_POST["city"]);
    $street = test_input($_POST["street"]);
    $apartment = test_input($_POST["apartment"]);
    $deliveryDate = test_input($_POST["deliverydate"]);

    $mysqli = new mysqli("localhost", "user", "j2jkbI&T^*&%fgjy765*&G", "delivery"); //connect to DB
    $query = 'INSERT INTO forms (name, country, city, street, apartment, deliverydate) VALUES (?,?,?,?,?,?)';
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $name,$country,$city,$street,$apartment,$deliveryDate);
    $stmt->execute(); //insert data
    error_log($mysqli->error);
}



function test_input($data) { //help to delete unecessary symbols from data input
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo "OK";
?> 