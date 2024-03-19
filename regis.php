<?php
include 'Register.php';

/* php5, php7
function __autoload($class_name) {
    include $class_name . '.php' ;
}
 */
  
function my_autoloader($class) {
    include  $class . '.php';
}
  
spl_autoload_register('my_autoloader');
  
/* Or, using an anonymous function
spl_autoload_register(function ($class) {
    include  $class . '.php';
});
*/


//rejestracja
$reg = new Register_new ;
$reg->_read();
echo $reg->_save();
echo $user->_login() ;

if($user->_is_logged()){
    include 'logged_page.html';
}

?>