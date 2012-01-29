<?php
session_start();
require_once("logado.php");
require_once("config.php");

		if(isset($_SESSION['usuariologin']) && isset($_SESSION['senhalogin'])){
		$usersSession = $_SESSION['usuariologin'];
		$pegaNivel = mysql_query("SELECT nivel FROM usuarios WHERE usuario = '$usersSession'");
		$result = mysql_fetch_array($pegaNivel);
		$nivel = $result['nivel'];

		

		if($nivel != 'admin'){
		echo 'Você nao tem permissao pra entrar';

		echo '<script type="text/javascript">history.back();</sript>';
		
		}

		
	}else{
		header("location:index.php");
	}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <title>Painel</title>
	    <link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="tudo">
			<div id="header">
				Logomarca
			</div>
				<div id="painel">
					<ul>
						<li><a href="?pag=home">Inicio</a></li>
						<li><a href="?pag=prod">Adicionar Produtos</a></li>
						<li><a href="?pag=gerenciar">Gerenciar Produtos</a></li>
						<li><a href="?pag=entrada">Entrada</a></li>
						<li><a href="?pag=saida">Saida</a></li>
						<li><a href="?pag=saida">Imprimir Relat&oacute;rio</a></li>
						<li><a href="logout.php">Sair</a></li>

					</ul>
				</div><!--Painel-->
		</div>
	
	</body>
</html>