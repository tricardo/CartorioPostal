<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'depoimento';
$title_pg = 'Lista: Comentários';
$mesclar = '15';
require_once('../includes/header.php');
pt_register("GET","busca_dados");
pt_register("GET","busca_data");
pt_register("GET","busca_status");
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_depoimento',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}
if($deleta<>'' and in_array('11', $excluir_permissao_s)){
	$query = $objQuery->SQLQuery("SELECT * FROM cp_depoimento as dp WHERE dp.id_depoimento ='".$id."'");
	$num = mysql_num_rows($query);
	if($num<>''){
		$res = mysql_fetch_array($query);
		$file_path = "../../upload/".$res['imagem'];
		if(file_exists($file_path)) unlink($file_path);
		$sql = $objQuery->SQLQuery("DELETE FROM cp_depoimento WHERE id_depoimento ='".$id."'");
	}
}
if($submit1){
	$id_anunc = explode(',', $_POST['id_anunc']);
	for($i = 0; $i < count($id_anunc)-1; $i++){
		pt_register('POST','alterar_status');
		if($errors!=1){
			$objQuery->SQLQuery("UPDATE cp_depoimento SET status='".$alterar_status."' WHERE id_depoimento='".$id_anunc[$i]."'");
			$id = $objQuery->ID;
			$done=1;
		}
	}
}
?>
<div class="estrutura">
	<div class="conteudo">
		<div class="fundo_menu_add">
			<div class="title_page">
				<!--/tabela:icone-titulo/-->
				<table width="100%" align="center" cellspacing="0" cellpadding="0">
					<tr>
						<td width="10%" align="left" valign="middle">
							<img src="../images/paginas/icon-list.png" alt="icon-list" />
						</td>
						<td width="90%" align="left" valign="middle">
							<span style="margin-left:5px;"><?= $title_pg?></span>
						</td>
					</tr>
				</table>
				<!--/tabela:fim/-->
			</div>
			<div class="prev">
				<a href="#" title="Clique aqui para voltar" class="prev"><img src="../images/paginas/anterior.png" alt="anterior" /></a>
			</div>
				<? require_once('menu-list.php'); ?>
			<div class="next">
				<a href="#" title="Clique aqui para avançar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:filtro-pesquisa/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						FILTRO DE PESQUISA
					</th>
				</tr>
				<td align="center" valign="top" class="td_info">
					<!--/tabela:lado-left/-->
					<table width="100%">
						<tr>
							<td align="center" valign="middle" width="5%">
								<img src="../images/paginas/undo.png" alt="undo" align="center" />
							</td>
							<td align="left" valign="middle" width="50%">
								<a href="javascript:history.back()" title="Clique aqui" class="link_normal">Voltar para página anterior</a>
							</td>
						</tr>
						<?
						$permissao = verifica_permissao('editar_depoimento',$controle_permissao_p,$controle_permissao_s);
						if($permissao == 'TRUE'){
						?>
						<!--/fomulário:alterar-status/-->
						<form name="form" action="" method="POST" enctype="multipart/form-data">
						<th align="center" valign="middle" colspan="2"><label for="alterar_status" accesskey="1">ALTERAR STATUS</label></th>
						<tr>
							<td align="left" valign="middle" height="25" colspan="2">
							<select name="alterar_status" id="alterar_status" style="margin-top:5px;margin-bottom:5px;">
								<option value="">---</option>
								<option value="1" <? if($alterar_status=='1') echo 'selected'; ?>>Ativar</option>
								<option value="0" <? if($alterar_status=='0') echo 'selected'; ?>>Inativo</option>
							</select>
							<input type="submit" name="submit1" value="Alterar" onclick="VerificaCheckSel();" style="height:30px" />
							<input type="hidden" name="id_anunc" id="id_anunc" />
							</td>
						</tr>
						</form>
						<!--/fomulário:fim/-->
						<?}?>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<!--/fomulário:filtro-pesquisa/-->
				<form name="form" action="" method="GET" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%" border="0">
						<tr>
							<td colspan="2"><label for="busca_dados" accesskey="1">Busca (ID / Unidade / Nome / E-mail)</label></td>
							<td width="13%" rowspan="4" align="center" valign="middle"><input type="submit" name="submit1" id="search" value=" " title="Clique aqui para fazer a pesquisa" /></td>
						</tr>
						<tr>
							<td colspan="2" align="left" valign="middle"><input name="busca_dados" type="text" id="busca_dados" value="<?= $busca_dados?>" /></td>
						</tr>
						<tr>
							<td width="45%"><label for="busca_data" accesskey="3">Cadastro</label></td>
							<td width="42%"><label for="busca_status" accesskey="2">Status</label></td>
						</tr>
						<tr>
							<td><input name="busca_data" type="text" id="busca_data" value="<?= $busca_data?>" /></td>
							<td>
								<select name="busca_status" id="alterar_status">
									<option value="">Todos</option>
									<option value="1" <? if($busca_status=='1') echo 'selected'; ?>>Ativar</option>
									<option value="0" <? if($busca_status=='0') echo 'selected'; ?>>Inativo</option>
								</select>
							</td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</form>
				<!--/fomulário:fim/-->
				</td>
				<tr>
					<td colspan="2" class="th_info"></td>
				</tr>
			</table>
			<!--/tabela:fim/-->
			<!--/tabela:lista/-->
			<table width="1000" class="table_list">
				<tr>
					<td width="20" align="left" >
					<input type="checkbox" name="" onclick="checkall(1);" id="chk1" title="Clique aqui para selecionar todos os registros" />
					<input type="checkbox" name="" onclick="checkall(0);" id="chk0" style="display:none" title="Clique aqui para selecionar o registro" />
					</td>
					<td width="20" align="center" valign="middle">ID</td>
					<td width="239" align="left" valign="middle">Unidade</td>
					<td width="220" align="left" valign="middle">Nome</td>
					<td width="200" align="left" valign="middle">Email</td>
					<td width="40" align="center" valign="middle">Cadastro</td>
					<td width="40" align="center" valign="middle">Status</td>
					<td width="40" align="center" valign="middle">Editar</td>
					<? if(in_array('11', $excluir_permissao_s)){ ?>
					<td width="40" align="center" valign="middle">Excluir</td>
					<? } ?>
				</tr>
				<tr>
					<td class="td_list" colspan="<?= $mesclar?>"></td>
				</tr>
				<?
				$onde ="";
				if($busca_dados<>''){$onde .= " and (dp.id_depoimento like '".$busca_dados."' or ue.fantasia like '%".$busca_dados."%' or dp.nome like '".$busca_dados."%' or dp.email like '".$busca_dados."%') ";}
				if($busca_data<>''){$onde .= " and date_format(dp.data, '%d/%m/%Y') = '".$busca_data."' ";}
				if($busca_status<>''){$onde .= " and dp.status='".$busca_status."'";}
				$condicao = "FROM cartorio_banco2.vsites_user_empresa as ue, cp_depoimento as dp WHERE dp.id_empresa=ue.id_empresa " .$onde. " ORDER BY dp.id_depoimento DESC";
				$campo = "ue.id_empresa, ue.fantasia, dp.id_depoimento, dp.nome, dp.email, date_format(dp.data, '%d/%m/%Y') as data, dp.status";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){ 
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="left" valign="middle"><input value="'.$res["id_depoimento"].'" type="checkbox" name="checklister" id="checklister'.$i.'" title="Clique aqui para selecionar o registro" /></td>
						<td align="center" valign="middle">' . $res["id_depoimento"] . '</td>
						<td align="left" valign="middle">' . str_replace('Cartório Postal - ','',$res["fantasia"]) . '</td>
						<td align="left" valign="middle">' . $res["nome"] . '</td>
						<td align="left" valign="middle">' . $res["email"] . '</td>
						<td align="center" valign="middle">' . $res["data"] . '</td>
						<td align="center">';
							if($res['status']=="1"){
							$p_valor .= 'Ativo';
							}else{
							$p_valor .= '
							Inativo';
							}
							$p_valor .= '
						</td>
						<td align="center" valign="middle"><a href="depoimento-edit.php?id=' . $res["id_depoimento"] . '" title="Clique aqui"><img src="../images/paginas/bt-editar.png" alt="bt-editar" /></a></td>';
						if(in_array('7', $excluir_permissao_s)){
						$p_valor .= '
						<form name="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm(\'Deseja excluir este registro ?\');">
							<td align="center" valign="middle">
								<input type="hidden" name="id" value="'.$res["id_depoimento"].'" />
								<input type="hidden" name="deleta" value="Deletar" /> 
								<input type="image" src="../images/paginas/bt-deletar.png" name="deletar" value="Deletar" alt="bt-deletar" title="Clique aqui" />
							</td>
						</form>';
					}
					$p_valor .= '
					</tr>';
					$i++;
				}
				echo $p_valor;
				?>
				<tr>
					<td align="center" valign="middle" colspan="<?= $mesclar?>">
					<?
					$objQuery->QTDPagina();
					?>
					<input type="hidden" value="<?= $i?>" id="totalcheck" />
					</td>
				</tr>
			</table>
			<!--/tabela:fim/-->
		</div>
	</div>
</div>
<?
require_once('../includes/footer.php');
?>