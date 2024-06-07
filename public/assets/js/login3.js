function validateLogin() {
  // Retrieve the values entered by the user
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  
  // Check if the username is not empty
  if (username == "") {
    alert("Please enter a username.");
    return false;
  }
  
  // Check if the password is not empty
  if (password == "") {
    alert("Please enter a password.");
    return false;
  }
  
  // Check if the username and password match
  if (username == "ad" && password == "123") {
    alert("Login successful.");
    return true;
  } else {
    alert("Incorrect username or password.");
    return false;
  }
}
