<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'treinadores';
$title_pg = 'Lista: Treinadores';
$mesclar = '15';
require_once('../includes/header.php');
pt_register("GET","busca_id_treinador");
pt_register("GET","busca_treinador");
pt_register("GET","busca_area");
pt_register("GET","busca_data");
pt_register("GET","busca_status");
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_treinadores',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}
if($deleta<>'' and in_array('4', $excluir_permissao_s)){
	$query = $objQuery->SQLQuery("SELECT * FROM site_treinadores as tr WHERE tr.id_treinador ='".$id."'");
	$num = mysql_num_rows($query);
	if($num<>''){
		$res = mysql_fetch_array($query);
		$sql = $objQuery->SQLQuery("DELETE FROM site_treinadores WHERE id_treinador ='".$id."'");
	}
}
if($submit1){
	$id_anunc = explode(',', $_POST['id_anunc']);
	for($i = 0; $i < count($id_anunc)-1; $i++){
		pt_register('POST','alterar_status');
		if($errors!=1){
			$objQuery->SQLQuery("UPDATE site_treinadores SET status='".$alterar_status."' WHERE id_treinador='".$id_anunc[$i]."'");
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
						<tr>
							<?
							$permissao = verifica_permissao('cadastro_treinadores',$cp_permissao_p,$cp_permissao_s);
							if($permissao == 'TRUE'){
							?>
							<td align="center" valign="top" class="td_info">
								<img src="../images/paginas/list.png" alt="list" align="center" />
							</td>
							<?}?>
							<td align="left" valign="top" class="td_info">
								<ul id="lista">
									<li>
										<?
										$permissao = verifica_permissao('cadastro_treinadores',$cp_permissao_p,$cp_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="treinadores-add.php" title="Clique aqui" class="link_lista">Cadastro: Treinadores</a>
										<?}?>
									</li>
								</ul>
							</td>
						</tr>
						<?
						$permissao = verifica_permissao('editar_treinadores',$cp_permissao_p,$cp_permissao_s);
						if($permissao == 'TRUE'){
						?>
						<!--/fomulário:alterar-status/-->
						<form name="form" action="" method="POST" enctype="multipart/form-data">
						<th align="center" valign="middle" colspan="2"><label for="alterar_status" accesskey="1">ALTERAR STATUS</label></th>
						<tr>
							<td align="left" valign="middle" height="25" colspan="2">
							<select name="alterar_status" id="alterar_status" style="margin-top:5px;margin-bottom:5px;" title="Selecione um status">
							<option value="">---</option>
							<?
							$sql = $objQuery->SQLQuery("SELECT * FROM cp_status as su ORDER BY su.st_id");
							while($res = mysql_fetch_array($sql)){
								echo '<option value="'.$res['status'].'"';
								if($alterar_status==$res['status']) echo 'selected="selected"'; 
								echo '>'.$res['status'].'</option>';
							}
							?>
							</select>
							<input type="submit" name="submit1" value="Alterar" onclick="VerificaCheckSel();" style="height:30px" title="Clique aqui para alterar o status" />
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
							<td align="left"><label for="busca_id_treinador" accesskey="1">ID</label></td>
							<td align="left"><label for="busca_treinador" accesskey="2">Treinador(a)</label></td>
							<td align="center" valign="middle" rowspan="6"><input type="submit" name="submit1" id="search" tabindex="5" value=" " title="Clique aqui para fazer a pesquisa" /></td>
						</tr>
						<tr>
							<td><input name="busca_id_treinador" type="text" id="busca_id_treinador" tabindex="1" value="<?= $busca_id_treinador?>" /></td>
							<td><input name="busca_treinador" type="text" id="busca_treinador" tabindex="2" value="<?= $busca_treinador?>" /></td>
						</tr>
						<tr>
							<td align="left"><label for="busca_area" accesskey="3">Área</label></td>
							<td align="left"><label for="busca_data" accesskey="3">Cadastro</label></td>
						</tr>
						<tr>
							<td><input name="busca_area" type="text" id="busca_area" tabindex="1" value="<?= $busca_area?>" /></td>
							<td><input name="busca_data" type="text" id="busca_data" tabindex="1" value="<?= $busca_data?>" /></td>
						</tr>
						<tr>
							<td align="left"><label for="busca_status" accesskey="3">Status</label></td>
							<td align="left"></td>
						</tr>
						<tr>
							<td>
								<select name="busca_status" id="busca_status" tabindex="4">
								<option value="">Todos</option>
								<?
								$sql = $objQuery->SQLQuery("SELECT * FROM cp_status as u ORDER BY u.st_id");
								while($res = mysql_fetch_array($sql)){
									echo '<option value="'.$res['status'].'"';
									if($busca_status==$res['status']) echo 'selected="selected"'; 
									echo '>'.$res['status'].'</option>';
								}
								?>
								</select>
							</td>
							<td></td>
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
					<td width="380" align="left" valign="middle">Treinador(a)</td>
					<td width="380" align="left" valign="middle">Área</td>
					<td width="40" align="center" valign="middle">Cadastro</td>
					<td width="40" align="center" valign="middle">Status</td>
					<td width="40" align="center" valign="middle">Editar</td>
					<? if(in_array('4', $excluir_permissao_s)){ ?>
					<td width="40" align="center" valign="middle">Excluir</td>
					<? } ?>
				</tr>
				<tr>
					<td class="td_list" colspan="<?= $mesclar?>"></td>
				</tr>
				<?
				$onde ="";
				if($busca_id_treinador<>''){$onde .= " and tr.id_treinador like '".$busca_id_treinador."%' ";}
				if($busca_treinador<>''){$onde .= " and tr.treinador like '".$busca_treinador."%' ";}
				if($busca_area<>''){$onde .= " and tr.area like '".$busca_area."%' ";}
				if($busca_data<>''){$onde .= " and date_format(tr.data, '%d/%m/%Y') = '".$busca_data."' ";}
				if($busca_status<>''){$onde .= " and tr.status='".$busca_status."'";}
				$condicao = "FROM cartorio_sistecart.site_treinadores as tr WHERE 1=1 " .$onde. " ORDER BY tr.id_treinador DESC";
				$campo = "tr.id_treinador, tr.treinador, tr.area , tr.status, date_format(tr.data, '%d/%m/%Y') as data";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="left" valign="middle"><input value="'.$res["id_treinador"].'" type="checkbox" name="checklister" id="checklister'.$i.'" title="Clique aqui para selecionar o registro" /></td>
						<td align="center" valign="middle">' . $res["id_treinador"] . '</td>
						<td align="left" valign="middle">' . $res["treinador"] . '</td>
						<td align="left" valign="middle">' . $res["area"] . '</td>
						<td align="center" valign="middle">' . $res["data"] . '</td>
						<td align="center" valign="middle">' . $res["status"] . '</td>
						<td align="center" valign="middle"><a href="treinadores-edit.php?id=' . $res["id_treinador"] . '" title="Clique aqui"><img src="../images/paginas/bt-editar.png" alt="bt-editar" /></a></td>';
						if(in_array('4', $excluir_permissao_s)){
						$p_valor .= '
						<form name="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm(\'Deseja excluir este registro ?\');">
							<td align="center" valign="middle">
								<input type="hidden" name="id" value="'.$res["id_treinador"].'" />
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