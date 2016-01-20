<?
require('header.php');
require('../includes/dias_uteis.php');
$permissao = verifica_permissao('Rel_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('POST','busca_id_departamento');
pt_register('POST','busca_id_usuario_op');
$onde ='';
if($busca_id_departamento<>''){ $onde .= " and pi.id_servico_departamento='".$busca_id_departamento."'"; }
if($busca_id_usuario_op<>''){ $onde .= " and pi.id_usuario_op='".$busca_id_usuario_op."'"; }

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

	$mes=date('m');
	$ano=date('Y');

?>
<div style="margin:15px;">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">
    <h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título" /> Relatório por Departamento</h1>
    <hr class="tit"/><br />

    <form name="buscador" action="gera_operacional.php" target="_blank" method="post" ENCTYPE="multipart/form-data">
		<div style="float:left">
			<img src="../images/lupa.png" alt="busca" />
        </div>
        <div style="width:320px; float:left;">
            <label style="width:90px; font-weight:bold; padding-top:5px; float:left; text-align:right">Mês: </label>

			<select name="mes" class="form_estilo" style="width:150px; float:left">
	                  <option value="01" <? if($mes=='01') echo 'selected="select"'; ?>>Janeiro</option>
	                  <option value="02" <? if($mes=='02') echo 'selected="select"'; ?>>Fevereiro</option>
	                  <option value="03" <? if($mes=='03') echo 'selected="select"'; ?>>Março</option>
	                  <option value="04" <? if($mes=='04') echo 'selected="select"'; ?>>Abril</option>
	                  <option value="05" <? if($mes=='05') echo 'selected="select"'; ?>>Maio</option>
	                  <option value="06" <? if($mes=='06') echo 'selected="select"'; ?>>Junho</option>
	                  <option value="07" <? if($mes=='07') echo 'selected="select"'; ?>>Julho</option>
	                  <option value="08" <? if($mes=='08') echo 'selected="select"'; ?>>Agosto</option>
	                  <option value="09" <? if($mes=='09') echo 'selected="select"'; ?>>Setembro</option>
	                  <option value="10" <? if($mes=='10') echo 'selected="select"'; ?>>Outubro</option>
	                  <option value="11" <? if($mes=='11') echo 'selected="select"'; ?>>Novembro</option>
	                  <option value="12" <? if($mes=='12') echo 'selected="select"'; ?>>Dezembro</option>
           </select>
		   
            <label style="width:90px; font-weight:bold; padding-top:5px; float:left; text-align:right">Ano: </label>

			<select name="ano" class="form_estilo" style="width:150px; float:left">
	             <?for($i = 2009; $i <= date('Y'); $i++){?>
					<option value="<?=$i?>"<?=($i == $ano) ? ' selected="selected"':''?>><?=$i?></option>
					<?}?>
           </select>	
		   
			<input type="submit" name="submit" class="button_busca" value=" Buscar " /><br><br>
        </div>
	</form><br />
	<br />
</div>
<?php 
	require('footer.php');
?>