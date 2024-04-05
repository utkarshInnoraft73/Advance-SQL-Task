<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("./../../vendor/autoload.php");
require("./../../ConnectDB/ConnectDB.php");
require("./../../User.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * @var array errors.
 *   To Store the errors for respective fields.
 */
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = new User();
  $user->validations($_POST['email'], 'email');

  // Validate email.
  $email = $user->getEmail();

  // Fetch all errors.
  $errors = $user->getErrors();

  // generate randon token.
  $token = bin2hex(random_bytes(16));

  // Set the expiry time for reset passward.
  $expiry = date('Y-m-d H:i:s', time() + 60 * 30);

  try {
    $db = new ConnectDB();

    // Connect databse.
    $conn = $db->connectDB();

    // Query for update the token for selected email in database.
    $query = "UPDATE userdetail SET reset_token = ?, `reset-token-expires` = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $token, PDO::PARAM_STR);
    $stmt->bindParam(2, $expiry, PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['email'], PDO::PARAM_STR);

    // set parameters and execute
    if ($stmt->execute()) {

      $mail = new PHPMailer(true);

      try {
        // Server settings.

        // Send using SMTP.
        $mail->isSMTP();

        // Set the SMTP server to send through.
        $mail->Host = 'smtp.gmail.com';

        // Enable SMTP authentication.
        $mail->SMTPAuth   = true;

        // SMTP username.
        $mail->Username   = 'utkarshsingh737091@gmail.com';

        // SMTP password.
        $mail->Password   = 'hjsywaewazhjfblw';

        // Enable implicit TLS encryption.
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`.
        $mail->Port       = 465;

        //Recipients.
        $mail->setFrom('utkarshsingh737091@gmail.com', 'Mailer');

        //Add a recipient.
        $mail->addAddress($_POST['email']);

        // Content.

        //Set email format to HTML
        $mail->isHTML(true);
        $mail->Subject = 'Reset password link.';
        $mail->Body    = <<<END

        Click <a href = "http://advanceassignment.com/Components/ResetPassword/ResetPassword.php?token=$token" >here</a> to reset your password.
        END;

        $mail->send();
      } catch (Exception $e) {

        $error = "There is found some issues.";
      }
    }
  } catch (PDOException $e) {

    $error = $e->getMessage();
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
          <h3 class="roboto-bold">Enter registered email id.</h3>
          <form action="" method="post" id="form" onsubmit="return validateForgotPassword()">
            <div class="formDiv">
              <input class="roboto-light" type="email" id="email" name="email" placeholder="Email">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>
            <input type="submit" value="Submit" class="submitBtn roboto-medium">
          </form>
          <p class="roboto-light"><a href="./../Login/Login.php">Login here</a></p>
          <p class="roboto-light">Don't have account?<a href="/">Register here</a></p>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
