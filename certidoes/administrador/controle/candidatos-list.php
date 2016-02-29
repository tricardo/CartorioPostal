<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'rh';
$title_pg = 'Lista: Candidatos';
$mesclar = '15';
require_once('../includes/header.php');
pt_register("GET","busca_dados");
pt_register("GET","busca_data");
pt_register("GET","busca_status");
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_candidatos',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}
if($deleta<>'' and in_array('3', $excluir_permissao_s)){
	$query = $objQuery->SQLQuery("SELECT * FROM cp_curriculo as cr WHERE cr.id_curriculo ='".$id."'");
	$num = mysql_num_rows($query);
	if($num<>''){
		$res = mysql_fetch_array($query);
		$file_path = "../../upload/".$res['arquivo'];
		if(file_exists($file_path)) unlink($file_path);
		$sql = $objQuery->SQLQuery("DELETE FROM cp_curriculo WHERE id_curriculo ='".$id."'");
	}
}
if($submit1){
	$id_anunc = explode(',', $_POST['id_anunc']);
	for($i = 0; $i < count($id_anunc)-1; $i++){
		pt_register('POST','alterar_status');
		if($errors!=1){
			$objQuery->SQLQuery("UPDATE cp_curriculo SET st_id='".$alterar_status."' WHERE id_curriculo='".$id_anunc[$i]."'");
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
							<td colspan="2"><label for="busca_dados" accesskey="1">Busca (ID / Nome do candidato)</label></td>
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
								<select name="busca_status" id="busca_status">
									<option value="">Todos</option>
									<?
									$sql = $objQuery->SQLQuery("SELECT * FROM cp_area_pretendida as ap WHERE ap.st_id='1' ORDER BY ap.area_pretendida ASC");
									while($res = mysql_fetch_array($sql)){
										echo '<option value="'.$res['area_pretendida'].'"';
										if($busca_area_pretendida==$res['area_pretendida']) echo 'selected="selected"'; 
										echo '>'.$res['area_pretendida'].'</option>';
									}
									?>
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
					<td width="20" align="center" valign="middle">ID</td>
					<td width="100" align="center" valign="middle">Área pretendida</td>
					<td width="250" align="left" valign="middle">Candidatos</td>
					<td width="250" align="left" valign="middle">Email</td>
					<td width="110" align="center" valign="middle">Telefone</td>
					<td width="110" align="center" valign="middle">Celular</td>
					<td width="40" align="center" valign="middle">Currículo</td>
					<td width="40" align="center" valign="middle">Cadastro</td>
					<td width="40" align="center" valign="middle">Imprimir</td>
					<? if(in_array('3', $excluir_permissao_s)){ ?>
					<td width="40" align="center" valign="middle">Excluir</td>
					<? } ?>
				</tr>
				<tr>
					<td class="td_list" colspan="<?= $mesclar?>"></td>
				</tr>
				<?
				$onde ="";
				if($busca_dados<>''){$onde .= " and (cr.id_curriculo like '".$busca_dados."' or cr.nome like '".$busca_dados."%' or cr.area_pretendida like '".$busca_dados."%') ";}
				if($busca_data<>''){$onde .= " and date_format(cr.data, '%d/%m/%Y') = '".$busca_data."' ";}
				$condicao = "FROM cp_curriculo as cr WHERE 1=1 " .$onde. " ORDER BY cr.id_curriculo DESC";
				$campo = "cr.id_curriculo, cr.area_pretendida, cr.nome, cr.email, cr.tel_cont, cr.tel_cel, cr.arquivo, cr.extensao, date_format(cr.data, '%d/%m/%Y') as data";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){ 
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="center" valign="middle">' . $res["id_curriculo"] . '</td>
						<td align="center" valign="middle">' . $res["area_pretendida"] . '</td>
						<td align="left" valign="middle">' . $res["nome"] . '</td>
						<td align="left" valign="middle">' . $res["email"] . '</td>
						<td align="center" valign="middle">' . $res["tel_cont"] . '</td>
						<td align="center" valign="middle">' . $res["tel_cel"] . '</td>
						<td align="center">';
						if($res['arquivo']==""){
						$p_valor .= '<img src="../images/paginas/image-remove-file.png" alt="image-remove" />';
						}else{
						$p_valor .= '
						<a href="../../upload/' . $res["arquivo"] . '" title="Clique aqui" target="_blank"><img src="../images/extensoes/' . $res["extensao"] . '.png" border="0" width="30" height="30"/></a>';
						}
						$p_valor .= '
						</td>
						<td align="center" valign="middle">' . $res["data"] . '</td>
						<td align="center" valign="middle"><a href="candidatos-print.php?id=' . $res["id_curriculo"] . '" title="Clique aqui" target="_blank"><img src="../images/paginas/bt-print-view.png" alt="bt-print-view" /></a></td>';
						if(in_array('3', $excluir_permissao_s)){
						$p_valor .= '
						<form name="form" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirm(\'Deseja excluir este registro ?\');">
							<td align="center" valign="middle">
								<input type="hidden" name="id" value="'.$res["id_curriculo"].'" />
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