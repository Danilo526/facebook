
<?php

if (isset($_COOKIE['login'])) {
	header("location:index.php");
}

$user = "delta";
$pass = "102030";

if (isset($_POST['user'])) {
	if ($_POST['user'] == $user && $_POST['pass'] == $pass) {
		setcookie('login', true, (time() + (3 * 24 * 3600)));
		header("location:index.php");
	}
}

?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/img/logo.jpeg">

    <title>DELTA TUTORIAIS</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="https://getbootstrap.com.br/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos customizados para esse template -->
    <link href="https://getbootstrap.com.br/docs/4.1/examples/floating-labels/floating-labels.css" rel="stylesheet">
  </head>

  <body>
    <form class="form-signin login" form method="post" action="">
      <div class="text-center mb-4">
        <img class="mb-4" src="/img/logo.jpeg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">DELTA TUTORIAIS</h1>
      </div>

      <div class="form-label-group">
        <h5>LOGIN</h5>
        <input type="text" id="user" name="user" class="form-control" placeholder="LOGIN" required autofocus>
      </div>

      <div class="form-label-group">
      <h5>SENHA</h5>
        <input type="text" id="pass" name="pass" class="form-control" placeholder="SENHA" required>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="lembrar de mim"> Lembrar de mim
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    </form>
  </body>
</html>
