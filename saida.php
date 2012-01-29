<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <title>Saida de Produtos</title>
	    <link rel="stylesheet" href="style.css" type="text/css" media="all" charset="utf-8" />
	</head>
	<body>
		<div id="conteudo">
		<form enctype="multipart-form/data" method="post">
			<fieldset>
				<legend>Saida de Produtos</legend>
			<select name="prod">
				<option value="" selected="selected">Selecione Um Produto</option>
			<?php
				$pega = mysql_query("SELECT * FROM entrada");
				while($volta = mysql_fetch_array($pega)){
					
					echo '<option value="'.$volta['id'].'">'.$volta['produto'].'</option>';
						}
			?>
			
			</select>
		<label>
			<span>Quantidade:</span>
			<input type="text" name="quantidade" value="" />
		</label>
			<input type="hidden" name="acao" value="saida" />
			<input type="submit" name="" class="btn" value="Retirar" onclick="confirm('voce quer mesmo deletar?')" />
		</fieldset>
		</form>
		<?php
			if(isset($_POST['acao']) && $_POST['acao'] == 'saida'){
				$prodId = $_POST['prod'];
				$qtdSaida = trim(strip_tags($_POST['quantidade']));
				
				//pega nome do produto
				$pegaProduto = mysql_query("SELECT * FROM produtos WHERE id = '$prodId'");
				$voltaProd = mysql_fetch_array($pegaProduto);
				$prodName = $voltaProd['produto'];
				
				
				//pega quantidade do produto na tabela entrada
				$quantidade = mysql_query("SELECT * FROM entrada WHERE id_produto = '$prodId'");
				$volta_quantidade = mysql_fetch_array($quantidade);
				$qtd = $volta_quantidade['quantidade'];
				$novaQtd = $qtd - $qtdSaida;
				
				//verifica se a quantidade for diferente de 0
				if($novaQtd != 0){
					//insere na saida
				$saida = mysql_query("INSERT INTO saida (id_produto, produto, quantidade ) VALUES 
					('$prodId', '$prodName', '$qtdSaida')") or die(mysql_error());
				$retirada = mysql_query("UPDATE entrada SET quantidade = '$novaQtd'") or die (mysql_error());
				
					if($retirada){
						echo '<script>alert("retirada de produto feita com sucesso")</script>';
					}
						
				}else{
					$saida = mysql_query("INSERT INTO saida (id_produto, produto, quantidade ) VALUES 
										('$prodId', '$prodName', '$qtdSaida')") or die(mysql_error());
					$retirada = mysql_query("DELETE FROM entrada WHERE produto = '$prodName'") or die (mysql_error());
					if($retirada){
						echo '<script>alert("retirada de produto feita com sucesso, agora vc tem 0 '.$prodName.'")</script>';
					}
				}
				
				
				 
			}
		?>
	</div><!--Conteudo-->
	</body>
</html>