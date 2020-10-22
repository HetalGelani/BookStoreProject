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
            $stmt->bind_param("d", $param_book);

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


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body class="wrapper">
    <p>Please fill in your credentials to checkout.</p>
    <form action="checkout.php" method="post">
        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
            <input type="hidden" value="<?php $_GET['id'] ?>" name="bookid">
            <input type="hidden" value="<?php $_GET['qty'] ?>" name="bookqty">
            <label>Firstname</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
            <span class="help-block"><?php echo $firstname_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
            <label>Lastname</label>
            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
            <span class="help-block"><?php echo $lastname_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Checkout">
        </div>
    </form>
</body>
</html>
