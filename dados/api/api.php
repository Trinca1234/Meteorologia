<?php
header('Content-Type: text/html; charset=utf-8');

//echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['valor'], $_POST['nome'], $_POST['escala'])) {
        $files = "files/" . $_POST['nome'];
        $fichieroLogs = "../logs/logs.json";

        if (file_exists($files) && file_exists($fichieroLogs)) {
            date_default_timezone_set('Europe/Lisbon');

            file_put_contents($files . "/valor.txt", $_POST['valor']);
            file_put_contents($files . "/nome.txt", $_POST['nome']);
            file_put_contents($files . "/escala.txt", $_POST['escala']);

            $log = [
                "nome" => $_POST['nome'],
                "valor" => $_POST['valor'],
                "hora" => date('Y/m/d H:i'),
                "escala" => $_POST['escala']
            ];

            //vamos buscar o conteudo do ficheiro e organizar 
            $conteudo = file_get_contents($fichieroLogs);

            //transforma o conteudo do ficheiro em um array associativo
            $logsArray = json_decode($conteudo, True);

            //vai criar um array de logs caso nao exista
            if (!isset($logsArray['logs'])) {
                $logsArray['logs'] = [];
            }

            //dentro do array logs, vai ser adicionar o log acabado de criar
            $logsArray['logs'][] = $log;

            //vai escrever nos logs de maneira bonita e legivel
            file_put_contents($fichieroLogs, json_encode($logsArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }
    }
     else {
        http_response_code(400);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['variavel'], $_GET['info'])) {
        echo file_get_contents("files/".$_GET['variavel']."/".$_GET['info'].".txt");
    }
} else {
    http_response_code(403);
}
