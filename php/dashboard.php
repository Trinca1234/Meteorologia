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
        header("refresh:5;url=../funcoes/login.php");
        die("Login Necessário");
    }

    //verificar qual o protocolo (https ou http)
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    //vai ver o Host do servidor  
    $host = $_SERVER['HTTP_HOST'];

    //com as duas informações contrui um url para conseguir o pedido de dados
    $url = $protocolo . "://" . $host . "/Meteorologia/dados/api/api.php?";

    $url = $url . "variavel=temperatura&info=hora";

    /* echo file_get_contents($); //para conseguir ir buscar dados */

    ?>
    <header class="bg-white border-bottom sticky-header">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    
                    <h1 class="h3 mb-0"><img src="../dados/imagens/TempoCerto.png" alt="Logotipo" style="max-height: 60px;"><span class="text-muted p-5 h5"> <a href ="historico.php">Historico</a></span></h1>
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
                                    <p class="text-muted small mb-0">quinta</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body wijetbody">
                            <p class="fs-5 mb-4">Descricao</p>
                            <div class="row g-3">
                                <div class="col-6 col-sm-4 ">
                                    <div class="card border border-dark">
                                        <div class="card-header sensor header">
                                            <strong>Temperatura: 45ºC</strong>
                                        </div>
                                        <div class="card-body">
                                            <img style="max-height: 160px;" src="https://media.istockphoto.com/id/1411855775/pt/vetorial/set-of-icons-with-different-fire.jpg?s=612x612&w=0&k=20&c=x5or03YcnwaJbgXWeXyqj8ZtLCn6re4Ls04SOREykxA=" alt="Temperatura"/>
                                        </div>
                                        <div class="card-footer footer">
                                            <strong>Atualização:</strong>
                                            2024/03/10 14:31 - 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark">
                                        <div class="card-header sensor header">
                                            <strong>Humidade: 40%</strong>
                                        </div>
                                        <div class="card-body">
                                            <img style="max-height: 160px;" src="https://i.kym-cdn.com/entries/icons/facebook/000/036/007/underthewatercover.jpg" alt="Humidade"/>
                                        </div>
                                        <div class="card-footer footer">
                                            <strong>Atualização:</strong>
                                            2024/03/10 14:31 - 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-4">
                                    <div class="card border border-dark">
                                        <div class="card-header sensor header">
                                            <strong>Luminosidade: Fixe</strong>
                                        </div>
                                        <div class="card-body">
                                            <img style="max-height: 150px;" src="https://preview.redd.it/sun-care-i-cant-find-a-sunscreen-that-doesnt-burn-my-eyes-v0-dk8h2cfj4zfb1.jpg?auto=webp&s=6fb939b54f5975429ec99ab6168b7f5e5bc6fd95" alt="Luminosidade"/>
                                        </div>
                                        <div class="card-footer footer">
                                            <strong>Atualização:</strong>
                                            2024/03/10 14:31 - 
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