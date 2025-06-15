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
  //verificar se existe sessao e se é o admin a entrar
  session_start();
  if (!isset($_SESSION['username'], $_SESSION['admin'])) {
    $_SESSION['erro'] = "É necessário login para entrar";
    header('Location: ../index.php');
    exit();
  }
  ?>

  <header class="bg-white border-bottom sticky-header">
    <div class="container py-3">
      <div class="row align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
          <h1 class="h3 mb-0"><img src="../dados/imagens/TempoCerto_noBG.png" alt="Logotipo" style="max-height: 60px;"><span class="text-muted p-4 h5"> <a href="dashboard.php">Dashboard</a> </span> <span class="text-muted p-1 h5"> <a href="historico.php">Histórico</a> </span></h1>
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
          <div class="card">
            <div class="card-header">
              <h2 class="h5 mb-0">Galeria</h2>
            </div>
            <div class="card-body">
              <div class="card-body wijetbody">
                <div class="card-body wijetbody">
                  <div class="row g-3">
                    <?php

                    //caminho da pasta com as fotos do DroidCam
                    $pasta = '../dados/fotos/';
                    $ficheiros = scandir($pasta);
                    $imagens = [];

                    //vai adicionar os ficherios no array de imagens
                    foreach ($ficheiros as $file) {
                      if (is_file($pasta . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'png') {
                        $imagens[] = $file;
                      }
                    }

                    //Ordenar por ordem de mais recente para mais antigo
                    rsort($imagens);

                    //limitar apenas para 30 imagens
                    $imagens = array_slice($imagens, 0, 30);

                    //contador para depois escrever o numero da foto
                    $cont = 1;

                    //vai fazer uma caixa por cada foto que existe automaticamente
                    foreach ($imagens as $nomeImg) {
                      //tratar o nome da imagem que vai aparacer na galeria 
                      //o nome da imagem é ex: 2000-12-12_24-60-60.png
                      //separa-se pelo '_'  e depois troca-se os '-' por '/' e ':'

                      $caminhoImg = $pasta . $nomeImg;
                      $nomeSemExtensao = pathinfo($caminhoImg, PATHINFO_FILENAME);
                      list($ano, $hora) = explode("_", $nomeSemExtensao);
                      $novoAno = str_replace("-", "/", $ano);
                      $novaHora = str_replace("-", ":", $hora);


                      //divs com a foto
                      echo '
                          <div class="col-12 col-sm-4">
                            <div class="card border border-dark efeitoAumentar">
                              <div class="card-header sensor header text-center">
                                <strong>Foto ' . $cont . '</strong>
                              </div>
                              <div class="card-body text-center">
                                <img src="' . $caminhoImg . '?id=' . time() . '" style="width:100%">
                              </div>
                              <div class="card-footer footer text-center">
                                <strong>Enviado em:</strong> ' . $novoAno . " " . $novaHora . '
                              </div>
                            </div>
                          </div>';

                      $cont++;
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </main>

  <footer class="bg-white border-top py-1 mt-4">
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