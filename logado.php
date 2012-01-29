<?php 
function isLogado($sessaoUser, $sessaoSenha, $tabela='usuarios'){
		if(isset($sessaoUser) && isset($sessaoSenha)){
		$usersSession = $_SESSION['usuariologin'];
		$pegaNivel = mysql_query("SELECT nivel FROM usuarios WHERE usuario = '$usersSession'");
		$result = mysql_fetch_array($pegaNivel);
		$nivel = $result['nivel'];

		

		if($nivel != 'admin'){
		header("location:index.php");
		echo 'Você nao tem permissao pra entrar';
		
		}

		
	}else{
		header("location:index.php");
	}

}
	
?>