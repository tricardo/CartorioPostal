<?php require('header.php'); ?>
<div id="topo"><?php
$permissao = verifica_permissao('Supervisor',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao_compra = (verifica_permissao('Financeiro Compra',$controle_id_departamento_p,$controle_id_departamento_s)=='TRUE');
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Solicitação
de Compra</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio"><?php 
pt_register("POST", "submit_compra");
pt_register("POST", "submit_proposta");
pt_register("POST", "submit_aprova");
pt_register("GET", "submit_compra_reprovar");
pt_register("GET", "id_compra");
	
$compraDAO = new CompraDAO();
$propostaDAO = new CompraPropostaDAO();
$submit = 'atualizar';

$c = $compraDAO->buscaPorId($id_compra,$controle_id_empresa);
pt_register('POST','submit_compra_status');
if($submit_compra_status!=''){
	try{
		$error = $compraDAO->atualizaStatus($c,$submit_compra_status,$controle_id_empresa);
		$c->status = $submit_compra_status;
	}catch(Exception $e){
		echo '<div class="erro">'.$e->getMessage().'</div>';
	}
}else
if($submit_proposta!=''){
	pt_register("POST", "id_fornecedor");
	pt_register("POST", "valor");
	
	#upload de imagens
	$config = array();
	// Tamanho máximo do file_anexo (em bytes)
	$config["tamanho"] = 999999;
	// Largura máxima (pixels)
	$config["largura"] = 1024;
	// Altura máxima (pixels)
	$config["altura"]  = 1024;
	// Upload do RG
	$file_anexo = $_FILES["arquivo"];
	// Formulário postado... executa as ações
	if($file_anexo['name']<>''){
		$error_image = valida_upload_pdf($file_anexo, $config);
		if ($error_image){
			$erros['error'] .= $error_image;
		}
	} else {
		$erros['error'] .= '<li><b>Selecione o arquivo para fazer upload</b></li>';
	}
	#fim do upload foto
	$file_path = "../anexos_compras/".date("Ym")."/";
	if(!is_dir($file_path)) mkdir($file_path);
	if($file_anexo['name']){
		// Pega extensão do file_anexo
		preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
		// Gera um nome único para a imagem
		$imagem_nome = $controle_id_usuario.$id_compra.md5(uniqid(time())) . "." . $ext[1];
		// Caminho de onde a imagem ficará
		$imagem_dir = $file_path.$imagem_nome;
		// Faz o upload da imagem
		move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
	}
	
	$p = new stdClass();
	$p->id_fornecedor = $id_fornecedor;
	$p->valor = $valor;
	$p->id_compra = $id_compra;
	$p->arquivo = $imagem_dir;
	try{
		if($p->id_fornecedor == "") throw new Exception('Informe o fornecedor');
		if($p->valor == "") throw new Exception('Informe o valor');
		$propostaDAO->inserir($p);
	}catch(Exception $e){
		echo '<div class="erro">'.$e->getMessage().'</div>';
	}
}else if($submit_aprova){
	pt_register('POST','id_proposta');
	pt_register('POST','id_compra');
	pt_register('POST','aprovada');
	
	$p->id_proposta = $id_proposta;
	$p->id_compra = $id_compra;
	$p->aprovada = ($aprovada=='true')?1:0;
	
	$propostaDAO->aprova($p);
	die("pronto");
}
?>
	<div style="position: relative; width: 600px; margin: auto;" id="container-hotsite">
		<ul>
			<?php if($id_compra!=null){ ?>
				<li><a href="#aba0">Dados da solicitação</a></li>
			<?php } ?>
			<?php if($c->status!='Em Aberto' && $c->status!='Reprovada' && $permissao_compra){?>
				<li><a href="#aba1">Propostas</a></li>
			<?php } ?>
		</ul>
		<?php if(isset($id_compra)){ ?>
			<div id="aba0" style="position: relative; width: 600px; margin:0">
				<?php require("compra_form.php");?>
			</div>
		<?php }?>
		<?php if($c->status!='Em Aberto' && $c->status!='Reprovada' && $permissao_compra){?>
			<div id="aba1">
				<?php require("compra_proposta_form.php");?>
				<?php require("compra_proposta_list.php");?>
			</div>
		<?php } ?>
	</div>
</div>
<?php require('footer.php'); ?>