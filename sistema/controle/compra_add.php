<?php require('header.php'); ?>
<div id="topo"><?php
$permissao = verifica_permissao('Supervisor',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$id_departamentos = explode(',',$controle_id_departamento_s);
?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Solicitação
de Compra</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio"><?php 
pt_register("POST", "submit_compra");
if($submit_compra){
	pt_register("POST", "id_departamento");
	pt_register("POST", "produto");
	pt_register("POST", "descricao");
	pt_register("POST", "quantidade");
	pt_register("POST", "motivo");
	pt_register("POST", "observacao");
	pt_register("POST", "observacao");
	pt_register("POST", "solicitante");
	pt_register("POST", "status");

	$c = new stdClass();
	$c->id_empresa = $controle_id_empresa;
	$c->id_usuario = $controle_id_usuario;
	$c->id_departamento = (in_array($id_departamento,$id_departamentos))?
		$id_departamento:$id_departamentos[0];
	$c->produto = $produto;
	$c->descricao = $descricao;
	$c->quantidade = $quantidade;
	$c->motivo = $motivo;
	$c->observacao = $observacao;
	$c->solicitante = $solicitante;
	$c->status = $status;

	$error='<ul>';
	if($id_departamento=="" || $produto=="" || $quantidade=="" ){
		if($id_departamento == "") $errors['id_departamento']=1;
		if($produto == "") $errors['produto']=1;
		if($quantidade == "") $errors['quantidade']=1;

		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}
	$error.='</ul>';
	if(count($errors)==0){
		$compraDAO = new CompraDAO();
		$compraDAO->inserir($c);
	   //alterado 01/04/2011
		$titulo = 'Adicionar Solicitação';
		$perg   = 'Inserir outra solicitação?';
		$resp1  = 'compra_add.php';
		$resp2  = 'compra.php';
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}
else{
	$usuarioDAO = new UsuarioDAO();
	$solicitante  = $usuarioDAO->selectPorId($controle_id_usuario);
	$c->solicitante = $solicitante->nome;
	$c->status = 'Em Aberto';
}
?>
<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
		<?php include("compra_form.php");?>
		</td>
	</tr>
</table>
</div>
<?php require('footer.php'); ?>
