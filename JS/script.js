/**
 * @const NAMEPATTRN.
 *  Store name pattern.
 */
const NAMEPATTRN = /^[a-zA-Z'-]+$/;

/**
 * @const PASSWORDPATTERN.
 *  Store password pattern.
 */
const PASSWORDPATTERN = /^(?=.*[A-Z])(?=.*[\W_])(?=.{5,10}$).*/;

/**
 * @const PHONEPATTERN.
 *  Store phone pattern.
 */
const PHONEPATTERN = /^(\+91)[1-9][0-9]{9}$/;

/**
 * Function to Validate the admin form.
 *
 * @returns {boolean} TRUE(If all validations are true) outerwise FALSE.
 */
function validateAdmin() {

  /**
   * @const fnameInput.
   *  Fetch first name field.
   */
  const fnameInput = document.getElementById("fname");

  /**
   * @const lnameInput.
   *  Fetch last name field.
   */
  const lnameInput = document.getElementById("lname");

  /**
   * @const phoneInput.
   *  Fetch phone field.
   */
  const phoneInput = document.getElementById("phone");

  /**
   * @const marksInput.
   *  Fetch marks field.
   */
  const marksInput = document.getElementById("marks");

  /**
   * @const fname.
   *  Store the first name value.
   */
  const fname = fnameInput.value.trim();

  /**
   * @const lname.
   *  Store the last name value.
   */
  const lname = lnameInput.value.trim();

  /**
   * @const phone.
   *  Store the phone value.
   */
  const phone = phoneInput.value.trim();

  /**
   * @const fname.
   *  Store the marks value.
   */
  const marks = marksInput.value.trim();

  // Check if any field has error or not.
  if (!checkMoreName(fname, fnameInput) || !checkMoreName(lname, lnameInput) || !checkMorePhone(phone, phoneInput) || !checkMoreMarks(marks, marksInput)) {
    return false;
  }

  return true;
}

/**
 * Function validateLoginForm().
 *  To validate the login form details.
 *
 * @returns {boolean} TRUE(If all data is valid). Else FLASE.
 */
function validateLoginForm() {
  /**
   * @const emailInput.
   *  Fetched email field.
   */
  const emailInput = document.getElementById("email");

  /**
   * @const passwordInput.
   *  Fetched password field.
   */
  const passwordInput = document.getElementById("password");

  /**
   * @const email.
   *  Email field value.
   */
  const email = emailInput.value.trim();
  /**
     * @const password.
     *  Password field value.
     */
  const password = passwordInput.value.trim();

  if (!checkEmail(email, emailInput) || !checkMorePassword(password, passwordInput)) {
    return false;
  }
  return true;
}


/**
* Function validateRegisterForm();
*  To validate the user registration form.
*
* @returns {boolean} TRUE (if all field are correctly filled.), else FALSE.
*/
function validateRegisterForm() {
  /**
   * @const emailInput.
   *  Fetched email field.
   */
  const emailInput = document.getElementById("email");

  /**
   * @const passwordInput.
   *  Fetched password field.
   */
  const passwordInput = document.getElementById("password");

  /**
   * @const cpasswordInput.
   *  Fetched confirm password field.
   */
  const cpasswordInput = document.getElementById("cpassword");

  /**
   * @const email.
   *  Email field value.
   */
  const email = emailInput.value.trim();
  /**
     * @const password.
     *  Password field value.
     */
  const password = passwordInput.value.trim();

  /**
   * @const cpassword.
   *  Confirm password field value.
   */
  const cpassword = cpasswordInput.value.trim();

  if (!checkEmail(email, emailInput) || !checkMorePassword(password, passwordInput) || !checkMoreCPassword(cpassword, password, cpasswordInput)) {
    return false;
  }

  return true;
}

/**
 * Function validateForgotPassword().
 *   To validate the forgot password form.
 *
 * @returns {boolean} TRUE(If all validations are true) otherwise FALSE.
 */
function validateForgotPassword() {

/**
 * @const emailInput.
 *    Fetch email field from forgotPassword form.
 */
  const emailInput = document.getElementById("email");

/**
 * @const email.
 *    Value of email field in forgot password form.
 */
  const email = emailInput.value.trim();
  if (!checkEmail(email, emailInput)) {
    return false;
  }
  return true;
}

/**
 * Function checkEmail().
 *  To check the email address.
 *
 * @param {string} email
 * @param {string} fieldName
 *
 * @returns function setError().
 *  If any error is coming else setSuccess().
 */
function checkEmail(email, fieldName) {
  // Validate email.
  if (email === "") {
    return setError(fieldName, 'Email cannot be empty.')
  }
  else {
    return setSuccess(fieldName);
  }
}
/**
* Function to check for names.
*
* @param { string} name.
*    Stores the name value.
*
* @param { string} nameField.
*    Stores the field name.
*/
function checkMoreName(name, nameField) {
  if (name === "") {
    return setError(nameField, 'Name cannot be empty.')
  }
  else if (name.length < 3 || name.length > 20) {
    return setError(nameField, 'Name should be more than 3 and less than 20 characters.');
  }
  else if (!NAMEPATTRN.test(name)) {
    return setError(nameField, 'Name should only contains alphabates and white space.');
  }
  else {
    return setSuccess(nameField);
  }
}

/**
 * Function to check for phone number.
 *
 * @param { string} phone.
 *    Stores thee phone value.
 */
function checkMorePhone(phone, phoneInput) {
  if (phone === "") {
    return setError(phoneInput, 'Phone no. cannot be empty.')
  }

  else if (phone.length != 13) {
    return setError(phoneInput, 'Phone no. should be of 10 digits only.');
  }
  else if (!PHONEPATTERN.test(phone)) {
    return setError(phoneInput, 'Phone no. contains only numbers.');
  }
  else {
    return setSuccess(phoneInput);
  }
}

/**
 * Function to check for subject marks.
 *
 * @param { string} marks.
 *    Stores the textarea values.
 */
function checkMoreMarks(marks, marksInput) {
  if (marks === "") {
    return setError(marksInput, 'This field cannot be empty.');

  }
  else {
    var lines = marks.split('\n');

    for (var i = 0; i < lines.length; i++) {
      var parts = lines[i].split('|');
      if (parts.length !== 2 || parts[0].trim() === "" || parts[1].trim() === "" || !isNaN(parts[0].trim()) || isNaN(parts[1].trim())) {
        return setError(marksInput, 'Please enter valid input. Ex:(Subject|Marks)')

      }
      else if (!NAMEPATTRN.test(parts[0])) {
        return setError(marksInput, 'Please enter valid input. Ex:(Subject|Marks)')

      }
      else {
        return setSuccess(marksInput);
      }
    }
  }
}

/**
   * Function to check for password.
   *
   * @param { string} password.
   */
function checkMorePassword(password, fieldName) {
  // Validate password.
  if (password === "") {
    return setError(fieldName, 'Password cannot be empty.')
  }
  else if (!PASSWORDPATTERN.test(password)) {
    return setError(fieldName, 'Please enter valid password.(Utkarsh@)');
  }
  else {
    return setSuccess(fieldName);
  }
}

/**
 * Function to check for confirm password.
 *
 * @param { string} cpassword.
 */
function checkMoreCPassword(cpassword, password, fieldName) {
  // Validate Confirm password.
  if (cpassword === "") {
    return setError(fieldName, 'Confirm password cannot be empty.');
  }
  else if (cpassword != password) {
    return setError(fieldName, 'Confirm password should be equal to password.');
  }
  else if (cpassword.length < 5 && password.length < 5) {
    return setError(fieldName, 'Passwords should not be less than 5 characters.');
  }
  else {
    return setSuccess(fieldName);
  }
}

/**
 * Function to set the error.
 *
 * @param {string} field.
 *    Store the name of field.
 *
 * @param {string} errorMsg.
 *    Stores error name.
 *
 * @return {boolean} FALSE.
 */
function setError(field, errorMsg) {
  const formDiv = field.parentNode;
  const small = formDiv.querySelector('small');
  formDiv.className = "formDiv error";
  small.innerText = errorMsg;
  return false;
}

/**
 * Set the success message.
 *
 * @param {string} field.
 *    input field name.
 *
 * @return {boolean} TRUE.
 */
function setSuccess(field) {
  const formDiv = field.parentNode;
  formDiv.className = "formDiv success";
  return true;
}
