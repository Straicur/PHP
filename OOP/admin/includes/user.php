<?php
class User extends Db_object{
    // dlatego warto myśleć abstrakcyjnie
    protected static $db_table = "users";//Chodzi o to że tego statica możesz gdzie inndziej użyć i wtedy te metody z usera mają sens bytu gdzie inndziej
    protected static $db_table_fields = array('username','password','first_name','last_name,user_image');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directiry="images";
    public $image_placeholder="http://placehold.it/400x400&text=image";


    public $tmp_path;//ścieżka
    public $upload_directory = "images";//folder do uploadu
    public $errors=array();//tablica na nasze customowe errory
    public $upload_errors_array=array(
        UPLOAD_ERR_OK =>"There is no error",
        UPLOAD_ERR_INI_SIZE =>"The upoaded file is to big",
        UPLOAD_ERR_FORM_SIZE =>"The upoaded file is to big again",
        UPLOAD_ERR_PARTIAL =>"The upoaded file was only patially uploaded",
        UPLOAD_ERR_NO_FILE =>"No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR =>"Missing a tempoary folder",
        UPLOAD_ERR_CANT_WRITE =>"Filedto write file to disk",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"
    );
    public function user_image(){//zwraca nam ścieche do pliku z images dla tych awatarów
        return empty($this->user_image)?$this->image_placeholder:$this->upload_directiry.DS.$this->user_image;
    }
    public function verify_user($username,$password){//Metoda odpowiedzialna za zwrócenie danych uzytkownika , może być wykorzystana do logowania
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        $sql="SELECT * FROM ".self::$db_table." WHERE username = '{$username}' AND password='{$password}' LIMIT 1";
        $result_array = self::find_this_query($sql);

        return !empty($result_array)? array_shift($result_array):false;


    }
    public function set_file($file){
        if(empty($file)||!$file||!is_array($file)){
            $this->errors[]="There was no file uploaded here";
            return false;
        }
        elseif($file['error'] !=0)
        {
            $this->errors[]=$this->upload_errors_array[$file['error']];//Jeżeli error nie jest równt 0 czyli UPLOAD_ERR_OK  to przrypisujemy do naszych erroów odpowiednią stałą
            return false;
        }
        else{
            // tu ustawiamy dla naszej klasy zmienne
            $this->user_image = basename($file['name']);//basename czyści nam scieżke
            $this->tmp_path=$file['tmp_name'];
            $this->type=$file['type'];
            $this->size=$file['size'];
        }
        

    }
    public function save_photo(){// zapisywanie zdjecia
        if($this->id){//sprawdzamy czy mamy id
            $this->update();//No i update 
        }
        else{//no i jeżeli nie ma id to tworzymy 
            if(!empty($this->errors)){//jeżeli tablica z errorami nie jest pusta to zwracamy false
                return false;
            }
            if(empty($this->user_image)||empty($this->tmp_path)){// Jeżeli któraś z tych zmiennych jest pusta to dodajemy błąd i false
                $this->errors[]="The file was not available";
                return false;
            }
            $target_path=SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->user_image;//tworzymy scieżke do tego pliku
            if(file_exists($target_path)){//Jeżeli ten plik już istnieje to wywalamy i error
                $this->errors[]="This file {$this->user_image} already exists";
                return false;
            }
            if(move_uploaded_file($this->tmp_path,$target_path)){//najpierw podajemy nazwę pliku a 2 argument to gdzie ma być 
                if($this->create()){//po tym jak uda sie nam to przenieść to tworzymy i usuwamy nazwę bo jej już nie potrzebujemy 
                    unset($this->tmp_path);
                    return true;
                }
            }
            
            else{
                $this->errors[]="There is some problem with permisions";
                return false;
            }
            
        }
    }
   

}
