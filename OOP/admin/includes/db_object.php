<?php
class Db_object{
    public static function find_all(){//Zwykłe wywołanie metody statycznej dla tego zapytania
        return static::find_this_query("SELECT * FROM ".static::$db_table." ");//late static binding //self nie działa przy rozszerzaniu dlatego zamienione są na static
    }
    public static function find_by_id($id){//Znajduje wszystkich uzytkowników i zwraca tablicę jeżeli cos jest , na tym przykładzie można stworzyć instancje i na niej wykonywać odpowiednie operacje 
        $result_array = static::find_this_query("SELECT * FROM ".static::$db_table." WHERE id=$id LIMIT 1");
        return !empty($result_array)? array_shift($result_array) : false;//array_shift zwraca pierwszy rekord tablicy

            
    }
    public static function find_this_query($query){//Medota odpowiedzialna za wykonanie naszego zaputania 
        global $database;//Zmienna globalna odpowiedzialna za naszą bazę , instancja bazy
        $result_set = $database->query($query);//Wywołanie metody query naszej bazy i przrekazanie naszego zapytanie do niej
        $object_array = array();//tworzenie pustej tablicy
        while ($row = mysqli_fetch_array($result_set)){//metoda która zwraca nam poszczegulne wiersze pobranej tablicy 
           $object_array[] = static::instantation($row);// przypisanie zmiennych odczytanych z metody 
        }
        return $object_array;
    }


    public static function instantation($the_record){//metoda która zwraca nam dane z przkazanej tablicy fetch_array
        $calling_class=get_called_class();
        $the_object = new $calling_class;//tworzysz instancje 

        // $the_object -> id = $found_user['id'];
        // 
        // $the_object -> password = $found_user['password'];
        // $the_object -> first_name = $found_user['first_name'];
        // $the_object -> last_name = $found_user['last_name']; 
        foreach($the_record as $key=>$value){
            if($the_object->has_the_attribute($key)){//sprawdzamy czy posiada cokolwiek
                $the_object->$key = $value; //$the_object -> username = $found_user['username']; found_user to value
            }
        }
        
        return $the_object;
    }
    private function has_the_attribute($key){//metoda sprawdzajaca czy obiekty klas maja klucz
        $object_properties = get_object_vars($this);//zwraca tablice 
        return array_key_exists($key,$object_properties);//Sprawdzenie które wyżuca false lub true
    }
    
    protected function properies(){//metoda która przypisuje nam wszystkie dane tej klasy do tablicy 
        //return get_object_vars($this); //zwraca wszystkie wartości naszego obiektu
        $properties = array();
        foreach(static::$db_table_fields  as $db_field){
            if(property_exists($this,$db_field)){
                $properties[$db_field]=$this->$db_field;
            }
        }
        return $properties;
    }

    protected function clean_properties(){//metoda tworząca "Czyste" dane bo nie filtrujemy ich w funkcji propercies
        global $database;
        $clean_properties=array();
        foreach($this->properies()  as $key=>$value){
            $clean_properties[$key]=$database->escape_string($value);
        }
        return $clean_properties;
    }

    public function save(){//metoda która w zależności czy id istniej to da nam update i jesli nie to stworzy 
        return isset($this->id)?$this->update():$this->create();
    }



    public function create(){//Metoda tworzaca nam urzytkownika 
        global $database;
        $properties=$this->clean_properties();

        // $usernam=$database->escape_string($this->username);
        // $pass=$database->escape_string($this->password);
        // $first=$database->escape_string($this->first_name);
        // $last=$database->escape_string($this->last_name);
        $sql = "INSERT INTO ".static::$db_table."(".implode(",",array_keys($properties)).")".
        " VALUES ('".implode("','",array_values($properties))."')";
        //implode dodaje jakiś znak do tablicy i zamienia na stringa całą
        //a array_keys wyrzucca klucze czyli to co chcemy wsumie 
        
        if($database->query($sql))//spawdzenie czy zostął dodany
        {
            $this->id=$database->the_isert_id();//tu wykorzystujemu metode z bazy która zwraca ostatni dodany id o przypisuje do id tej klasy i zwsarac true 
            return true;
        }
        else
        {
            return false;
        }
    }



    public function update(){// metoda która aktualizuje dane 
        global $database;
        $properties=$this->clean_properties();
        $properties_pairs = array();
        foreach( $properties  as $key=>$value){// tu przekazujemy przefiltrowane dane i odpowiedznio formatujemy
            $properties_pairs[]="{$key}='{$value}'";
        }
         $i=$database->escape_string($this->id);
        // $usernam=$database->escape_string($this->username);
        // $pass=$database->escape_string($this->password);
        // $first=$database->escape_string($this->first_name);
        // $last=$database->escape_string($this->last_name);

        //$sql = "UPDATE ".self::$db_table." SET username ='$usernam',password ='$pass',first_name='$first',last_name='$last' WHERE id='$i'";
        $sql = "UPDATE " .static::$db_table." SET ".implode(", ",$properties_pairs) ." WHERE id='$i'";//implode działa tak że przechodzi po każdym z rekordów i dodaje nam ten znak i oczywiście zwraca go po dodaniu 
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }



    public function delete(){//metoda która usuwa usera . Poprostu pobiera id klasy którą uzyjemy i usuwa ja 
        global $database;

        $i=$database->escape_string($this->id);
    
        $sql = "DELETE FROM ".static::$db_table." WHERE id = $i LIMIT 1";
        
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }
}
?>