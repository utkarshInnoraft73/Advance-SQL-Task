<?php

/**
 * Start session.
 */
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Linked custom CSS. -->
  <link rel="stylesheet" href="./../../Styles/home.css">
  <!-- Linked font awesome. -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
  <!-- Custom script file for form validation. -->
  <script src="../../JS/script.js"></script>
  <!-- <script src="script.js"></script> -->
</head>

<body>
  <section class="wrapper">
    <div class="container">
      <a class="roboto-medium" style="padding: 12px 15px; background-color:brown;margin-top:12px; color:#fff; border-radius: 10px;" href="./../LogOut/LogOut.php">Log out</a>
      <div class="registerContent d-flex justify-center item.center flex-col">
        <div class="innerContent ">
          <h3 class="roboto-medium">Enter required informations.</h3>

          <hr>
          <form id="form" action="./../PDF/Pdf.php" method="post" enctype="multipart/form-data" onsubmit="return validateAdmin()">

            <!-- Input for first name. -->
            <div class="formDiv">
              <input class="roboto-light" type="text" id="fname" name="fname" placeholder="First name" autocomplete="off">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>

            <!-- Input for last name. -->
            <div class="formDiv">
              <input class="roboto-light" type="text" id="lname" name="lname" placeholder="Last name" autocomplete="off">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>

            <!-- Input for Phone number. -->
            <div class="formDiv">
              <input class="roboto-light" type="tel" id="phone" name="phone" placeholder="Phone number" autocomplete="off">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>

            <!-- Input for Images. -->
            <div class="formDiv">
              <input class="roboto-light" type="file" id="image" name="image" accept="image/*" placeholder="Your Image" autocomplete="off">
              <i class="fa-solid fa-check"></i>
              <i class="fa-solid fa-circle-exclamation"></i>
              <small class="roboto-light">Error msg</small>
            </div>

            <!-- Input for textarea. -->
            <div class="formDiv">
              <small class="roboto-light">Error msg</small>
              <textarea class="roboto-light" cols="10" rows="5" type="text" id="marks" name="marks" placeholder="Enter Marks"></textarea>
            </div>

            <!-- Input field for submit button. -->
            <input type="submit" value="Submit" name="submit" class="submitBtn roboto-medium">
          </form>

        </div>
      </div>
    </div>
  </section>

</body>

</html>