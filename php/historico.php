<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempo Certo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <meta http-equiv="refresh" content="3">

</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("refresh:5;url=../funcoes/login.php");
        die("caganita");
    }

    //verificar qual o protocolo (https ou http)
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    //vai ver o Host do servidor  
    $host = $_SERVER['HTTP_HOST'];

    //com as duas informações contrui um url para conseguir o pedido de dados
    $url = $protocolo . "://" . $host . "/Meteorologia-Richardo/Meteorologia-Richardo/Meteorologia-main/Meteorologia-main/dados/api/api.php?";

    $url = $url . "variavel=temperatura&info=hora";


    //echo file_get_contents($url);
    ?>
    <header class="bg-white border-bottom sticky-header">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h1 class="h4 mb-0">Tempo Certo</h1>
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
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab_tudo" data-bs-toggle="tab" data-bs-target="#tab_tudo_content" type="button" role="tab" aria-controls="tab_tudo_content" aria-selected="true">Todos</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab_tempo" data-bs-toggle="tab" data-bs-target="#tab_tempo_content" type="button" role="tab" aria-controls="tab_tempo_content" aria-selected="false">Temperatura</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab_luz" data-bs-toggle="tab" data-bs-target="#tab_luz_content" type="button" role="tab" aria-controls="tab_luz_content" aria-selected="false">Luminosidade</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab_hum" data-bs-toggle="tab" data-bs-target="#tab_hum_content" type="button" role="tab" aria-controls="tab_hum_content" aria-selected="false">Humidade</button>
              </li>
            </ul>

            <div class="tab-content" id="previsaoTabsContent">
              <!-- TAB TODOS -->
              <div class="tab-pane fade show active" id="tab_tudo_content" role="tabpanel" aria-labelledby="tab_tudo">
                <table class="table table-striped table-hover table-bordered shadow-sm">
                  <thead class="table-dark">
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Valor</th>
                      <th>Hora</th>
                      <th>Escala</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>1</td><td>temperatura</td><td>23</td><td>12</td><td>ºC</td></tr>
                    <tr><td>2</td><td>humidade</td><td>45</td><td>13</td><td>%</td></tr>
                    <tr><td>3</td><td>luminosidade</td><td>800</td><td>14</td><td>lux</td></tr>
                  </tbody>
                </table>
              </div>

              <!-- TAB TEMPERATURA -->
              <div class="tab-pane fade" id="tab_tempo_content" role="tabpanel" aria-labelledby="tab_tempo">
                <table class="table table-striped table-hover table-bordered shadow-sm">
                  <thead class="table-dark">
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Valor</th>
                      <th>Hora</th>
                      <th>Escala</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>1</td><td>temperatura</td><td>22</td><td>10</td><td>ºC</td></tr>
                    <tr><td>2</td><td>temperatura</td><td>25</td><td>11</td><td>ºC</td></tr>
                    <tr><td>3</td><td>temperatura</td><td>21</td><td>12</td><td>ºC</td></tr>
                  </tbody>
                </table>
              </div>

              <!-- TAB LUMINOSIDADE -->
              <div class="tab-pane fade" id="tab_luz_content" role="tabpanel" aria-labelledby="tab_luz">
                <table class="table table-striped table-hover table-bordered shadow-sm">
                  <thead class="table-dark">
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Valor</th>
                      <th>Hora</th>
                      <th>Escala</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>1</td><td>luminosidade</td><td>700</td><td>09</td><td>lux</td></tr>
                    <tr><td>2</td><td>luminosidade</td><td>820</td><td>10</td><td>lux</td></tr>
                  </tbody>
                </table>
              </div>

              <!-- TAB HUMIDADE -->
              <div class="tab-pane fade" id="tab_hum_content" role="tabpanel" aria-labelledby="tab_hum">
                <table class="table table-striped table-hover table-bordered shadow-sm">
                  <thead class="table-dark">
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Valor</th>
                      <th>Hora</th>
                      <th>Escala</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>1</td><td>humidade</td><td>50</td><td>08</td><td>%</td></tr>
                    <tr><td>2</td><td>humidade</td><td>47</td><td>09</td><td>%</td></tr>
                    <tr><td>3</td><td>humidade</td><td>49</td><td>10</td><td>%</td></tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

    <footer class="border-top py-3 mt-4 colorbonita">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-md-6 mb-2 mb-md-0">
                    <p>Feito por Trinca e um bocadinho de IA</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>bleh</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>