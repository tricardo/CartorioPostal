<?php require('header.php');
$permissao = verifica_permissao('Franchising',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('POST','submit');

?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" />Chamado</h1>
<hr class="tit" />
</div>
<div id="meio">
<?php 
if($submit){
	pt_register("POST",   "id_chamado");
	pt_register("POST",   "id_pedido");
	pt_register("POST",   "id_empresa");
	pt_register("POST",   "ordem");
	pt_register("POST",   "status");
	pt_register("POST",   "pergunta");
	pt_register("POST",   "resposta");
	pt_register("POST",   "forma_atend");

	$error='<ul>';
	if($id_empresa=="" || $pergunta=="" ){
		if($id_empresa == "") $errors['id_empresa']=1;		
		if($pergunta == "") $errors['pergunta']=1;		
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	$error.='</ul>';

	$c = new stdClass();
	$c->id_empresa = $id_empresa;
	$c->id_pedido = $id_pedido;
	$c->ordem = $ordem;
	$c->status = $status;
	$c->pergunta = $pergunta;
	$c->resposta = $resposta;
	$c->forma_atend = $forma_atend;
	
	if(count($errors)==0){
		$chamadoDAO = new ChamadoDAO();
		$c = $chamadoDAO->inserir($c,$controle_id_usuario);
		//alterado 01/04/2011
		$titulo = 'Adicionar chamado';
		$perg   = 'Novo registro adicionado com sucesso!\nCadastrar outro?';
		$resp1  = 'chamado_add.php';
		$resp2  = 'chamado.php';
		$funcJs = "openConfirmBox('".$titulo."','".$perg."','".$resp1."','".$resp2."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}
include("chamado_form.php");
?>
</div>
<?php
require('footer.php'); ?>