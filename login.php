<?php
include 'Register.php';

  
function my_autoloader($class) {
    include  $class . '.php';
}
  
spl_autoload_register('my_autoloader');
  

session_start();
$user = new Register_new;
echo $user->_login() ;

if($user->_is_logged()){
    include 'logged_page.html';
}


?>