<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

}
if(email($name, $email, $message)){
    echo "Email sent";
}
else{
    echo "Email failed to send";
}
?>

