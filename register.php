<?php
session_start();
require_once 'conn22.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM cru WHERE email = '$email'";
    $checkEmailResult = $mysqli->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        echo  '<div class="alert alert-danger" role="alert">Email already exists. Please choose a different email</div>';
    } else {
        $path = 'uploads/';
        $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
        $filename = $_POST['name'] . '_' . date('YmdHis') . '.' . $extension;
        $profile = (file_exists($_FILES['profile']['tmp_name'])) ? $filename : null;

        $insert_data = [
            'name' => $_POST['name'],
            'mobile' => $_POST['mobile'],
            'address' => $_POST['address'],
            'city' => $_POST['city'],
            'email' => $email,
            'des' => $_POST['designation'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'image' => $profile
        ];

        $cols = implode(',', array_keys($insert_data));
        $vals = implode("','", array_values($insert_data));
        $sql = "INSERT INTO cru ($cols) VALUES ('$vals')";
        $insert = $mysqli->query($sql);

        if ($insert) {
            if (!is_null($profile)) {
                move_uploaded_file($_FILES['profile']['tmp_name'], $path . $filename);
            }
            echo '<div class="alert alert-success" role="alert"> User Registered Successfully</div>';
        } else {
            echo "Something went wrong";
            header("refresh:3;url:registration.php");
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      font-family: Roboto, Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      border-radius: 15px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: normal;
      margin-bottom: 5px;
    }

    .form-group label.required::after {
      content: '*';
      color: red;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .submit-button {
      width: 100%;
      padding: 10px;
      background-color: #B95D20;
      border: none;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      border-radius: 3px;
    }

    .submit-button:hover {
      background-color: #0056b3;
    }

    .image-preview {
      max-width: 200px; /* Adjust the size as per your preference */
      max-height: 200px; /* Adjust the size as per your preference */
    }

    hr {
      height: 1px;
      background-color: #B95D20; /* Same color as the button background color */
      border: none;
      margin-top: 20px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>User Registration</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name" class="required">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="mobile" class="required">Mobile No.:</label>
        <input type="text" id="mobile" name="mobile" required>
      </div>


      <div class="form-group">
        <label for="address" class="required">Address:</label>
        <input type="text" id="address" name="address" required>
      </div>

      <div class="form-group">
        <label for="city" class="required">City:</label>
        <input type="text" id="city" name="city" required>
      </div>

      <div class="form-group">
        <label for="email" class="required">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="designation">Designation:</label>
        <input type="text" id="designation" name="designation">
      </div>

      <div class="form-group">
        <label for="password" class="required">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <hr>

      <!-- Profile image input -->
      <div class="form-group">
        <label for="profile_img">Profile Photo</label>
        <img id="previewImg" class="image-preview" src="profile-image.png" alt="Preview">
        <input type="file" id="profile" name="profile" accept="image/png" required>
      </div>

      <div class="form-group">
        <input type="submit" class="submit-button" name="register" id="register" value="Register">
      </div>
    </form>
    <p>Already registered? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>

