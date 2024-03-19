<?php
include 'Register.php';

function my_autoloader($class) {
    include  $class . '.php';
}
  
spl_autoload_register('my_autoloader');

$user = new Register_new;
echo $user->_logout() ;

if(true){
    include 'logged_page.html';
}

?>