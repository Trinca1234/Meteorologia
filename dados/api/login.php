<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //verificação do metedo
    if (isset($_POST['username']) && isset($_POST['password'])) {
        //Dupla verificação da pass e do username

        //caminho para o ficheiro
        $fichiero = "../users.txt";

        //ver se o ficheiro existe
        if (file_exists($fichiero)) {

            //vai passar por todaq as linhas e tirar o nome e a hash da pass 
            foreach (file($fichiero) as $linha) {

                //vai tirar espaços brancos 
                $linha = trim($linha);

                //vai criar duas variaveis com a linha separando por ponto e virgula
                //no ficheiro as variaveis estao username:hash
                list($nome, $pass) = explode(":", $linha);

                //se o nome e a pass do ficheiro forem iguais ao que foi enviado no POST vai para o dashboard
                if ($_POST['username'] == $nome && (password_verify($_POST['password'], $pass))) {
                    //ir para dashboard

                    if(isset($_SESSION['error'])){
                        unset($_SESSION['error']);
                    }
                    
                    $_SESSION['username'] = $_POST['username'];
                    header("Location: ../../php/dashboard.php");
                    exit;
                }
            }
            //variavel com o texto que vai aparecer na pagina de login
            $_SESSION['erro'] = "Username ou Password inválidos";
            header("Location: (../../php/index.php");
        } else {
            ErrorHandling("Erro 404: Ficheiro não encontrado.", 404);
        }
    } else {
        ErrorHandling("Erro 400: Pedido Inválido.", 400);
    }
} else {
    ErrorHandling("Erro 405: Métedo não permitido.", 405);
}
function ErrorHandling($msg, $erro): never
{
    //função que vai tratar de cada tipo de erros
    $index = "../../php/index.php";

    http_response_code($erro);
    header("Refresh:3; url=" . $index);
    die($msg);
}
