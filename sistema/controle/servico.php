<?
require('header.php');
pt_register('GET','busca');
pt_register('GET','busca_id_departamento');
pt_register('GET','busca_id_servico');
pt_register('GET','pagina');
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$sDepartamentoDAO = new ServicoDepartamentoDAO();
$servicoDAO = new ServicoDAO();

$departamentos = $sDepartamentoDAO->listar();
$servicos = $servicoDAO->listaPorDepartamento($busca_id_departamento);
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_servico.png" alt="Título" />
Serviços</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<div style="clear: both; width: 100%; height: 50px">
<form name="buscador" action="" method="get"
	ENCTYPE="multipart/form-data">
<div style="float: left"><img src="../images/lupa.png" alt="busca" /></div>
<div><label
	style="width: 90px; font-weight: bold; padding-top: 5px; float: left">Departamento:</label>
<select name="busca_id_departamento" style="width: 200px; float: left"
	class="form_estilo" id="busca_id_departamento"
	onchange="carrega_servico(this.value,''); ">
	<option value=""
	<? if($busca_id_departamento=='') echo ' selected="selected" '; ?>>Todos</option>
	<?
	$p_valor='';
	foreach($departamentos as $departamento){
		$p_valor.='<option value="'.$departamento->id_servico_departamento.'"';
		$p_valor.=($busca_id_departamento==$departamento->id_servico_departamento)?' selected="selected" ':'';
		$p_valor.='>'.$departamento->departamento.'</option>';
	}echo $p_valor; ?>
</select> <label
	style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Serviço:</label>
<select name="busca_id_servico" style="width: 200px; float: left"
	class="form_estilo" id="id_servico">
	<option value=""
	<? if($busca_id_servico=='') echo ' selected="selected" '; ?>>Todos</option>
	<?
	$p_valor='';
	foreach($servicos as $servico){
		$p_valor .='<option value="'.$servico->id_servico.'"';
		$p_valor .=($busca_id_servico==$servico->id_servico)?' selected="selected" ':'';
		$p_valor .='>'.$servico->descricao.'</option>';
	} echo $p_valor;?>
</select> <input type="submit" name="submit" class="button_busca"
	value=" Buscar " /></div>
</form>
</div>

<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top"><? $servicos = $servicoDAO->busca($controle_id_empresa,$busca_id_departamento,$busca,$busca_id_servico,$pagina); ?>
		<form enctype="multipart/form-data" action="" method="post"
			name="pedido_print" target="_blank">
		<table width="100%" cellpadding="4" cellspacing="1"
			class="result_tabela">
			<tr>
				<td colspan="9" class="barra_busca"><? $servicoDAO->QTDPagina(); ?></td>
			</tr>
			<tr>
				<td class="result_menu"><b>Departamento</b></td>
				<td class="result_menu"><b>Descrição</b></td>
				<td class="result_menu"><b>Variação</b></td>
				<td class="result_menu" width="80" align="center"><b>Valor</b></td>
				<td class="result_menu" width="80" align="center"><b>Dias</b></td>
				<td class="result_menu" width="80" align="center"><b>Status</b></td>
				<td align="center" width="80" class="result_menu"><b>Editar</b></td>
			</tr>
			<?php foreach($servicos as $servico){ ?>
			<tr>
				<td class="result_celula"><?=$servico->departamento;?></td>
				<td class="result_celula"><?=$servico->descricao?></td>
				<td class="result_celula"><?=$servico->variacao?></td>
				<td class="result_celula" align="right"><input
					id="valor_<?=$servico->id_servico_var;?>" type="text"
					style="width: 70px"
					onkeyup="moeda(event.keyCode,this.value,'valor_<?=$servico->id_servico_var?>');"
					name="valor_<?=$servico->id_servico_var;?>"
					value="<?=$servico->valor;?>"></td>
				<td class="result_celula" align="center"><input type="text"
					style="width: 40px" name="dias_<?=$servico->id_servico_var?>"
					value="<?=$servico->dias;?>" onKeyUp="masc_numeros(this,'###');"></td>
				<td class="result_celula" align="center"><?=$servico->status;?></td>
				<td class="result_celula" align="center"><input type="button"
					name="registro_<?=$servico->id_servico_var;?>"
					onclick="servico_grava(valor_<?=$servico->id_servico_var?>.value,dias_<?=$servico->id_servico_var?>.value,'<?=$servico->id_servico_var?>')"
					value="Gravar"></td>
			</tr>
			<?}  ?>
			<tr>
				<td colspan="9" class="barra_busca"><? $servicoDAO->QTDPagina(); ?></td>
			</tr>
		</table>
		<div id="result_grava"></div>
		</form>
		</td>
	</tr>
</table>
</div>
			<?php require('footer.php'); ?>