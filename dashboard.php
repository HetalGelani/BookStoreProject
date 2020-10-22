<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <style>
        #books {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #books td, #books th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #books tr:nth-child(even){background-color: #f2f2f2;}

        #books tr:hover {background-color: #ddd;}

        #books th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
        <p>Hey, <?php echo $_SESSION['username']; ?>!</p>
        <p>You are in user dashboard page.</p>

        <table id="books">
            <tr>
                <th> Book Name</th>
                <th> Book Author</th>
                <th> Price of a Book </th>
                <th> Stock of a Book</th>
                <th> Order Book </th>
            </tr>
        <?php
            require_once "db.php";

            $query = "SELECT * FROM `bookinventory` WHERE `quantity` > 0";

            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $id = $row['book_id'];
                    $qty = $row['quantity'];
                    echo "<tr><td>".$row["book_name"]."</td><td>".$row["book_author"]."</td><td>".$row["book_price"]."</td><td>".$row["quantity"]."</td><td><a href='checkout.php?id=$id&qty=$qty'>Order Here</a></td></tr>";
                }
            } else {
                echo "0 results";
            }
            $mysqli->close();
        ?>
        </table>
        <p><a href="logout.php">Logout</a></p>
</body>
</html>
