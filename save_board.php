<?php

include 'Register.php';

  
function my_autoloader($class) {
    include  $class . '.php';
}
  
spl_autoload_register('my_autoloader');
// Odbierz dane POST
$data = file_get_contents("php://input");

// Zamień dane JSON na tablicę PHP
$tab_post = json_decode($data, true);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    echo "Zalogowany użytkownik: $username";
    echo Register_new::_save_board($tab_post);
} else {
    echo "Brak zalogowanego użytkownika.";
}


// echo $user->_logout() ;


?>