<?php
function classAutoLoader($class){
// skanuje nasze pliki i spawdza czy nie ma zadeklarowanych klas czy metod
$class = strtolower($class);
$the_path = "includes/{$class}.php";//ścierzki 

if(is_file($the_path)&& !class_exists($class)){//sparwdzanie czy dany plik istnieje

    include($the_path);

}
else{ 
    die("This file name {$class}.php was not found man...");
}
}
function redirect($location){
    header("Location: {$location}");
}
spl_autoload_register('classAutoLoader');
?>