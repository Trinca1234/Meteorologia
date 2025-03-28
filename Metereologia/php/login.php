<?php
session_start();
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //verificação do metedo
    if (isset($_POST['username']) && isset($_POST['password'])){
        //Dupla verificação da pass e do username
    
        //caminho para o ficheiro
        $fichiero = "../dados/users.txt";

        //ver se o ficheiro existe
        if(file_exists($fichiero)){
    
            //vai passar por todaq as linhas e tirar o nome e a hash da pass 
            foreach (file($fichiero) as $linha) {

                //vai tirar espaços brancos 
                $linha = trim($linha);

                //vai criar duas variaveis com a linha separando por ponto e virgula
                //no ficheiro as variaveis estao username:hash
                list($nome,$pass) = explode(":",$linha);
                
                //se o nome e a pass do ficheiro forem iguais ao que foi enviado no POST vai para o dashboard
                if($_POST['username'] == $nome && (password_verify ($_POST['password'], $pass))){
                    //ir para dashboard
                    echo "entrou";
                    unset($_SESSION['error']); // Remove a mensagem após ser exibida
                    header("Location: ../html/index.php");
                    exit;
                }
            }
            $_SESSION['erro'] = "Username ou Password inválidos";
            header("Location: ../html/index.php");
        }
        else{
            http_response_code(404);
        }
    }
    else{
        http_response_code(400);
    }
 }
 else{
    http_response_code(405);
 }
?>