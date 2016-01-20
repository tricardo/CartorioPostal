<?php require('header.php');
$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id');
pt_register('POST','submit');
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />Fornecedor</h1>
<hr class="tit" />
</div>
<div id="meio"><?php 
pt_register('POST','submit_anexo');
if($submit_anexo){
	pt_register("POST", "descricao");
	pt_register("POST", "id_fornecedor");
	
	$error='<ul>';
	if($descricao==""){
		if($descricao=="") $errors['descricao']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	#upload de imagens
	$config = array();
	// Tamanho máximo do file_anexo (em bytes)
	$config["tamanho"] = 999999;
	// Largura máxima (pixels)
	$config["largura"] = 1024;
	// Altura máxima (pixels)
	$config["altura"]  = 1024;
	// Upload do RG
	$file_anexo = $_FILES["anexo"];
	// Formulário postado... executa as ações
	if($file_anexo['name']<>''){
		$error_image = valida_upload_pdf($file_anexo, $config);
		if ($error_image){
			$errors['anexo'] .= $error_image;
			$error .= '<li><b>'.$error_image.'</b></li>';
		}
	} else {
		$error.= '<li><b>Selecione o arquivo para fazer upload</b></li>';
	}
	#fim do upload foto
	$file_path = "../anexos_fornecedor/".date("Ym")."/";
	if(!is_dir($file_path)) mkdir($file_path);
	if($file_anexo['name']){
		// Pega extensão do file_anexo
		preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
		// Gera um nome único para a imagem
		$imagem_nome = $id_fornecedor.'_'.$controle_id_usuario.md5(uniqid(time())) . "." . $ext[1];
		// Caminho de onde a imagem ficará
		$imagem_dir = $file_path.$imagem_nome;
		// Faz o upload da imagem
		move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
	}

	$error.='</ul>';

	$a = new stdClass();
	$a->descricao = $descricao;
	$a->anexo = $imagem_dir;
	$a->id_fornecedor = $id_fornecedor;

	if(count($errors)==0){
		$fornecedorDAO = new FornecedorDAO();
		$f_insert = $fornecedorDAO->inserirAnexo($a);
		?> <script type="text/javascript">
			alert('Documento anexado com sucesso!');
		</script> <?
	}
}

$fornecedorDAO = new FornecedorDAO();
if($submit){
	pt_register("POST","razao");
	pt_register("POST",   "fantasia");
	pt_register("POST",   "cnpj");
	pt_register("POST",   "id_regime");
	pt_register("POST",   "ie");
	pt_register("POST",   "fax");
	pt_register("POST",   "cep");
	pt_register("POST",   "endereco");
	pt_register("POST",   "numero");
	pt_register("POST",   "complemento");
	pt_register("POST",   "bairro");
	pt_register("POST",   "cidade");
	pt_register("POST",   "estado");
	pt_register("POST",   "id_banco");
	pt_register("POST",   "agencia");
	pt_register("POST",   "conta");
	pt_register("POST",   "favorecido");
	pt_register("POST",   "contato1");
	pt_register("POST",   "tel1");
	pt_register("POST",   "ramal1");
	pt_register("POST",   "email1");
	pt_register("POST",   "contato2");
	pt_register("POST",   "tel2");
	pt_register("POST",   "ramal2");
	pt_register("POST",   "email2");
	pt_register("POST",   "descProduto");
	pt_register("POST",   "creditoCompra");

	$f = new stdClass();
	$f->razao = $razao;
	$f->fantasia = $fantasia;
	$f->cnpj = $cnpj;
	$f->id_regime = $id_regime;
	$f->ie = $ie;
	$f->fax = $fax;
	$f->cep = $cep;
	$f->endereco = $endereco;
	$f->numero = $numero;
	$f->complemento = $complemento;
	$f->bairro = $bairro;
	$f->cidade = $cidade;
	$f->estado = $estado;
	$f->id_banco = $id_banco;
	$f->agencia = $agencia;
	$f->conta = $conta;
	$f->favorecido = $favorecido;
	$f->contato1 = $contato1;
	$f->tel1 = $tel1;
	$f->ramal1 = $ramal1;
	$f->email1 = $email1;
	$f->contato2 = $contato2;
	$f->tel2 = $tel2;
	$f->ramal2 = $ramal2;
	$f->email2 = $email2;
	$f->descProduto = $descProduto;
	$f->creditoCompra = $creditoCompra;
	$f->id_empresa = $controle_id_empresa;
	$f->id_fornecedor = $id;

	$error='<ul>';
	if($fantasia=="" || $razao==""){
		if($razao=="") $errors['razao']=1;
		if($fantasia=="") $errors['fantasia']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	if($cnpj!="" && validaCNPJ($cnpj)=='false'){
		$errors['cnpj']=1;
		$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
	}
	$error.='</ul>';

	if(count($errors)==0){
		$fornecedorDAO->atualizar($f);
		?> 
		<script type="text/javascript">
			alert('Registro atualizado!');
			window.location = 'fornecedor.php';
		</script> <?
	}
}else{
	$f = $fornecedorDAO->buscaPorId($id,$controle_id_empresa);
}

?> <?php include("fornecedor_form.php");?></div>
<?php
require('footer.php'); ?>