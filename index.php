<?php 
session_start();
require_once("config.php");

if(isset($_POST['acao']) && $_POST['acao'] == 'entrar'){
	$usuario = $_POST['user'];
	$senha = md5($_POST['senha']);
	
	$sqlAutenticas = mysql_query("SELECT usuario AND senha FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'");
	if(mysql_num_rows($sqlAutenticas) == 1){
		$_SESSION['usuariologin'] = $usuario;
		$_SESSION['senhalogin'] = $senha;

		header('location: painel.php');
	}else{
		echo '<div class="error">Senha Errada ou usuario nao cadastradao</div>';
	}



}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <title>Entrar Sistema de estoque</title>
	    <link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<div id="login">

		<form action="" method="post" enctype="multipart/form-data">

				<fieldset id="logar" class="">
					<legend>Sistema De Login</legend>
					<label>
						<span>Usuario</span>
						<input type="text" name="user" value="" id="user" />
					</label>
					<label for="">
						<span>Senha</span>
						<input type="password" name="senha" value="" id="pass">
					</label>
					<br />
					<input type="hidden" name="acao" value="entrar" />
					<input type="submit" value="Logar" class="logar" />			
				</fieldset>
		
			</form>
	</div><!--login-->
	</body>
</html>