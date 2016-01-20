<?php require('header.php');
$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('POST','submit');

?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />Fornecedor</h1>
<hr class="tit" />
</div>
<div id="meio"><?php 
if($submit){
	pt_register("POST",   "razao");
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

	$error='<ul>';
	if($fantasia=="" || $razao=="" ){
		if($razao=="") $errors['razao']=1;
		if($fantasia=="") $errors['fantasia']=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	if($cnpj!="" && validaCNPJ($cnpj)=='false'){
		$errors['cnpj']=1;
		$error.="<li><b>CNPJ Inválido, digite corretamente.</b></li>";
	}

	$error.='</ul>';

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
	
	if(count($errors)==0){
		$fornecedorDAO = new FornecedorDAO();
		$f = $fornecedorDAO->inserir($f);
		?> <script type="text/javascript">
			if(confirm('Novo registro adicionado com sucesso!\nCadastrar outro?')){
				window.location = 'fornecedor_add.php';		
			}else{
				window.location = 'fornecedor.php';
			}
		</script> <?
	}
}
?> <?php include("fornecedor_form.php");?></div>
<?php require('footer.php'); ?>