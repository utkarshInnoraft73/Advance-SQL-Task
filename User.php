<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Constant NAMEPATTERN.
 *   To store the preg match for name pattern.
 */
define('NAMEPATTERN', "/^[a-zA-Z-' ]*$/");

/**
 * Constant PHONEPATTERN.
 *   To store the preg match for phone pattern.
 */
define('PHONEPATTERN', "/^(\+91)[1-9][0-9]{9}$/");

/**
 * Constant PASSWORDPATTERN.
 *   To store the preg match for password pattern.
 */
define("PASSWORDPATTERN", "/^[1-9]$/");

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
   * Funtion setError().
   *  To set error.
   * 
   * @param string $field.
   *   Field name for which error is setting.
   * @param string errMsg.
   *   Error message for that field.
   */
  public function setError($field, $errMsg)
  {
    $this->errors[$field] = $errMsg;
  }

  /**
   * Function setSubject().
   *  To set the subjects.
   * 
   * @param integer $index.
   *   Index.
   * @param string $subject.
   *   Subject name. 
   */
  function setSubject($index, $data)
  {
    $this->subjects[$index] = $data;
  }

  /**
   * Function setMarks().
   *  To set the marks.
   * 
   * @param integer $index.
   *   Index.
   * @param string $marks.
   *   marks name. 
   */
  function setMarks($index, $data)
  {
    $this->marks[$index] = $data;
  }

  /**
   * Function checkEmpty().
   *  To check if the data is empty or not.
   * 
   * @param string $data.
   *   Name data given by user.
   * @param string $field.
   *   Field name for which field validation is happening.
   * 
   * @return string data.
   *   If all validation is true the return data.
   */
  public function checkEmpty($data, $field)
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
   *   Name data given by user.
   * @param string $field.
   *   Field name for which field validation is happening.
   * 
   * @return string $name.
   *   If all validation is true the return name.
   */
  public function validateName($name, $field)
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
   *   Name data given by user.
   * @param string $field.
   *   Field name for which field validation is happening.
   * 
   * @return string $name.
   *   If all validation is true the return name.
   */
  public function validatePhone($phone, $field)
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
   *   Email data given by user.
   * @param string $field.
   *   Field name for which field validation is happening.
   * 
   * @return string $email.
   *   If all validation is true the return email.
   */
  public function validateEmail($email, $field)
  {
    $this->checkEmpty($email, $field);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->setError($field, "Invalid email format");
    } else {
      return $email;
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
  public function validateMarks($marks, $field)
  {
    $this->checkEmpty($marks, $field);

    $data = explode("\n", $marks);
    $i = 0;

    foreach ($data as $lines) {
      $parts = explode("|", $lines);
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
   * Function getErrors().
   *  To get errors.
   * 
   * @return $this->errors.
   *   Returns the errors.
   */
  public function getErrors()
  {
    return $this->errors;
  }
  /**
   * Function getSubjects().
   *  To get subjects.
   * 
   * @return $this->subjects.
   *   Returns the subjects.
   */
  public function getSubjects()
  {
    return $this->subjects;
  }
  /**
   * Function getMarks().
   *  To get Marks.
   * 
   * @return $this->marks.
   *   Returns the marks.
   */
  public function getMarks()
  {
    return $this->marks;
  }
}
