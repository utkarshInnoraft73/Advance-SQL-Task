<?php
require('./../../vendor/autoload.php');
require './../../User.php';

use Fpdf\Fpdf;

/**
 * Global variable.
 *
 * @var array $subjects.
 *   To store the subjects name.
 */
$subjects = [];

/**
 * Global variable.
 *
 * @var array $marks.
 *   To store the marks for respective subject.
 */
$marks = [];


if (!empty($_POST['submit'])) {

  /**
   * Create the object of class user.
   */
  $user = new User();

  /**
   * Getting the first name.
   */
  $fname = $user->validateName($_POST['fname'], 'fname');

  /**
   * Getting last name.
   */
  $lname = $user->validateName($_POST['lname'], 'lname');

  /**
   * Getting phone number.
   */
  $phone = $user->validatePhone($_POST['phone'], 'phone');

  // Call validateMarks.
  $user->validateMarks($_POST['marks'], 'marks');

  // Store the sujects.
  $subjects = $user->getSubjects();

  // Store the marks.
  $marks = $user->getMarks();

  // Accessing image.
  $imgName = $_FILES['image']['name'];
  $img_temp_name = $_FILES['image']['tmp_name'];
  move_uploaded_file($img_temp_name, "Uploads/$imgName");

  // Setting the full name by first name and last name.
  $fullname = "$fname $lname";

  /**
   * Create the new object of class Fpdf.
   */
  $pdf = new Fpdf();

  // Adding The page.
  $pdf->AddPage();
  $pdf->SetFont('Arial', "", 15);
  $pdf->Cell(0, 10, "User Details", 0, 1, "C");

  $pdf->Image("Uploads/$imgName", 135, 15, 65);
  $pdf->Cell(45, 15, "Name: ", 0, 0, "");
  $pdf->Cell(76, 15, $fullname, 0, 1, "");
  $pdf->Cell(45, 15, "Phone:", 0, 0, "");
  $pdf->Cell(76, 15, $phone, 0, 1, "");

  $pdf->Cell(0, 10, "Subject marks Details.", 0, 1, "C");
  $pdf->Cell(20, 10, "Srl no.", 1, 0, "C");
  $pdf->Cell(130, 10, "Subject", 1, 0, "C");
  $pdf->Cell(0, 10, "Marks", 1, 1, "C");

  $sl = 1;
  foreach ($subjects as $key => $value) {
    $pdf->Cell(20, 10, $sl, 1, 0, "C");
    $pdf->Cell(130, 10, $subjects[$key], 1, 0, "C");
    $pdf->Cell(0, 10, $marks[$key], 1, 1, "C");
    $sl = $sl + 1;
  }

  $file = time() . ".pdf";
  $pdf->output();
}
