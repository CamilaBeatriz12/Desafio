<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'demo');
 
//Conexão com o banco de dados
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
//Validação da conexão
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>