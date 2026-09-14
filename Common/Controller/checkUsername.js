function checkUsername() {
  let username = document.getElementById("username").value;
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("response").innerHTML = this.responseText;
    } else {
      document.getElementById("response").innerHTML = this.status;
    }
  };
  // NOTE: this resolves relative to the PAGE url (View/registration.php),
  // not this script's own src path, so it must point into ../Controller/
  xhttp.open("POST", "../Controller/HandleAjax.php", true);
  xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhttp.send("username=" + username);
}
