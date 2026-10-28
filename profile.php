<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success = "";

$username = $_SESSION['username'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $address = trim($_POST['address']);
    $pnumber = trim($_POST['pnumber']);
    $gender = trim($_POST['dGender']);
    

    if (empty($address)) {
        $errors[] = "Address is required";
    }

    if (empty($pnumber)) {
        $errors[] = "Phone Number is required";
    }

    if (!is_numeric($pnumber)) {
        $errors[] = "Phone Number must be Numerical";
    }

    if (!strlen((string) $pnumber) == 11) {
        $errors[] = "Phone Number must be 11 digits";
    } 
    

    if (empty($errors)) {
        mysqli_query(
            $conn,
            "UPDATE users SET address = '$address', phone_number = '$pnumber', gender = '$gender' WHERE username = '$username'",
        );

        // $user['address'] = trim($_POST['address']);
        $success = "Address updated successfully";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>

<body>
    <h3>Edit Profile</h3>
    <form method="POST">
        <label for="address">Address:</label>
        <input type="text" name="address" value="">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <br><br>
        <label for="pnumber">Phone Number:</label>
        <input type="text" name="pnumber" value="">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <br><br>
        <label for="dGender">Gender:</label>
        <select name = "dGender" id="dGender">
        <option value = "male">Male</option>
        <option value = "female">Female</option>
        </select>
        <br><br>
        <button type="submit">Update</button>
    </form>
    <br><br>
    <?php echo $user['address'] . "<br>"; ?> <a href="dashboard.php">Delete</a>
    <br><br>
    <a href="dashboard.php">Back to Dashboard</a>
    <?php

    if ($success) {
        echo $success;
    }

    foreach ($errors as $error) {
        echo $error . "<br>";
    }

    ?>
</body>

</html>