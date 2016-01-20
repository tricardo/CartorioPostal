<?
require('header.php');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" />
Gera Remessa do Cartório</h1>
<a href="#" class="topo">topo</a><br />
<hr class="tit" />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<form enctype="multipart/form-data" action="gera_remessa_cart.php"
			method="post" name="gera_remessa_cart" target="_blank">
		<center>
		<table width="650" class="tabela">
			<tr>
				<td colspan="4" class="tabela_tit">Remessa</td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Cliente: </strong></div>
				</td>
				<td width="313" colspan="3"><select name="id_cliente" style="width: 493px" class="form_estilo">
					<?
					switch($controle_id_empresa){
						case 6:
							#suzano
							$onde = " (uc.id_cliente='95219') ";
							break;
						case 20:
							#SJRP
							$onde = " (uc.id_cliente='89607') ";
							break;
						case 192:
							#boituva
							$onde = " (uc.id_cliente='129079') ";
							break;
						case 1:
							$onde = " (uc.id_cliente='49117' or uc.id_cliente='89607' or uc.id_cliente='95219' or uc.id_cliente='129079') ";
							break;
						default:
							$onde = " 1=2 ";
					}
					$sql = $objQuery->SQLQuery("SELECT uc.* from vsites_user_cliente as uc, vsites_user_usuario as uu where uc.status='Ativo' and uc.conveniado='Sim' and uc.id_usuario=uu.id_usuario and ".$onde." order by uc.nome");
					while($res = mysql_fetch_array($sql)){
						echo '<option value="'.$res['id_cliente'].'" ';
						if($id_cliente==$res['id_cliente']) echo ' selected="selected"';
						echo '>'.$res['nome'].'</option>';
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td width="100">
				<div align="right"><strong>Serviço: </strong></div>
				</td>
				<td width="313" colspan="3"><select name="id_servico"
					style="width: 493px" class="form_estilo">
					<?
					$sql = $objQuery->SQLQuery("SELECT id_servico, descricao from vsites_servico as s where s.status='Ativo' and id_servico='17' order by descricao");
					while($res = mysql_fetch_array($sql)){
						echo '<option value="'.$res['id_servico'].'" ';
						if($id_servico==$res['id_servico']) echo ' selected="selected"';
						echo '>'.$res['descricao'].'</option>';
					}
					?>
				</select></td>
			</tr>
			<tr>
				<td colspan="4" align="center"><input type="submit" name="submit"
					value="Gerar"
					onclick="document.gera_remessa_cart.action='gera_remessa_cart.php'"
					class="button_busca" />&nbsp;</td>
			</tr>
		</table>
		</center>
		<center><br>
		<br>
		<table width="650" class="result_tabela" cellpadding="4"
			cellspacing="1">
			<tr>
				<td class="tabela_tit"><strong>Data </strong></td>
				<td class="tabela_tit"><strong>Arquivo </strong></td>
			</tr>
			<?
			$sql = $objQuery->SQLQuery("SELECT rc.* from vsites_remessa_cart as rc, vsites_user_usuario as uu where rc.id_usuario=uu.id_usuario and uu.id_empresa='".$controle_id_empresa."' order by rc.data desc limit 50");
			$p_valor = '';
			while($res = mysql_fetch_array($sql)){
				$p_valor .= '
					<tr>
						<td class="result_celula"> '.invert($res['data'],'/','PHP').'</td>
						<td class="result_celula"> <a href="download_remessa_cart.php?id_remessa_cart='.$res['id_remessa_cart'].'">'.$res['arquivo'].'</a></td>
					</tr>';
			}
			echo $p_valor;
			?>
		</table>
		</center>

		</form>
		</td>
	</tr>
</table>
</div>
			<?php
			require('footer.php');
			?>