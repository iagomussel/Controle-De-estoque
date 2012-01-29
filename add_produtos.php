<?php require_once("config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	    <title>Adicionar Produtos</title>
	    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
	</head>
		<body>
			<div id="conteudo">
		<?php if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'){
			$nomeProduto = trim($_POST['produto']);
			$valorProduto = trim($_POST['valor']);
			if(empty($nomeProduto)){
					echo '<div class="error">Favor Preencher o campo nome</div>';
				}
				if(empty($valorProduto)){
					echo '<div class="error">Favor Preencher o campo valor</div>';
				}else{
			
			$verifica = mysql_query("SELECT nome FROM produtos WHERE nome like '%$nomeProduto%'");
			if(mysql_num_rows($verifica) > 1){
				echo '<div class="warning">Produto Já cadastrado!.</div>';
			}else{
				
			
			$inserir = mysql_query("INSERT INTO produtos (nome, valor) VALUES ('$nomeProduto', '$valorProduto')");
			if($inserir){
				echo '<div class="success">Produto Cadastrado com sucesso!</div>';
			}else{
				echo '<div class="error">Erro Ao cadastrar produto!</div>';
			}
		}
		}
		}
			
		?>
		
		<form action="" method="post" enctype="multipart/form-data">
				<fieldset id="adicionar_produtos" class="">
						<legend>Adicionar Produtos</legend>
					<label>
						<span>Nome</span>
						<input type="text" name="produto" />
					</label>
					<label>
						<span>Valor</span>
						<input type="text" name="valor" />
					</label>		
					<br />
					<input type="submit" value="Cadastrar &rarr;" class="enviar">
					<input type="hidden" name="acao" value="cadastrar" />
				</fieldset>
			</form>	
			</div>
	</body>
</html>