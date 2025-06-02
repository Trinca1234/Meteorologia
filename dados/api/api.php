<?php
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['valor'], $_POST['nome'])) {

        //indicar caminho
        $files = "files/" . $_POST['nome'];
        $fichieroLogs = "../logs/logs.json";


        if (file_exists($files) && file_exists($fichieroLogs)) {
            //defenir o horario de lisboa
            date_default_timezone_set('Europe/Lisbon');

            file_put_contents($files . "/valor.txt", $_POST['valor']);
            file_put_contents($files . "/nome.txt", $_POST['nome']);
            file_put_contents($files . "/hora.txt", date('Y/m/d H:i'));
            //se for um post de sensor
            if(isset($_POST['escala'])){
                //escrever em cada um dos ficheiros respetivos o seu valor
                file_put_contents($files . "/escala.txt", $_POST['escala']);
    
                //faz o log com todos os valores acabados de receber
                $log = [
                    "nome" => $_POST['nome'],
                    "valor" => $_POST['valor'],
                    "hora" => date('Y/m/d H:i'),
                    "escala" => $_POST['escala']
                ];
                EscreverLog($log,$fichieroLogs);
            }
            //se for um post de atuador
            elseif(isset( $_POST['estado'])){
                file_put_contents($files . "/escala.txt", $_POST['escala']);
                $log = [
                    "nome" => $_POST['nome'],
                    "valor" => $_POST['valor'],
                    "hora" => date('Y/m/d H:i'),
                    "estado" => $_POST['estado']
                ];
                EscreverLog($log,$fichieroLogs);
            }
            //vai verificar as condições dos atuadores , escrevendo e adicionando logs de cada um
            /*
            if ($_POST['nome'] === 'temperatura') {

                $AtuadorValor = floatval($_POST['valor']) > 20 ? 'Ligado' : 'Desligado';

                if (!(file_get_contents("files/arCondicionado/valor.txt") === $AtuadorValor)) {
                    $log = [
                        "nome" => 'arCondicionado',
                        "valor" => $AtuadorValor,
                        "hora" => date('Y/m/d H:i'),
                    ];
                    EscreverLog($log,$fichieroLogs);
                }

                file_put_contents("files/arCondicionado/nome.txt", 'arCondicionado');
                file_put_contents("files/arCondicionado/valor.txt", $AtuadorValor);
                file_put_contents("files/arCondicionado/hora.txt", date('Y/m/d H:i'));
            }

            if ($_POST['nome'] === 'temperatura' || $_POST['nome'] === 'humidade') {
                $AtuadorValor = floatval(file_get_contents('files/humidade/valor.txt')) <= 50 | file_get_contents('files/temperatura/valor.txt') > 20 ? 'Ligado' : 'Desligado';

                if (!(file_get_contents("files/regador/valor.txt") === $AtuadorValor)) {
                    $log = [
                        "nome" => 'regador',
                        "valor" => $AtuadorValor,
                        "hora" => date('Y/m/d H:i'),
                    ];
                    EscreverLog($log,$fichieroLogs);
                }

                file_put_contents("files/regador/" . "nome.txt", 'regador');
                file_put_contents("files/regador/" . "valor.txt", $AtuadorValor);
                file_put_contents("files/regador/" . "hora.txt", date('Y/m/d H:i'));
            }


            if ($_POST['nome'] === 'luminosidade') {
                $AtuadorValor = $_POST['valor'] < 50 ? 'Ligado' : 'Desligado';

                if (!(file_get_contents("files/led/valor.txt") === $AtuadorValor)) {
                    $log = [
                        "nome" => 'led',
                        "valor" => $AtuadorValor,
                        "hora" => date('Y/m/d H:i'),
                    ];
                    EscreverLog($log,$fichieroLogs);
                }


                file_put_contents("files/led/" . "nome.txt", 'led');
                file_put_contents("files/led/" . "valor.txt", $AtuadorValor);
                file_put_contents("files/led/" . "hora.txt", date('Y/m/d H:i'));
            }
            */
        }
    } else {
        http_response_code(400);
    }
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['variavel'], $_GET['info'])) {
        echo file_get_contents("files/" . $_GET['variavel'] . "/" . $_GET['info'] . ".txt");
    }
} else {
    http_response_code(403);
}
function EscreverLog($log,$fichieroLogs){
            //vamos buscar o conteudo do ficheiro e organizar 
            $conteudo = file_get_contents($fichieroLogs);

            //transforma o conteudo do ficheiro em um array associativo
            $logsArray = json_decode($conteudo, True);

            //vai criar um array de logs caso nao exista
            if (!isset($logsArray['logs'])) {
                $logsArray['logs'] = [];
            }

            //dentro do array logs, vai ser adicionado o log acabado de criar
            $logsArray['logs'][] = $log;

            //vai escrever nos logs de maneira bonita e legivel
            file_put_contents($fichieroLogs, json_encode($logsArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
       
}