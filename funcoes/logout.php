<?php
//Destroi a sessão e apaga variaveis 
session_start();
session_unset();
session_destroy();

//Redireciona para a pagina de login
header("Location: ../index.php");
exit(); 
?>
