<?php
//Destroi a sessão
session_start();
session_unset();
session_destroy();

//Redirecionar para a pagina de login
header("Location: ../php/index.php");
exit(); 
?>
