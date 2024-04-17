<?php
require('./../../vendor/autoload.php');
require('./../../User.php');
require("./../../ConnectDB/ConnectDB.php");

/**
 * @var bool $isUpdated.
 *   For take information about is the password is updated or not.
 */
$isUpdated = false;

// Check if 'token' is set in the URL parameters.
if (!isset($_GET['token'])) {
  die("Token is not provided.");
}

// Access the token coming from url.
$token = $_GET['token'];

$db = new ConnectDB();
$conn = $db->connectDB();

try {
  $query = "SELECT * FROM userdetail WHERE reset_token = ?";
  $stmt = $conn->prepare($query);

  if (!$stmt) {
    throw new Exception("Failed to prepare statement.");
  }

  $stmt->bindParam(1, $token, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

// If no result found.
if ($result == NULL) {
  die("Token not found");
}

// IF token is expired.
if (strtotime($result['reset-token-expires']) <= time()) {
  die("Token has be expired.");
}

// If token is found and not expired.
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $user = new User();
  $password = $_POST['password'];

  // Convert password in hash.
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // Update query for update the password.
  $updateQuery = "UPDATE userdetail SET password = ? WHERE reset_token = ?";
  $stmt = $conn->prepare($updateQuery);
  $stmt->bindParam(1, $password_hash, PDO::PARAM_STR);
  $stmt->bindParam(2, $token, PDO::PARAM_STR);

  if ($stmt->execute()) {
    $isUpdated = true;
  } else {
    echo "Error updating password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Linked custom CSS. -->
  <link rel="stylesheet" href="./../../Styles/style.css">
  <!-- Linked font awesome. -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
  <script src="./../../JS/script.js"></script>
</head>

<body>
  <section class="wrapper">
    <div class="container">
      <div class="registerContent d-flex justify-center item.center flex-col">
        <div class="innerContent ">
          <h3 class="roboto-bold">Enter Details.</h3>
          <!-- Printing the message. -->
          <?php if ($isUpdated) : ?>
            <em style="color: green;">Password Updated successfully.</em>
          <?php endif; ?>
          <form action="" method="post" id="form" onsubmit="return validateForgotPassword()">

            <!-- Input for password. -->
            <div class="formDiv">
              <input class="roboto-light" type="password" id="password" name="password" placeholder="New password">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>

            <!-- Input field for confirm password. -->
            <div class="formDiv">
              <input class="roboto-light" type="password" id="cpassword" name="cpassword" placeholder="Confirm password">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>
            <input type="submit" value="Submit" class="submitBtn roboto-medium">
          </form>

          <!-- If password updated successfully the show login button. -->
          <?php if ($isUpdated) : ?>
            <p class="roboto-light">Please click here to <a href="./../Login/Login.php">Login</a></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
