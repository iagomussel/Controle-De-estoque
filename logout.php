<?php 
	session_start();

	if(isset($_SESSION['usuariologin']) && isset($_SESSION['senhalogin'])){
		
		session_destroy();
		session_unset();
		//session senha
		
		//session_destroy($_SESSION['senhalogin']);
		header('location: index.php');
		
	}else{
		header("location: index.php?alerta=sessao+nao+destruida");
	}

	

 ?>