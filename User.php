<?php

/**
 * @var NAMEPATTERN.
 *   To store the preg match for name pattern.
 */
define('NAMEPATTERN', "/^[a-zA-Z-' ]*$/");

/**
 * @var PHONEPATTERN.
 *   To store the preg match for phone pattern.
 */
define('PHONEPATTERN', "/^(\+91)[1-9][0-9]{9}$/");

/**
 * @var PASSWORDPATTERN.
 *   To store the preg match for password pattern.
 */
define("PASSWORDPATTERN", "/^(?=.*[A-Z])(?=.*[\W_])(?=.{5,10}$).*/");

/**
 * User class.
 *  All required informations and operation related to user data.
 *
 */
class User
{
  /**
   * @var array error[].
   *   Store errors for different fields.
   */
  public $errors = [];

  /**
   * @var array subjects[].
   *   Store subject.
   */
  public $subjects = [];

  /**
   * @var array marks[].
   *   Store marks for different subjects.
   */
  public $marks = [];

  /**
   * @var string $email.
   *  To Store the email.
   */
  private $email;

  /**
   * @var string $password.
   *  To Store the password.
   */
  private $password;

  /**
   * @var string $cpassword.
   *  To Store the confirm password.
   */
  private $cpassword;

  /**
   * Funtion setError().
   *  To set error.
   *
   * @param string $field.
   *  Field name for which error is setting.
   * @param string errMsg.
   *  Error message for that field.
   */
  public function setError( string $field, string $errMsg)
  {
    $this->errors[$field] = $errMsg;
  }

  /**
   * Function setSubject().
   *  To set the subjects.
   *
   * @param integer $index.
   *  Index.
   * @param string $subject.
   *  Subject name.
   */
  function setSubject(string $index, string $data)
  {
    $this->subjects[$index] = $data;
  }

  /**
   * Function setMarks().
   *  To set the marks.
   *
   * @param integer $index.
   *  Index.
   * @param string $marks.
   *  marks name.
   */
  function setMarks(string $index, string $data)
  {
    $this->marks[$index] = $data;
  }

  /**
   * Function checkEmpty().
   *  To check if the data is empty or not.
   *
   * @param string $data.
   *  Name data given by user.
   * @param string $field.
   *  Field name for which field validation is happening.
   *
   * @return string data.
   *  If all validation is true the return data.
   */
  public function checkEmpty( string $data, string $field)
  {
    if (empty($data)) {
      $this->setError($field, "This field cannot be empty.");
    }
  }

  /**
   * Function validateName().
   *  To validate name field.
   *
   * @param string $name.
   *  Name data given by user.
   * @param string $field.
   *  Field name for which field validation is happening.
   *
   * @return string $name.
   *  If all validation is true the return name.
   */
  public function validateName(string $name, string $field)
  {
    $this->checkEmpty($name, $field);

    if (strlen($name) < 3 || strlen($name) > 20) {
      $this->setError($field, "Name should be between 3 and 20 characters.");
    } else if (!preg_match(NAMEPATTERN, $name)) {
      $this->setError($field, "Please enter valid input.");
    } else {
      return $name;
    }
  }

  /**
   * Function validatePhone().
   *  To validate phone field.
   *
   * @param string $name.
   *  Name data given by user.
   * @param string $field.
   *  Field name for which field validation is happening.
   *
   * @return string $name.
   *  If all validation is true the return name.
   */
  public function validatePhone(string $phone, string $field)
  {
    $this->checkEmpty($phone, $field);
    if (strlen($phone) != 13) {
      $this->setError($field, "Phone number should be of 10 digits.");
    } else if (!preg_match(PHONEPATTERN, $phone)) {
      $this->setError($field, "Please enter valid input.");
    } else {
      return $phone;
    }
  }

  /**
   * Function validateEmail()
   *  To validate emailfield.
   *
   * @param string $email.
   *  Email data given by user.
   * @param string $field.
   *  Field name for which field validation is happening.
   *
   * @return string $email.
   *  If all validation is true the return email.
   */
  public function validateEmail(string $email, string $field)
  {
    $this->checkEmpty($email, $field);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->setError($field, "Invalid email format");
    } else {
      return $email;
    }
  }

  /**
   * Function validatePassword()
   *  To validate passwordField.
   *
   * @param string $password.
   *  Password data given by user.
   * @param string $field.
   *  Field name for which field validation is happening.
   *
   * @return string $password.
   *  If all validation is true the return password.
   */
  public function validatePassword( string $password, string $field)
  {
    $this->checkEmpty($password, $field);
    if (!preg_match(PASSWORDPATTERN, $password)) {
      $this->setError($field, "Please enter the valid password.");
    }

    else {
      return $password;
    }
  }

  /**
   * Function validatePassword()
   *  To validate passwordField.
   *
   * @param string $cpassword.
   *  Confirm Password data given by user.
   * @param string $password.
   *  Password data given by user.
   * @param string $field.
   *  Field name for which field validation is happening.
   *
   * @return string $password.
   *   If all validation is true the return password.
   */
  public function validateConfirmPassword(string $cpassword, string $password,string $field)
  {
    $this->checkEmpty($cpassword, $field);
    if ($cpassword != $password) {
      $this->setError($field, "Confirm Password should be same as password.");
    } else {
      return $cpassword;
    }
  }

  /**
   * Function validateMarks().
   *  To validate marks and subject.
   *
   * @param string $data.
   *   Store the data is given by user.
   * @param string $field.
   *   Store the field name.
   */
  public function validateMarks(string $marks, string $field)
  {
    $this->checkEmpty($marks, $field);

    $data = explode("\n", $marks);
    $i = 0;

    foreach ($data as $lines) {

      // Explode the lines by '|'.
      $parts = explode("|", $lines);

      // Check if the parts[0] is numeric or not and part[1] is also nymeric of not
      if (is_numeric(trim($parts[0])) && is_numeric(trim($parts[1])) || (empty(trim($parts[0])) || empty(trim($parts[1])))) {

        $this->setError($field, "Please enter valid input.");
      } else if (is_numeric(trim($parts[0])) || !is_numeric(trim($parts[1]))) {

        $this->setError($field, "Please enter valid input. Ex(Suject|Marks)");
      } else {

        $this->setSubject($i, trim($parts[0]));
        $this->setMarks($i, trim($parts[1]));
        $i = $i + 1;
      }
    }
  }

  /**
   * Funtion validation();
   *  To call the all validation function.
   *
   * @var string $emailInput.
   *  Email input value.
   * @var string $emailField.
   *  Email field name for further use.
   * @var string $passwordInput.
   *  Password input value.
   * @var string $passwordField.
   *  Password field name for further use.
   * @var string $cpasswordInput.
   *  Confirm password value.
   * @var string $cpasswordfield.
   *  Confirm password field name for further use.
   */
  function validations(string $emailInput = '', string $emailField = '', string $passwordInput = '', string $passwordField = '', string $cpasswordInput = '', string $cpasswordField = '')
  {

    $this->email = $this->validateEmail($emailInput, $emailField);
    $this->password = $this->validatePassword($passwordInput, $passwordField);
    $this->cpassword = $this->validateConfirmPassword($cpasswordInput, $passwordInput, $cpasswordField);
  }

  /**
   * Funtion getEmail().
   *  To get email.
   *
   * @return string $email.
   *  Email.
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Funtion getPassword().
   *  To get password.
   *
   * @return string $password.
   *  Password.
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Funtion getConfirmPassword().
   *  To get confirm password.
   *
   * @return string $cpassword.
   *  Confirm Password.
   */
  public function getConfirmPassword()
  {
    return $this->cpassword;
  }

  /**
   * Function getErrors().
   *  To get errors.
   *
   * @return array $this->errors.
   *   Returns the errors.
   */
  public function getErrors():array
  {
    return $this->errors;
  }
  /**
   * Function getSubjects().
   *  To get subjects.
   *
   * @return array $this->subjects.
   *   Returns the subjects.
   */
  public function getSubjects(): array
  {
    return $this->subjects;
  }
  /**
   * Function getMarks().
   *  To get Marks.
   *
   * @return array $this->marks.
   *   Returns the marks.
   */
  public function getMarks(): array
  {
    return $this->marks;
  }
}
