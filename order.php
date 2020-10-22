<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
require_once "db.php";

$firstname = $firstname_err = $lastname = $lastname_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

if (empty(trim($_POST["firstname"]))) {
$firstname_err = "Please enter firstname.";
} else {
$firstname = trim($_POST["firstname"]);
}

if (empty(trim($_POST["lastname"]))) {
$lastname_err = "Please enter lastname.";
} else {
$lastname = trim($_POST["lastname"]);
}

if(empty($firstname_err) && empty($lastname_err)){

$bid = $_POST["bookid"];
$qnty = $_POST["bookqty"];

$sql = "INSERT INTO bookinventoryorder (book_id) VALUES (?)";

if($stmt = $mysqli->prepare($sql)){
// Bind variables to the prepared statement as parameters
$stmt->bind_param("s", $param_book);

// Set parameters
$param_book = $bid;

// Attempt to execute the prepared statement
if($stmt->execute()){

$query = "UPDATE `bookinventory` SET `quantity`=  $qnty - 1 WHERE `book_id` = '$bid'";
$mysqli -> query($query);

// Redirect to login page
header("location: dashboard.php");
} else{
echo "Something went wrong. Please try again later.";
}

// Close statement
$stmt->close();
}
}

}
?>