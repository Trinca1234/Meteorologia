<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tempo Certo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">


</head>

<body>
  <?php
  session_start();

  if (!isset($_SESSION['username'],$_SESSION['admin'])) {
    $_SESSION['erro'] = "É necessário login para entrar";
    header('Location: index.php');
    exit();
  }
  ?>
  <header class="bg-white border-bottom sticky-header">
    <div class="container py-3">
      <div class="row align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
          <h1 class="h3 mb-0"><img src="../dados/imagens/TempoCerto_noBG.png" alt="Logotipo" style="max-height: 60px;"><span class="text-muted p-5 h5"> <a href="dashboard.php">Dashboard</a></span></h1>
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
              <h2 class="h5 mb-0">Histórico</h2>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs mb-3" id="previsaoTabs" role="tablist">
                <?php

                $caminho = "../dados/api/files";
                $pastas[] = "Todos";
                //vai passar por todas as pastas dos sensores e vai buscar os nomes para fazer cada uma das suas abas automaticamente;
                foreach (scandir($caminho) as $item) {

                  //verifica se o nome da pasta + caminho é um diretorio 
                  //e verifica se são pastas especiais
                  if (is_dir($caminho . '/' . $item) &&  !($item === '.' || $item === '..')) {
                    //vai escrever o nome das pastas com a primeira letra maiuscula
                    $pastas[] = ucfirst($item);
                  }
                }

                //variavel para saber que a primeira aba é diferente das outras
                //neste caso para ter a class active (ja que só uma é que pode estar ativa e pelo menos uma tem de estar ativa)
                $primeiro = true;

                //vai fazer automaticamente 
                foreach ($pastas as $sensor) {

                  //short end if para saber se a primeira aba ja foi feita para poder atribuir a class
                  $ativo = $primeiro ? 'active' : '';

                  //vai fazer os indicadores das abas
                  echo '<li class="nav-item" role="presentation">
                          <button class="nav-link ' . $ativo . '" id="' . $sensor . '-tab" data-bs-toggle="tab" 
                          data-bs-target="#' . $sensor . '" type="button" role="tab" 
                          aria-controls="' . $sensor . '" aria-selected="' . $primeiro . '">' . $sensor . '</button>
                        </li>';

                  //depois de fazer o primeiro passa a falso para nao fazer a classe active
                  $primeiro = false;
                }

                ?>
              </ul>

              <div class="tab-content">
                <?php
                //vou buscar os dados do ficheiro json
                $logs = file_get_contents("../dados/logs/logs.json");

                //passar tudo o que esta dentro dos logs para um array e mostrar primeiro os mais recentes
                $dados = array_reverse(json_decode($logs, true)['logs']);
                

                //verificar se é a primeira aba
                $primeiro = true;

                //vai passar por todas as pastas 
                foreach ($pastas as $sensor) {
                  //se for o primeiro fica com esta class
                  $ativo = $primeiro ? 'show active' : '';


                  //vai verificar se existem dados para o sensor 
                  //se nao existir nao faz tabelas e escreve que nao existem dados
                  $encontrado = false;
                  foreach ($dados as $log) {
                    if (ucfirst($log['nome']) === $sensor) {
                      $encontrado = true;
                      break;
                    }
                  }

                  //vai fazer criar a tabela com o nome do sensor e com os respetivos id's
                  //para depois conseguir fazer 'paginas' com cada sensor
                  echo '                
                      <div class="tab-pane fade ' . $ativo . '" id="' . $sensor . '" role="tabpanel" aria-labelledby="' . $sensor . '">';
                  if ($encontrado || $primeiro) {
                    echo '  <table class="table table-striped table-hover table-bordered shadow-sm">
                              <thead class="table-dark">
                                      <tr>
                                      <th>#</th>
                                      <th>' . ucfirst($sensor) . '</th>
                                      <th>Valor</th>
                                      <th>Hora</th>
                                  </tr>
                              </thead>
                          <tbody>';
                  } else
                    echo "Não existem dados sobre este sensor.";

                  //fazer o conteudo das tabelas
                  if ($primeiro) {
                    foreach ($dados as $index => $log) {

                      echo '<tr>
                      <td>' . ($index + 1) . '</td>
                      <td>' . ucfirst($log['nome']) . '</td>
                      <td>' . $log['valor'] . $log['escala'] . '</td>
                      <td>' . $log['hora'] . '</td>
                      </tr>';
                    }
                  } else {
                    foreach ($dados as $index => $log) {
                      if (ucfirst($log['nome']) === $sensor) {
                        echo '<tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . ucfirst($log['nome']) . '</td>
                        <td>' . $log['valor'] . $log['escala'] . '</td>
                        <td>' . $log['hora'] . '</td>
                        </tr>';
                      }
                    }
                  }

                  //fechar as tags que faltam
                  echo ' </tbody> </table> </div>';

                  $primeiro = false;
                }
                ?>
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