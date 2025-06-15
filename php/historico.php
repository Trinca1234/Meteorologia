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
  if (!isset($_SESSION['username'], $_SESSION['admin'])) {
    $_SESSION['erro'] = "É necessário login para entrar";
    header('Location: index.php');
    exit();
  }
  ?>

  <header class="bg-white border-bottom sticky-header">
    <div class="container py-3">
      <div class="row align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
          <h1 class="h3 mb-0"><img src="../dados/imagens/TempoCerto_noBG.png" alt="Logotipo" style="max-height: 60px;"><span class="text-muted p-4 h5"> <a href="dashboard.php">Dashboard</a></span><span class="text-muted p-1 h5"> <a href="galeria.php">Galeria</a> </span></h1>
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

                foreach (scandir($caminho) as $item) {
                  if (is_dir($caminho . '/' . $item) && !($item === '.' || $item === '..')) {
                    $pastas[] = ucfirst($item);
                  }
                }

                $primeiro = true;

                foreach ($pastas as $sensor) {
                  $ativo = $primeiro ? 'active' : '';
                  echo '<li class="nav-item" role="presentation">
                          <button class="nav-link ' . $ativo . '" id="' . $sensor . '-tab" data-bs-toggle="tab" 
                          data-bs-target="#' . $sensor . '" type="button" role="tab" 
                          aria-controls="' . $sensor . '" aria-selected="' . ($primeiro ? 'true' : 'false') . '">' . $sensor . '</button>
                        </li>';
                  $primeiro = false;
                }
                ?>
              </ul>

              <div class="tab-content">
                <?php
                $logs = file_get_contents("../dados/logs/logs.json");
                $dados = array_reverse(json_decode($logs, true)['logs']);
                $temDados = count($dados) > 0;

                $primeiro = true;

                foreach ($pastas as $sensor) {
                  $ativo = $primeiro ? 'show active' : '';

                  // Verificar se existem dados para o sensor
                  $encontrado = false;
                  foreach ($dados as $log) {
                    if ($sensor === "Todos" || ucfirst($log['nome']) === $sensor) {
                      $encontrado = true;
                      break;
                    }
                  }

                  echo '<div class="tab-pane fade ' . $ativo . '" id="' . $sensor . '" role="tabpanel" aria-labelledby="' . $sensor . '-tab">';

                  if ($encontrado && $temDados) {
                    echo '<table class="table table-striped table-hover table-bordered shadow-sm">
                            <thead class="table-dark">
                              <tr>
                                <th>#</th>
                                <th>Sensor</th>
                                <th>Valor</th>
                                <th>Hora</th>
                              </tr>
                            </thead>
                            <tbody>';

                    $contador = 0;

                    foreach ($dados as $log) {
                      if ($sensor === "Todos" || ucfirst($log['nome']) === $sensor) {
                        $contador++;
                        echo '<tr>
                                <td>' . $contador . '</td>
                                <td>' . ucfirst($log['nome']) . '</td>
                                <td>' . $log['valor'] . $log['escala'] . '</td>
                                <td>' . $log['hora'] . '</td>
                              </tr>';
                        if ($contador >= 50) break;
                      }
                    }

                    echo '</tbody></table>';
                  } else {
                    echo $sensor === "Todos" ? "Não existem dados nenhuns." : "Não existem dados sobre este sensor.";
                  }

                  echo '</div>';
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
