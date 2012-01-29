<?php require_once("config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <title>Estoque Geral</title>
	    <style type="text/css" media="screen">
	    	td{
	    		padding:15px;
	    		background-color:#333;
	    	}
	    </style>
	</head>
	<body>
		<table widht="100%" border="1" cellspacing="0" cellspacing="0" align="center">
		<?php
			$tras = mysql_query("SELECT  * FROM entrada");
			while($r = mysql_fetch_array($tras)){
				$id = $r['id'];
				$nome = $r['produto'];
				$quantidade = $r['quantidade'];
				$valor = $r['valor'];
				
				echo '<tr>
					 	<td>'.$nome.'</td>
					 	<td>'.$quantidade.'</td>
					 	<td>'.$valor.'</td>
				      </tr>';				
			}
			
		?>
		</table>
	</body>
</html>