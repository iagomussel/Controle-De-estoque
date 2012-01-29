<?php require_once("config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <title>Controle De Estoque</title>
	    <link rel="stylesheet" href="style.css" type="text/css" />
	    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
	    <script type="text/javascript" charset="utf-8">
	   		var str = "";
	    	$("#selecao option:selected").each(function(){
	    		var id = $(this).val();

	    		$.post("pagina.php", {id:id}, function(data){

	    			$("#valor").attr("value", data);
	    			$(".hide").show(fade("slow"));	
	    		});
	    	});

	    </script>
	</head>
	<body>
		<div id="conteudo">
			<?php if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'){
					$produtoId = $_POST['produto'];
					$qtd = trim($_POST['quantidade']);
					
					if($produtoId == 0){
						echo '<div class="warning">Favor Escolher Um produto.</div>';
					}else{
						
					
					if(empty($qtd)){
						echo '<div class="warning">Favor Inserir uma quantidade.</div>';
						}else{
						$pegaProduto = mysql_query("SELECT * FROM produtos WHERE id = '$produtoId'");
						$result = mysql_fetch_array($pegaProduto);
						$nomeProduto = $result['nome'];
						$valorProduto = $result['valor'];
						
						$selecionaEntrada = mysql_query("SELECT * FROM entrada WHERE produto = '$nomeProduto'");
						$contaProduto = mysql_num_rows($selecionaEntrada);
						
						if($contaProduto >= 1){
							$pegaQuantidade = mysql_query("SELECT quantidade FROM entrada WHERE produto = '$nomeProduto'");
							$voltaQuantidade = mysql_fetch_array($pegaQuantidade);
							$quantidadeEntrada = $voltaQuantidade['quantidade'];
							
							$novaQtd = $quantidadeEntrada + $qtd;
							$update = mysql_query("UPDATE entrada SET quantidade = '$novaQtd' WHERE produto = '$nomeProduto'");
							if($update){
								echo '<div class="success"> Entrada inserida com sucesso!</div>';
							}else{
								echo '<div class="error">Erro ao inserir entrada!</div>';
							}
							
							
						}else{
						
						$entrada = mysql_query("INSERT INTO entrada (produto, quantidade, valor) VALUES ('$nomeProduto', '$qtd', '$valorProduto')") or die(mysql_error());
						if($entrada){
							echo '<div class="success"> Entrada inserida com sucesso!</div>';
						}else{
							echo '<div class="error">Erro ao inserir entrada!</div>';
						}
					}
					}
				  }
			  }
				
			?>
			<form action="" method="post" enctype="multipart/form-data">
				<fieldset id="" class="">
					<legend>Cadastre Um Produto</legend>
						<label>
							<span>Produto                                                : </span>
							<select name="produto" id="selecao">
								<option value="0" selected="selected">Selecione um Produto</option>	
								<?php
									$select = mysql_query("SELECT * FROM produtos");
									while($res = mysql_fetch_object($select)){
										echo '<option value="'.$res->id.'" id="produto">'.$res->nome.'</option>';
									}
								?>
							</select><br/>
						</label>
						<div style="display:none;">
							<span>Valor: </span>
							<input type="text" name="valor" value="" id="valor">
						</div>
						<label>
							<span>Quantidade : </span>
							<input type="text" name="quantidade" value="" id="">
						</label>
						<br />
							<input type="hidden" name="acao" value="cadastrar" id="acao">
							<input type="submit" value="Cadastrar &rarr;" class="enviar">
				</fieldset>
			
			</form>
		</div><!--conteudo-->	
	</body>
</html>