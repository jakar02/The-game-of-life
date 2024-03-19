<?php
class Register {
    protected $data = array() ; //nie jest widoczna na zewnątrz klasy i może być dziedziczona
    function __construct () { //Wywoływana automatycznie podczas inicjalizacji obiektu
    }
    
    function _read () {
        //$_POST tablica superglobalna przechowująca dane przesłane metoda POST
        $this->data['usernameregister'] = $_POST['usernameregister'] ;
        $this->data['passwordregister'] = $_POST['passwordregister'] ;
    }
    
}




class Register_new extends Register{ //
    public $current_user;
    private $dbh;
    private $dbfile = "datadb.db" ;
    //private $dbh2;
    //private $dbnotes = "notesdb.db" ;
   
    function __construct () {
       parent::__construct() ;  
       session_set_cookie_params([

             'lifetime' => 300,
             'path' => '/~1karas/Projekt/',                 // konto na ktorym dziala serwis 
             'domain' => $_SERVER['pascal.fis.agh.edu.pl'], 
             'secure' => true,                   // serwer Pascal - tylko http
             'httponly' => false,
             'samesite' => 'LAX'
         ]);       
       session_start() ;
    }
   
 /*
  *  Zapis danych do bazy
  */
   
    function _save() {
        $this->dbh = dba_open($this->dbfile, "c");
        
        if (!dba_exists($this->data['usernameregister'], $this->dbh)) {
            $user = $this->data['usernameregister'];
            // Haszowanie hasła przed zapisaniem do bazy danych
            $hashed_password = password_hash($this->data['passwordregister'], PASSWORD_DEFAULT);
            $this->data['passwordregister'] = $hashed_password;

            // Zapis haszowanego hasła do bazy danych
            $json_data = json_encode($this->data);
            dba_insert($this->data['usernameregister'], $json_data, $this->dbh);

            $text = 'Dane zostały zapisane';
        } else {
            $text = 'Dane dla tego username są w bazie danych';
        }

        dba_close($this->dbh);
        return $text;
    }

    // public static function _getUser(){
    //     return $current_user;
    // }

    function _login() {
        $usernamelogin = $_POST['usernamelogin'];
        $passwordlogin = $_POST['passwordlogin'];
        $access = false;

        $this->dbh = dba_open($this->dbfile, "r");
        $_SESSION['auth'] = 'BAD';

        if (dba_exists($usernamelogin, $this->dbh)) {
            $json_data = dba_fetch($usernamelogin, $this->dbh);
            $this->data = json_decode($json_data, true);

            // Sprawdzenie hasła przy użyciu password_verify
            if (password_verify($passwordlogin, $this->data['passwordregister'])) {
                $_SESSION['auth'] = 'OK';
                $_SESSION['user'] = $usernamelogin;
                $access = true;
            }
        }

        dba_close($this->dbh);
        $text = ($access ? 'Użytkownik zalogowany' : 'Błędne dane logowania');
        return $text;
    }

    function _is_logged() {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === 'OK';
    }  

    /* Wylogowanie uzytkownika do serwisu */
    function _logout() {
        unset($_SESSION);
        session_destroy();
        $text = 'Uzytkownik wylogowany ' ;
        return $text ;
    }

    public static function _save_board($boardData) {
        
        $dbfile2 = "boards.db" ;
        $dbh2 = dba_open($dbfile2, "c");
        $username = $_SESSION['user'];
        echo "\nsave_board\n";
    
        // // Przygotuj dwuwymiarową tablicę booleanów do zapisu
        $json_data = json_encode($boardData);
    
        if (!dba_exists($username, $dbh2)) {
            echo '\nistnieje w bazie';
        }
        // // Zapisz do bazy danych
        dba_replace($username, $json_data, $dbh2);
    
        $text = 'Dane planszy zostały zapisane\n';
    
        dba_close($dbh2);
        return $text;
    }

    public static function _load_board() {
        $dbfile2 = "boards.db";
        $dbh2 = dba_open($dbfile2, "c");
        $username = $_SESSION['user'];
        //echo "\nload_board\n";
    
        // Sprawdzenie, czy użytkownik istnieje w bazie
        if (dba_exists($username, $dbh2)) {
            // Pobranie tablicy dwuwymiarowej dla danego użytkownika
            //$board = unserialize(dba_fetch($username, $dbh2));
            $board = dba_fetch($username, $dbh2);
            dba_close($dbh2);
            //echo 'Dane planszy zostały załadowane\n';
            return $board;
        }
    
        return $board;
    }
 }
?>