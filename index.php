<?php
session_start();
require_once 'conn22.php';

$path = 'uploads/';

$sql = "SELECT * FROM cru";
$exec = $mysqli->query($sql);

$cru = array(); // Initialize an empty array to store the results

while ($data = $exec->fetch_object()) {
    $cru[] = $data; // Append the fetched object to the array
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>User List</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h2>User List</h2>
    <div class="button-container">
      <a href="?logout=true" class="btn btn-primary">Logout</a>
      <a href="register.php" class="btn btn-success">Register</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Sr.No</th>
          <th>Name</th>
          <th>Mobile</th>
          <th>Address</th>
          <th>City</th>
          <th>Email</th>
          <th>Designation</th>
          <th>Password</th>
          <th>Profile Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $Id = 1; 
        foreach ($cru as $crud) {
          ?>
          <tr>
            <td><?php echo $Id; ?></td>
            <td><?php echo $crud->name; ?></td>
            <td><?php echo $crud->mobile; ?></td>
            <td><?php echo $crud->address; ?></td>
            <td><?php echo $crud->city; ?></td>
            <td><?php echo $crud->email; ?></td>
            <td><?php echo $crud->des; ?></td>
            <td><?php echo $crud->password; ?></td>
            <td>
              <?php
              if (isset($crud->image)) {
                echo "<img src='".$path.$crud->image."' alt='Profile Image' class='img-thumbnail'>";
              } else {
                echo "<span>No Image</span>";
              }
              ?>
            </td>
            <td>
              <div class="btn-group">
                <a href="update44.php?Id=<?php echo $crud->Id; ?>" class="btn btn-primary">Update</a>
                <a href="delete.php?Id=<?php echo $crud->Id; ?>" class="btn btn-danger">Delete</a>
              </div>
            </td>
          </tr>
          <?php
          $Id++;
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
