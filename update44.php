<?php
// Establish database connection
require_once 'conn22.php';

// Check if the user ID is provided via GET parameter
if (isset($_GET["Id"])) {
    $Id = $_GET["Id"];

    // Retrieve user data from the database
    $sql = "SELECT * FROM cru WHERE Id = '$Id'";
    $result = $mysqli->query($sql);

    if ($result->num_rows === 1) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Update the user data
        if (isset($_POST['update'])) {
            $name = $_POST['name'];
            $mobile = $_POST['mobile'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $email = $_POST['email'];
            $designation = $_POST['designation'];
            $password = $_POST['password'];

            // Check if a new profile image is uploaded
            if ($_FILES['profile']['size'] > 0) {
                $path = 'uploads/';

                // Delete the existing profile image
                if (!empty($row['image']) && file_exists($path . $row['image'])) {
                    unlink($path . $row['image']);
                }

                $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
                $filename = $name . '_' . date('YmdHis') . '.' . $extension;
                $profile = $filename;

                // Move the uploaded profile image to the destination folder
                move_uploaded_file($_FILES['profile']['tmp_name'], $path . $filename);
            } else {
                // Keep the existing profile image
                $profile = $row['image'];
            }

            // Update the user data in the database
            $sql = "UPDATE cru SET name = '$name', mobile = '$mobile', address = '$address', city = '$city', email = '$email', des = '$designation', password = '$password', image = '$profile' WHERE Id = '$Id'";
            $update = $mysqli->query($sql);

            if ($update) {
                echo '<div class="alert alert-success" role="alert">Data Updated Successfully</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Something went wrong</div>';
            }
        }
        header("url=index.php");
        // HTML form to display user data and allow for updates
        ?>

        <!DOCTYPE html>
        <html>
        <head>
          <title>Update User</title>
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
          <style>
            /* Add custom CSS styles here */
            .reg-btn {
              background-color:green;
              color: White;
            }

            .update-btn {
              background-color: blue;
              color: white;
            }
            
          </style>
        </head>
        <body>
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">User List Page</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link reg-btn" href="register.php">Register</a>
                </li>
              </ul>
            </div>
          </nav>

          <div class="container">
            <h2>Update User</h2>
            <form method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="name" class="required">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required class="form-control">
              </div>

              <div class="form-group">
                <label for="mobile" class="required">Mobile No.:</label>
                <input type="text" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>" required class="form-control">
              </div>

              <div class="form-group">
                <label for="address" class="required">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required class="form-control">
              </div>

              <div class="form-group">
                <label for="city" class="required">City:</label>
                <input type="text" id="city" name="city" value="<?php echo $row['city']; ?>" required class="form-control">
              </div>

              <div class="form-group">
                <label for="email" class="required">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required class="form-control">
              </div>

              <div class="form-group">
                <label for="designation">Designation:</label>
                <input type="text" id="designation" name="designation" value="<?php echo $row['des']; ?>" class="form-control">
              </div>

              <div class="form-group">
                <label for="password" class="required">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required class="form-control">
              </div>

              <hr>

              <!-- Profile image input -->
              <div class="form-group">
                <label for="profile_img">Profile Photo</label>
                <img id="previewImg" class="image-preview" src="uploads/<?php echo $row['image']; ?>" alt="Preview" width="200" height="200">
                <input type="file" id="profile" name="profile" accept="image/png" class="form-control-file">
              </div>

              <div class="form-group">
                <input type="submit" class="btn btn-primary update-btn" name="update" id="update" value="Update">
              </div>
            </form>
          </div>

          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        </body>
        </html>

        <?php
    } else {
        echo '<div class="alert alert-danger" role="alert">User not found</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Invalid user ID</div>';
}

$mysqli->close();
?>
