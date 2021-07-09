<?php
//Tu są wszystkie pliki które zostaną później dołączone do naszej strony
defined('DS')?null:define('DS',DIRECTORY_SEPARATOR);//sprawdzenie czy ta zmienna zostąła dodana i potem jeżeli tak to ustawiamy null i jeżeli nie to ustawiamy naszą absulotna ścieżke do projektu
//directy separator to / lub \
define('SITE_ROOT','D:'.DS.'Xamp'.DS.'htdocs'.DS.'OOP');//ustawiamy do site roota nasza scieżke
defined('INCLUDES_PATH')?null:define('INCLUDES_PATH',SITE_ROOT.DS.'admin'.DS.'includes');//i tu scieżka do includes
require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("user.php");
require_once("session.php");
require_once("db_object.php");
require_once("photo.php");
?>