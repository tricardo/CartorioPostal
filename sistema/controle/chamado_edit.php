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
$chamadoDAO = new ChamadoDAO();
if($submit){
	pt_register("POST", "id_chamado");
	pt_register("POST", "id_pedido");
	pt_register("POST", "id_empresa");
	pt_register("POST", "ordem");
	pt_register("POST", "status");
	pt_register("POST", "pergunta");
	pt_register("POST", "resposta");
	pt_register("POST", "ab_data");
	pt_register("POST", "fc_data");
	pt_register("POST", "ab_hora");
	pt_register("POST", "fc_hora");
	pt_register("POST", "forma_atend");

	$error='<ul>';
	if($id_empresa=="" || $pergunta=="" ){
		if($id_empresa == "") $errors['id_empresa']=1;		
		if($pergunta == "") $errors['pergunta']=1;		
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

	$error.='</ul>';

	$c = new stdClass();
	$c->id_chamado = $id_chamado;
	$c->id_empresa = $id_empresa;
	$c->id_pedido = $id_pedido;
	$c->ordem = $ordem;
	$c->status = $status;
	$c->pergunta = $pergunta;
	$c->resposta = $resposta;
	$c->ab_data = $ab_data;
	$c->fc_data = $fc_data;
	$c->ab_hora = $ab_hora;
	$c->fc_hora = $fc_hora;
	$c->forma_atend = $forma_atend;
	$c->data1 = date('Y-m-d H:i:s');
	if($c->ab_data != '' && $c->ab_hora != ''){
		$data = explode('/',$c->ab_data);
		if(checkdate($data[1],$data[0],$data[2]) == 1){
			$c->data1 = $data[2].'-'.$data[1].'-'.$data[0].' '.$c->ab_hora.':00';
		}
	}
	if($c->status == '1'){
		$c->data2 = date('Y-m-d H:i:s');
	}
	if($c->fc_data != '' && $c->fc_hora != ''){
		$data = explode('/',$c->fc_data);
		if(checkdate($data[1],$data[0],$data[2]) == 1){
			$c->data2 = $data[2].'-'.$data[1].'-'.$data[0].' '.$c->fc_hora.':00';
		}
	}
	
	if(count($errors)==0){
		$chamadoDAO->atualizar($c);
		//alterado 01/04/2011
		$titulo = 'Mensagem da página web';
		$msg    = 'Registro atualizado com sucesso!';
		$pagina = '';
		$funcJs = "openAlertBox('".$titulo."','".$msg."','".$pagina."');";
		echo '<img src="../images/null.gif" class="nulo" onload="'.$funcJs.'" />';
	}
}else{
	pt_register("GET",   "id");
	$c = $chamadoDAO->buscaPorId($id);
}
include("chamado_form.php");
?>
</div>
<?php
require('footer.php'); ?>