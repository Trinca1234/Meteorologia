<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempo Certo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../dados/imagens/icon.png">

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

    //com as duas informações contrui um url para conseguir o pedido de dados
    $url = $protocolo . "://" . $host . "/ti/ti113/dados/api/api.php?";

    ?>
    <header class="bg-white border-bottom sticky-header">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h1 class="h3 mb-0"><img src="../dados/imagens/TempoCerto_noBG.png" alt="Logotipo" style="max-height: 60px;">
                        <span class="text-muted p-5 h5">
                            <?php
                            if (isset($_SESSION['admin'])) {
                                echo ' <a href="historico.php">Historico</a></span>';
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
                            <div class="row g-3">
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <?php
                                            $imagem  = file_get_contents($url . "variavel=temperatura&info=valor") < 20 ? '../dados/imagens/temperaturaBaixa.png' : '../dados/imagens/temperaturaAlta.png';
                                            echo '<strong>' . ucfirst(file_get_contents($url . "variavel=temperatura&info=nome")) . ": "
                                                . file_get_contents($url . "variavel=temperatura&info=valor") .
                                                file_get_contents($url . "variavel=temperatura&info=escala") .
                                                '</strong>' . '                                        </div>
                                                <div class="card-body text-center">

                                                
                                                <img style="max-height: 160px;" src="' . $imagem . '" alt="Temperatura" />
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo ucfirst(file_get_contents($url . "variavel=temperatura&info=hora"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <?php
                                            $imagem  = file_get_contents($url . "variavel=humidade&info=valor") < 50 ? '../dados/imagens/humidadeBaixa.png' : '../dados/imagens/humidadeAlta.png';
                                            echo '<strong>' . ucfirst(file_get_contents($url . "variavel=humidade&info=nome")) . ": "
                                                . file_get_contents($url . "variavel=humidade&info=valor") .
                                                file_get_contents($url . "variavel=humidade&info=escala") .
                                                '</strong>' . '                                        </div>
                                                <div class="card-body text-center">

                                                
                                                <img style="max-height: 160px;" src="' . $imagem . '" alt="Humidade" />
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo ucfirst(file_get_contents($url . "variavel=humidade&info=hora"));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <?php
                                            $imagem  = file_get_contents($url . "variavel=luminosidade&info=valor") < 50 ? '../dados/imagens/luminosidadeBaixa.png' : '../dados/imagens/luminosidadeAlta.png';
                                            echo '<strong>' . ucfirst(file_get_contents($url . "variavel=luminosidade&info=nome")) . ": "
                                                . file_get_contents($url . "variavel=luminosidade&info=valor") .
                                                file_get_contents($url . "variavel=luminosidade&info=escala") .
                                                '</strong>' . '                                        </div>
                                                <div class="card-body text-center">

                                                
                                                <img style="max-height: 160px;" src="' . $imagem . '" alt="Luminosidade" />
                                                </div>
                                                <div class="card-footer footer text-center">
                                                <strong>Atualização:</strong>';
                                            echo ucfirst(file_get_contents($url . "variavel=luminosidade&info=hora"));
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
                        <div class="card-body wijetbody">
                            <div class="row g-3">
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <strong>
                                                Ar condicionado
                                            </strong>
                                            <?php
                                            //se a temperatura for  que 20 liga o ar condicionado
                                            echo '
                                                <p class="text-muted small mb-0">
                                                    ' . (file_get_contents($url . "variavel=temperatura&info=valor") > 20 ? 'Ligado' : 'Desligado') . '
                                                </p>
                                                ';
                                            ?>
                                        </div>
                                        <div class="card-body text-center">
                                            <img style="max-height: 160px;" src="../dados/imagens/AC.png" alt="Ar condicionado" />
                                        </div>
                                        <div class="card-footer footer text-center">
                                            <strong>Atualização:</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <strong>
                                                Led
                                            </strong>
                                            <?php
                                            //se luminosidade for menor que 50% a led liga
                                            echo '
                                                <p class="text-muted small mb-0">
                                                    ' . (file_get_contents($url . "variavel=luminosidade&info=valor") < 50 ? 'Ligado' : 'Desligado') . '
                                                </p>
                                                ';
                                            ?>
                                        </div>
                                        <div class="card-body text-center">
                                            <img style="max-height: 160px;" src="../dados/imagens/led.png" alt="Ar condicionado" />

                                        </div>
                                        <div class="card-footer footer text-center">
                                            <strong>Atualização:</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark ">
                                        <div class="card-header sensor header text-center">
                                            <strong>
                                                Regador
                                            </strong>
                                            <?php
                                            //se temperatura for maior que 20 e humidade menor que 50%
                                            echo '
                                                <p class="text-muted small mb-0">
                                                    ' . (file_get_contents($url . "variavel=temperatura&info=valor") > 20 | file_get_contents($url . "variavel=luminosidade&info=valor") < 50 ? 'Ligado' : 'Desligado') . '
                                                </p>sdf
                                                ';
                                            ?>
                                        </div>
                                        <div class="card-body text-center">
                                            <img style="max-height: 160px;" src="../dados/imagens/regador.png" alt="Ar condicionado" />
                                        </div>
                                        <div class="card-footer footer text-center">
                                            <strong>Atualização:</strong>
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