<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempo Certo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../dados/imagens/icon.png">
    <script>
        // Define the base API URL depending on the host
        const protocolo = location.protocol;
        const host = location.hostname;
        const apiUrl = (host === "localhost") ?
            `${protocolo}//${host}/Meteorologia/dados/api/api.php?` :
            `${protocolo}//${host}/ti/ti113/dados/api/api.php?`;

        // Map of variables to update
        const sensores = ["temperatura", "humidade", "luminosidade"];
        const atuadores = ["arCondicionado", "regador", "led"];

        function updateDados() {
            sensores.forEach(variavel => {
                updateSensor(variavel);
            });
            atuadores.forEach(variavel => {
                updateAtuador(variavel);
            });
        }

        function updateSensor(variavel) {
            Promise.all([
                fetch(apiUrl + `variavel=${variavel}&info=valor`).then(r => r.text()),
                fetch(apiUrl + `variavel=${variavel}&info=nome`).then(r => r.text()),
                fetch(apiUrl + `variavel=${variavel}&info=escala`).then(r => r.text()),
                fetch(apiUrl + `variavel=${variavel}&info=hora`).then(r => r.text())
            ]).then(([valor, nome, escala, hora]) => {
                const valorNum = parseFloat(valor);
                const imageElement = document.querySelector(`#img-${variavel}`);
                const textElement = document.querySelector(`#info-${variavel}`);
                const horaElement = document.querySelector(`#hora-${variavel}`);

                let imgSrc;
                if (variavel === "temperatura") {
                    imgSrc = valorNum < 20 ? "../dados/imagens/temperaturaBaixa.png" : "../dados/imagens/temperaturaAlta.png";
                } else if (variavel === "humidade") {
                    imgSrc = valorNum < 50 ? "../dados/imagens/humidadeBaixa.png" : "../dados/imagens/humidadeAlta.png";
                } else if (variavel === "luminosidade") {
                    imgSrc = valorNum < 50 ? "../dados/imagens/luminosidadeBaixa.png" : "../dados/imagens/luminosidadeAlta.png";
                }

                imageElement.src = imgSrc;
                textElement.innerHTML = `<strong>${nome.charAt(0).toUpperCase() + nome.slice(1)}: ${valor}${escala}</strong>`;
                horaElement.textContent = hora;
            });
        }

        function updateAtuador(variavel) {
            Promise.all([
                fetch(apiUrl + `variavel=${variavel}&info=nome`).then(r => r.text()),
                fetch(apiUrl + `variavel=${variavel}&info=valor`).then(r => r.text()),
                fetch(apiUrl + `variavel=${variavel}&info=hora`).then(r => r.text())
            ]).then(([nome, valor, hora]) => {
                const nomeElement = document.querySelector(`#nome-${variavel}`);
                const valorElement = document.querySelector(`#valor-${variavel}`);
                const horaElement = document.querySelector(`#hora-${variavel}`);
                const checkbox = document.querySelector(`#switch-${variavel}`);

                if (nomeElement) nomeElement.textContent = nome.charAt(0).toUpperCase() + nome.slice(1);
                if (valorElement) valorElement.textContent = valor.charAt(0).toUpperCase() + valor.slice(1);
                if (horaElement) horaElement.textContent = hora;
                if (checkbox) checkbox.checked = valor.trim().toLowerCase() === 'ligado';
            });
        }
        setInterval(updateDados, 5000);
        updateDados();
    </script>

</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        $_SESSION['erro'] = "É necessário login para entrar.";
        header('Location: index.php');
        exit();
    }

    //verificar qual o protocolo (https ou http)
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    //vai ver o Host do servidor  
    $host = $_SERVER['HTTP_HOST'];

    if ($host === "localhost") {
        //se for local host
        $url = $protocolo . "://" . $host . "/Meteorologia/dados/api/api.php?";
    } else {
        //com as duas informações contrui um url para conseguir o pedido de dados
        $url = $protocolo . "://" . $host . "/ti/ti113/dados/api/api.php?";
    }

    ?>
    <header class="bg-white border-bottom sticky-header">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h1 class="h3 mb-0"><img src="../dados/imagens/TempoCerto_noBG.png" alt="Logotipo" style="max-height: 60px;">
                        <span class="text-muted p-4 h5">
                            <?php
                            //verifica se a variavel admin existe para poder disponibilizar o historico
                            if (isset($_SESSION['admin'])) {
                                echo ' <a href="historico.php">Historico</a></span><span class="text-muted p-1 h5"> <a href="galeria.php">Galeria</a> </span>';
                            }
                            ?>
                    </h1>
                </div>
                <div class="col-md-6 text-md-end">
                    <form class="d-flex justify-content-end" action="../funcoes/logout.php" method="POST">
                        <button type="submit" class="btn btn-danger">
                            <img src="logout-icon.png" alt="Logout" width="20" height="20">
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </header>
    <main class="main-content py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card border border-dark">
                        <div class="card-header widjet">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="h5 mb-0">Leiria</h2>
                                    <p class="text-muted small mb-0">
                                        <?php

                                        //array associativo para poder passar os nomes em ingles devolvidos da função para portugues
                                        $diaDaSemana = [
                                            'Monday' => 'Segunda-feira',
                                            'Tuesday' => 'Terça-feira',
                                            'Wednesday' => 'Quarta-feira',
                                            'Thursday' => 'Quinta-feira',
                                            'Friday' => 'Sexta-feira',
                                            'Saturday' => 'Sábado',
                                            'Sunday' => 'Domingo'
                                        ];

                                        $dataAtual = date("l");
                                        echo $diaDaSemana[$dataAtual];

                                        ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body wijetbody">
                            <p class="fs-5 mb-4">Descrição</p>
                            <!-- cartoes com as informaçoes dos sensores -->
                            <div class="row g-3">
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark efeitoAumentar">
                                        <div class="card-header sensor header text-center " id="info-temperatura">
                                            <?php
                                            $imagem  = file_get_contents($url . "variavel=temperatura&info=valor") < 20 ? '../dados/imagens/temperaturaBaixa.png' : '../dados/imagens/temperaturaAlta.png';
                                            echo '<strong>' . ucfirst(file_get_contents($url . "variavel=temperatura&info=nome")) . ": "
                                                . file_get_contents($url . "variavel=temperatura&info=valor") .
                                                file_get_contents($url . "variavel=temperatura&info=escala") .
                                                '</strong>' . ' </div>
                                                <div class="card-body text-center">
                                                <img style="max-height: 160px;" src="' . $imagem . '" alt="Temperatura" id="img-temperatura" />
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo '<span id="hora-temperatura">' . ucfirst(file_get_contents($url . "variavel=temperatura&info=hora")) . '</span>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark efeitoAumentar">
                                        <div class="card-header sensor header text-center" id="info-humidade">
                                            <?php
                                            $imagem  = file_get_contents($url . "variavel=humidade&info=valor") < 50 ? '../dados/imagens/humidadeBaixa.png' : '../dados/imagens/humidadeAlta.png';
                                            echo '<strong>' . ucfirst(file_get_contents($url . "variavel=humidade&info=nome")) . ": "
                                                . file_get_contents($url . "variavel=humidade&info=valor") .
                                                file_get_contents($url . "variavel=humidade&info=escala") .
                                                '</strong>' . ' </div>
                                                <div class="card-body text-center">
                                                <img style="max-height: 160px;" src="' . $imagem . '" alt="Humidade" id="img-humidade" />
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo '<span id="hora-humidade">' . ucfirst(file_get_contents($url . "variavel=humidade&info=hora")) . '</span>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark efeitoAumentar">
                                        <div class="card-header sensor header text-center" id="info-luminosidade">
                                            <?php
                                            $imagem  = file_get_contents($url . "variavel=luminosidade&info=valor") < 50 ? '../dados/imagens/luminosidadeBaixa.png' : '../dados/imagens/luminosidadeAlta.png';
                                            echo '<strong>' . ucfirst(file_get_contents($url . "variavel=luminosidade&info=nome")) . ": "
                                                . file_get_contents($url . "variavel=luminosidade&info=valor") .
                                                file_get_contents($url . "variavel=luminosidade&info=escala") .
                                                '</strong>' . ' </div>
                                                <div class="card-body text-center">
                                                <img style="max-height: 160px;" src="' . $imagem . '" alt="Luminosidade" id="img-luminosidade" />
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo '<span id="hora-luminosidade">' . ucfirst(file_get_contents($url . "variavel=luminosidade&info=hora")) . '</span>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-12">
                    <div class="card border border-dark">
                        <div class="card-header widjet">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="h5 mb-0">Atuadores</h2>
                                </div>
                            </div>
                        </div>
                        <!-- cartao com as informaçoes dos atuadores -->
                        <div class="card-body wijetbody">
                            <div class="row g-3">
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark efeitoAumentar">
                                        <div class="card-header sensor header text-center" id="info-arCondicionado">
                                            <form class="d-flex justify-content-start" action="../api/api.php" method="GET">
                                                <label class="switch">
                                                    <input type="checkbox" id="switch-arCondicionado" name="ar_condicionado" value="off">
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                            <strong id="nome-arCondicionado">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=arCondicionado&info=nome")); ?>
                                            </strong>
                                            <p class="text-muted small mb-0" id="valor-arCondicionado">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=arCondicionado&info=valor")); ?>
                                            </p>
                                        </div>

                                        <div class="card-body text-center">
                                            <img style="max-height: 160px;" src="../dados/imagens/AC.png" alt="Ar Condicionado" />
                                        </div>

                                        <div class="card-footer footer text-center">
                                            <strong>Atualização:</strong>
                                            <span id="hora-arCondicionado">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=arCondicionado&info=hora")); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark efeitoAumentar">
                                        <div class="card-header sensor header text-center" id="info-regador">
                                            <form class="d-flex justify-content-start" action="../api/api.php" method="GET">
                                                <label class="switch">
                                                    <input type="checkbox" id="switch-regador" name="regador" value="off">
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                            <strong id="nome-regador">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=regador&info=nome")); ?>
                                            </strong>
                                            <p class="text-muted small mb-0" id="valor-regador">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=regador&info=valor")); ?>
                                            </p>
                                        </div>

                                        <div class="card-body text-center">
                                            <img style="max-height: 160px;" src="../dados/imagens/regador.png" alt="Regador" />
                                        </div>

                                        <div class="card-footer footer text-center">
                                            <strong>Atualização:</strong>
                                            <span id="hora-regador">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=regador&info=hora")); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark efeitoAumentar">
                                        <div class="card-header sensor header text-center" id="info-led">
                                            <form class="d-flex justify-content-start" action="../api/api.php" method="GET">
                                                <label class="switch">
                                                    <input type="checkbox" id="switch-led" name="led" value="off">
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                            <strong id="nome-led">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=led&info=nome")); ?>
                                            </strong>
                                            <p class="text-muted small mb-0" id="valor-led">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=led&info=valor")); ?>
                                            </p>
                                        </div>

                                        <div class="card-body text-center">
                                            <img style="max-height: 160px;" src="../dados/imagens/led.png" alt="LED" />
                                        </div>

                                        <div class="card-footer footer text-center">
                                            <strong>Atualização:</strong>
                                            <span id="hora-led">
                                                <?php echo ucfirst(file_get_contents($url . "variavel=led&info=hora")); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Imagem -->
            <div class="row g-4 mt-4">
                <div class="col-12">
                    <div class="card border border-dark">
                        <div class="card-header widjet">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="h5 mb-0">Clima Imagem</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body wijetbody">
                            <div class="row g-3">
                                <div class="col-12 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <?php
                                            echo '<strong> Webcam </strong>
                                                </div>
                                                <div class="card-body text-center">
                                                <img src="../dados/imagens/webcam.jpg?id=".time()." style="width:100%">
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo ucfirst(file_get_contents($url . "variavel=led&info=hora"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <footer class=" bg-white border-top py-1 mt-4">
        <div class="container">
            <div class="row align-items-center text-center text-md-start">
                <div class="col-md-9 mb-3 mb-md-0">
                    <h5 class="mb-2">Feito por:</h5>
                    <ul class="list-unstyled mb-0">
                        <li>Ricardo Duarte - <span class="text-muted">2240879</span></li>
                        <li>João Soares - <span class="text-muted">2240859</span></li>
                    </ul>
                </div>
                <div class="col-md-3 text-md-end">
                    <img src="../dados/imagens/logo_ipl.png" alt="Logotipo" class="img-fluid" style="max-height: 100px;">
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>