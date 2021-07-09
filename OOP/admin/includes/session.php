<?php
class Session{
    //Klasa sesji odpowiadająca za sesję użytkownika 
    private $signed_in = false;//na początku ustawione false bo nie jest zalogowany odrazu
    public $user_id;//user id 
    public $message;//message któr ma pzrechowywać wiadomość 
    function __construct(){// w konstruktorze odrazu sprawdzamy naszą wiadomość i czy jest zalogowany
        session_start();
        $this->check_the_login();
        $this->check_message();
    }
    public function message($msg=""){//Sparrwdzamy czy Wiadomość nie jest pusta
        if(!empty($msg)){
            $_SESSION['message']=$msg;//Jeżeli nie jest to ustawiamy zmienną sesyjną 
        }
        else{
            return $this->messange;//Jeżeli jest to zwracamy ostatnią wiadomość
        }
    }
    public function check_message(){//Jeżeli zmienna sesyjna jest ustawiona to odrazu ustawiamy tą wiadomośc dla zmiennej
        if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
        }
        else{
            $this->message="";
        }
    }
    public function is_signed_in(){//Zwraca true lub false jeżeli jest zalogowany czy nie 
        return $this->signed_in;
        
    }  
    public function logout(){//Wylogowuje uzytkownika poprzez wyczyszczenie danych i ustawienie signed_in na false
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }
    public function login($user){//Zwykłe ustawienie true i przypisanie id urzytkownikla
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;//user to odwołanie do Naszej klasy USER i id to id tego Usera
            $this->signed_in = true;
        }
    }
    private function check_the_login(){//
        if(isset($_SESSION['user_id'])){
            $this->user_id=$_SESSION['user_id'];//przekazanie sesji do user id tej klasy
            $this->signed_in = true;//zalogowanie
        }
        else{
            unset($this->user_id);
            $this->signed_in = false;//Wylogowanie
        }
    }

}
$session = new Session();//I na sam koniec odrazu tworzymy instancje 

?>