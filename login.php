<?php
session_start();
require_once 'conn22.php';

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    $sql = "SELECT * FROM cru WHERE email='$email'";
    $exec = $mysqli->query($sql);

    if($exec->num_rows > 0)
    {
        $user = $exec->fetch_object();
        $hashedPassword = $user->password;

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_data'] = $user;
            $name = $_SESSION['user_data']->name;

            echo "<div class='alert alert-success' role='alert'>
                Welcome $name
            </div>";
            header("Refresh:2,url=index.php");
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                Invalid Password
            </div>";
        }
    }
    else
    {
        echo "<div class='alert alert-danger' role='alert'>
            Email or Password is Invalid
        </div>";
    }
}
?>







<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #fff;
      border-radius: 5px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .form-group .error {
      color: red;
      margin-top: 5px;
    }

    .form-group .success {
      color: green;
      margin-top: 5px;
    }

    .form-group .forgot-password {
      margin-top: 10px;
      text-align: right;
    }

    .form-group .forgot-password a {
      text-decoration: none;
      color: #555;
    }

    .form-group .forgot-password a:hover {
      color: #000;
    }

    .form-group .submit-button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      border: none;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
      border-radius: 3px;
    }

    .form-group .submit-button:hover {
      background-color: #0056b3;
    }
    .register-link {
      text-align: center;
      margin-top: 10px;
    }

    .register-link a {
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }

    .register-link a:hover {
      color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Login Form</h2>
    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <input type="submit" class="submit-button" name="login" id="login" value="Login">
      <div class="form-group">
   
      <div class="register-link">
      <a href="register.php">Register</a>
    </div>
  
    </form>
  </div>
</body>
</html>
