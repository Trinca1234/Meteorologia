<!DOCTYPE html>
<html>
    <body>
        <?php
        $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

        //vai ver o Host do servidor  
        $host = $_SERVER['HTTP_HOST'];

        if ($host === "localhost") {
            //se for local host
            $url = $protocolo . "://" . $host . "/dados/api";

        } else {
            //com as duas informações contrui um url para conseguir o pedido de dados
            $url = $protocolo . "://" . $host . "/ti/ti113/dados/api";
        }

        date_default_timezone_set("Europe/Lisbon");
        $uploadPath = __DIR__ . "/../fotos/" . date("Y-m-d_H-i-s") . ".png";;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            if(isset($_FILES['imagem'])){

                $_FILES['imagem']['name'] = "webcam.jpg";
                move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadPath);
            }else{
                http_response_code(400);
            }
        } else {
            http_response_code(403);
        }
        ?>

    </body>
</html>
