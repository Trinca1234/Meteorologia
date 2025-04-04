<?php
header('Content-Type: text/html; charset=utf-8');

//echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo "recebi POST";

    if (isset($_POST['valor'], $_POST['nome'], $_POST['hora'], $_POST['escala'])) {
        $files = "files/" . $_POST['nome'];
        $fichieroLogs = "../logs/logs.json";

        if (file_exists($files) && file_exists($fichieroLogs)) {


            file_put_contents($files . "/valor.txt", $_POST['valor']);
            file_put_contents($files . "/nome.txt", $_POST['nome']);
            file_put_contents($files . "/hora.txt", $_POST['hora']);
            file_put_contents($files . "/escala.txt", $_POST['escala']);

            $log = [
                "nome" => $_POST['nome'],
                "valor" => $_POST['valor'],
                "hora" => $_POST['hora'],
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
            file_put_contents($fichieroLogs, json_encode($logsArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    } else {
        echo "\nparametros invalidos";
    }
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['variavel'], $_GET['info'])) {
        echo file_get_contents("files/".$_GET['variavel']."/".$_GET['info'].".txt");
    }
} else {
    http_response_code(403);
    echo "metedo invalido";
}
