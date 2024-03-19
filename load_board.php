<?php

include 'Register.php';

  
function my_autoloader($class) {
    include  $class . '.php';
}
  
spl_autoload_register('my_autoloader');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    //echo "Zalogowany użytkownik: $username";
    $loaded_board =  Register_new::_load_board();
    //echo json_encode($loaded_board);
    echo $loaded_board;
} else {
    //echo "Brak zalogowanego użytkownika.";
}


?>