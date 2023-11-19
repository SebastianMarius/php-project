<?php

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'evenimente_db';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    // daca exista o eroare la conexiune
    exit('Failed to connect to MySQL:' . mysqli_connect_error());
}
// verific daca datele din formular au fost trimise

if (!isset($_POST['email'], $_POST['password'])) {
    // nu s-au putut obtine datele care ar fi trebuit trimise
    exit('Completati username si password!');
}
// pregatiti SQL-ul nostru, pregatirea instructiunii SQL va impiedica injectia SQL

if ($stmt = $con->prepare('SELECT id, password FROM users WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    // stocam rezultatul
    $stmt->store_result();

    if ($stmt->num_rows() > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // contul exista, verificam parola, stocam printr-un hash parola

        if (password_verify($_POST['password'], $password)) {
            // verification success! User has loggedin
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['email'];
            $_SESSION['id'] = $id;
            echo 'Welcome ' . $_SESSION['name'] . '!';
            header('Location: home.html');
        } else {
            // parola gresita
            echo 'Incorect username sau password';
        }
    } else {
        // username incorect
        echo 'Nr of rows = 0';
    }
    $stmt->close();
}


?>