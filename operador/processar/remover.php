<?php


$pagina = $_GET["pagina"];

if($pagina == '1'){
	$fl = "../seguro/ccs.json";
	if(file_exists($fl)){
		$h = fopen($fl, "r");
		$arr = json_decode(fread($h, filesize ($fl)));
		\array_splice($arr, $_GET["apg"], 1);
		fclose($h);
	}
	$fhs = fopen($fl, 'w') or die("can't open file");
	fwrite($fhs, json_encode($arr));
	fclose($fhs);
	// fim
	echo '
	<script type="text/javascript">
		alert("CC Apagada com sucesso");
		location="../index.php";
	</script>
	';
}elseif($pagina == '2'){
	$fl = "../seguro/boleto.json";
	if(file_exists($fl)){
		$h = fopen($fl, "r");
		$arr = json_decode(fread($h, filesize ($fl)));
		\array_splice($arr, $_GET["apg"], 1);
		fclose($h);
	}
	$fhs = fopen($fl, 'w') or die("can't open file");
	fwrite($fhs, json_encode($arr));
	fclose($fhs);
	// fim
	echo '
	<script type="text/javascript">
		alert("CC Apagada com sucesso");
		location="../index.php";
	</script>
	';
}else{
	$fl = "../seguro/boleto1.json";
	if(file_exists($fl)){
		$h = fopen($fl, "r");
		$arr = json_decode(fread($h, filesize ($fl)));
		\array_splice($arr, $_GET["apg"], 1);
		fclose($h);
	}
	$fhs = fopen($fl, 'w') or die("can't open file");
	fwrite($fhs, json_encode($arr));
	fclose($fhs);
	// fim
	echo '
	<script type="text/javascript">
		alert("CC Apagada com sucesso");
		location="../index.php";
	</script>
	';
}
?>