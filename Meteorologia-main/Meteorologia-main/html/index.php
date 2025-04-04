<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>TrincaTempo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css"> 
</head>
<body>
    <div class ="container">
      <div class="login-box row justify-content-center">
      <h2><strong>Login</strong></h2>
      <form class="row g-3" action ="../php/login.php" method ="POST">
          <div class="rwo mb-3">
            <label class="form-label">Nome de Utilizador</label>
            <input type="text" class="form-control" placeholder="Username" name="username">
          </div>
          <div class="mb-3">
            <label class="form-label">Palavra-passe</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <?php 
                //vai crair sessao e ver se a variavel erro existe
                session_start();
                if (isset($_SESSION['erro'])) {
                    //se existir vai escrever a mensagem
                    echo '<small class="form-text text-danger">' . $_SESSION['erro'] . '</small>';
                    unset($_SESSION['erro']); 
                }
            ?>
          <button name ="submit" type="submit" class="btn btn-primary "> Login</button>
        </form>
      </div>
    </div>
</body>
</html>