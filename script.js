function homer() {
    window.location.href = "home.php";
}
function producter() {
    window.location.href = "products.php";
}
function loginer() {
    window.location.href = "login.php";
}
function buynow() {
    window.location.href = "buynow.php";
}
function checkPassMatch() {
    var pass = document.getElementById("newpass").value;
    var conf = document.getElementById("confpass").value;

    if(pass != conf){
        document.getElementById("checkpass").innerHTML = "Passwords do not match";
    } else {
        document.getElementById("checkpass").innerHTML = "";
    }
}