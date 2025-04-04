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

    
    //echo file_get_contents($url); para conseguir ir buscar dados
      
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
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <!-- cidade -->
                                    <h2 class="h5 mb-0">Leiria</h2>
                                    <!--  dia da semana de hoje -->
                                    <p class="text-muted small mb-0">quinta</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="fs-5 mb-4">Descricao</p>
                            <div class="row g-3">
                                <div class="col-6 col-sm-3">
                                    <div class="border border-dark rounded p-3 text-center itembonita">
                                        <div class="text-muted small mb-1">Temperatura</div>
                                        <div class="fw-bold">40ºC</div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <div class="border border-dark rounded p-3 text-center itembonita">
                                        <div class="text-muted small mb-1">Humidade</div>
                                        <div class="fw-bold">65%</div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <div class="border border-dark rounded p-3 text-center itembonita">
                                        <div class="text-muted small mb-1">Luminosidade</div>
                                        <div class="fw-bold">%%</div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <div class="border border-dark rounded p-3 text-center itembonita">
                                        <div class="text-muted small mb-1">Ceu</div>
                                        <div class="fw-bold">Ta fixe</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h2 class="h5 mb-0">Previsões</h2>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-3" id="previsaoTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button" role="tab" aria-controls="daily" aria-selected="true">Semana</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="hourly-tab" data-bs-toggle="tab" data-bs-target="#hourly" type="button" role="tab" aria-controls="hourly" aria-selected="false">Hoje</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="previsaoTabsContent">
                                <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
                                    <div class="row g-2">
                                        <div class="col previsao-item">
                                            <div class="border rounded p-2 border-dark itembonita">
                                                <!-- dia da semana -->
                                                <div class="fw-medium mb-1">Hoje</div>
                                                <i class="fas fa-sun weather-icon-sm my-2"></i>
                                                <div>
                                                    <!-- temp max desse dia -->
                                                    <span class="temp-high">Temp max hoje</span>
                                                    <!-- temp min desse dia -->
                                                    <span class="temp-low">Temp min hoje</span>
                                                </div>
                                                <!-- descricao do ceu -->
                                                <div class="small mt-1">Desc ceu</div>
                                            </div>
                                        </div>
                                        <div class="col previsao-item">
                                            <div class="border rounded p-2 border-dark itembonita">
                                                <div class="fw-medium mb-1">Wed</div>
                                                <i class="fas fa-cloud-rain weather-icon-sm my-2"></i>
                                                <div>
                                                    <span class="temp-high">70°</span>
                                                    <span class="temp-low">60°</span>
                                                </div>
                                                <div class="small mt-1">Rain</div>
                                            </div>
                                        </div>
                                        <div class="col previsao-item">
                                            <div class="border rounded p-2 border-dark itembonita">
                                                <div class="fw-medium mb-1">Thu</div>
                                                <i class="fas fa-cloud weather-icon-sm my-2"></i>
                                                <div>
                                                    <span class="temp-high">68°</span>
                                                    <span class="temp-low">58°</span>
                                                </div>
                                                <div class="small mt-1">Cloudy</div>
                                            </div>
                                        </div>
                                        <div class="col previsao-item">
                                            <div class="border rounded p-2 border-dark itembonita">
                                                <div class="fw-medium mb-1">Fri</div>
                                                <i class="fas fa-cloud weather-icon-sm my-2"></i>
                                                <div>
                                                    <span class="temp-high">72°</span>
                                                    <span class="temp-low">63°</span>
                                                </div>
                                                <div class="small mt-1">Partly Cloudy</div>
                                            </div>
                                        </div>
                                        <div class="col previsao-item">
                                            <div class="border rounded p-2 border-dark itembonita">
                                                <div class="fw-medium mb-1">Sat</div>
                                                <i class="fas fa-sun weather-icon-sm my-2"></i>
                                                <div>
                                                    <span class="temp-high">80°</span>
                                                    <span class="temp-low">65°</span>
                                                </div>
                                                <div class="small mt-1">Sunny</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="hourly" role="tabpanel" aria-labelledby="hourly-tab">
                                    <div class="hourly-previsao">
                                        <div class="d-flex gap-2">
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">11 AM</div>
                                                    <i class="fas fa-cloud weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">72°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">12 PM</div>
                                                    <i class="fas fa-sun weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">74°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">1 PM</div>
                                                    <i class="fas fa-sun weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">75°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">2 PM</div>
                                                    <i class="fas fa-sun weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">75°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">3 PM</div>
                                                    <i class="fas fa-cloud weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">74°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">4 PM</div>
                                                    <i class="fas fa-cloud weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">73°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">5 PM</div>
                                                    <i class="fas fa-cloud weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">71°</div>
                                                </div>
                                            </div>
                                            <div class="hourly-item">
                                                <div class="border rounded p-2">
                                                    <div class="fw-medium mb-1">6 PM</div>
                                                    <i class="fas fa-cloud-rain weather-icon-xs my-2"></i>
                                                    <div class="fw-bold">69°</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h2 class="h5 mb-0">Air Quality</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Air Quality Index</span>
                                <span class="fw-medium">42 - Good</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-value"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted small mb-4">
                                <span>Good</span>
                                <span>Moderate</span>
                                <span>Unhealthy</span>
                            </div>
                            <hr>
                            <div class="row g-3 mt-2">
                                <div class="col-6">
                                    <div class="text-muted small">Pollutants</div>
                                    <div class="fw-medium">Low</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Pollen</div>
                                    <div class="fw-medium">Moderate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h2 class="h5 mb-0">Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-muted small">Visibility</div>
                                    <div class="fw-medium">10 miles</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Pressure</div>
                                    <div class="fw-medium">1012 hPa</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Sunrise</div>
                                    <div class="fw-medium">6:42 AM</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Sunset</div>
                                    <div class="fw-medium">7:53 PM</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Moon Phase</div>
                                    <div class="fw-medium">Waxing Crescent</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Precipitation</div>
                                    <div class="fw-medium">20%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

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