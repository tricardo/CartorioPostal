<? require('header.php');?>
<div id="topo"><?
pt_register('GET','relatorio');
if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	&& verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
	){
	if($relatorio=='royalties'){
		if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
			echo '<br><br><strong>Você não tem permissão para acessar essa página de royalties</strong>';
			exit;
		}
	}else{
		echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
		exit;
	}
}
$dia='1';
$mes=date('m');
$ano=date('Y');

switch($relatorio){
	case 'geral':
		$relatorio = 'relatório geral';
		$desc = 'Gerencial';
		break;
	case 'pendente':
		$relatorio = 'em pendente';
		$desc = 'Pendente';
		break;
	case 'cancelados':
		$relatorio = 'relatório de cancelados';
		$desc = 'Cancelados';
		break;
	default:
		$desc = $relatorio;
}

?>
<h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título" />
Relatório <?php echo $desc ?></h1>
<hr class="tit" />
<br />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form name="buscador" action="rel_geral_lista.php" method="get">
		<div style="float: left"><img src="../images/lupa.png" alt="busca" />
		</div>
		<div style="width: 280px; position: relative"><label
			style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Mês</label>
		<input type="hidden" name="relatorio" value="<?php echo $relatorio ?>" />
		<select name="mes" class="form_estilo"
			style="width: 150px; float: left">
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
		</select> <label
			style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Ano</label>
		<select name="ano" class="form_estilo"
			style="width: 150px; float: left">
			<option value="2009" <? if($ano=='2009') echo 'selected="select"'; ?>>2009</option>
			<option value="2010" <? if($ano=='2010') echo 'selected="select"'; ?>>2010</option>
			<option value="2011" <? if($ano=='2011') echo 'selected="select"'; ?>>2011</option>
			<option value="2012" <? if($ano=='2012') echo 'selected="select"'; ?>>2012</option>
			<option value="2013" <? if($ano=='2013') echo 'selected="select"'; ?>>2013</option>
			<option value="2014" <? if($ano=='2014') echo 'selected="select"'; ?>>2014</option>
			<option value="2014" <? if($ano=='2015') echo 'selected="select"'; ?>>2015</option>
			<option value="2014" <? if($ano=='2016') echo 'selected="select"'; ?>>2016</option>
			<option value="2014" <? if($ano=='2017') echo 'selected="select"'; ?>>2017</option>
			<option value="2014" <? if($ano=='2018') echo 'selected="select"'; ?>>2018</option>
			<option value="2014" <? if($ano=='2019') echo 'selected="select"'; ?>>2019</option>
		</select> 
		<? if($controle_id_empresa==1){?> 
			<label style="width: 121px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Franquia</label>
			<select name="id_empresa" class="form_estilo" style="width: 150px; float: left">
			<option></option>
			<?
			$empresaDAO = new EmpresaDAO();
			$empresas = $empresaDAO->listarTodas();
			$p_valor='';
			foreach($empresas as $empresa){
				$p_valor.='<option value="'.$empresa->id_empresa.'">';
				$p_valor.=$empresa->fantasia.'</option>';
			}
			echo $p_valor;
			?>
			</select> <? } ?>
			<input type="submit" name="submit" class="button_busca" style="float: left" value=" Buscar " />
		</div>
		</form>
		<br />
		</td>
	</tr>

</table>
</div>
<?php
require('footer.php');
?>