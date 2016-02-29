<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'galeria_imagens';
$title_pg = 'Lista: Fachada';
$mesclar = '15';
require_once('../includes/header.php');
pt_register("GET","busca_id_empresa");
pt_register("GET","busca_empresa");
pt_register("GET","busca_data");
pt_register("GET","busca_status");
pt_register('POST','id');
pt_register('POST','deleta');
pt_register('GET','pagina');
pt_register('POST','submit1');

$permissao = verifica_permissao('lista_fachada',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
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
					<table width="100%">
						<tr>
							<td align="left"><label for="busca_id_empresa" accesskey="1">ID</label></td>
							<td align="left"><label for="busca_empresa" accesskey="2">Empresa</label></td>
							<td align="center" valign="middle" rowspan="6"><input type="submit" name="submit1" id="search" tabindex="5" value=" " title="Clique aqui para fazer a pesquisa" /></td>
						</tr>
						<tr>
							<td><input name="busca_id_empresa" type="text" id="busca_id_empresa" tabindex="1" value="<?= $busca_id_empresa?>" /></td>
							<td><input name="busca_empresa" type="text" id="busca_empresa" tabindex="2" value="<?= $busca_empresa?>" /></td>
						</tr>
						<tr>
							<td align="left" colspan="2"><label for="busca_status" accesskey="3">Status</label></td>
						</tr>
						<tr>
							<td colspan="2">
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
					<td width="860" align="left" valign="middle">Empresa</td>
					<td width="40" align="center" valign="middle">Imagem</td>
					<td width="40" align="center" valign="middle">Status</td>
					<td width="40" align="center" valign="middle">Editar</td>
				</tr>
				<tr>
					<td class="td_list" colspan="<?= $mesclar?>"></td>
				</tr>
				<?
				$onde ="";
				if($busca_id_empresa<>''){$onde .= " and ue.id_empresa like '".$busca_id_empresa."%' ";}
				if($busca_empresa<>''){$onde .= " and ue.fantasia like '%".$busca_empresa."%' ";}
				if($busca_data<>''){$onde .= " and date_format(ue.data, '%d/%m/%Y') = '".$busca_data."' ";}
				if($busca_status<>''){$onde .= " and ue.status='".$busca_status."'";}
				$condicao = "FROM cartorio_banco2.vsites_user_empresa as ue WHERE 1=1 " .$onde. " ORDER BY ue.fantasia ASC";
				$campo = "ue.id_empresa, ue.fantasia, ue.imagem, ue.status, date_format(ue.data, '%d/%m/%Y') as data";
				$url_busca = $_SERVER['REQUEST_URI'];
				$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
				$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
				$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 250000000000000000);
				$p_valor = "";
				$i = 0;
				while($res = mysql_fetch_array($query)){
					$p_valor .= '
					<tr onmouseover="this.bgColor=\'#EEEEEE\';" onmouseout="this.bgColor=\'#FFFFFF\';">
						<td align="center" valign="middle">' . $res["id_empresa"] . '</td>
						<td align="left" valign="middle">' . str_replace('Cartório Postal - ','',$res["fantasia"]) . '</td>
						<td align="center">';
						if($res['imagem']==""){
						$p_valor .= '<img src="../images/paginas/image-remove.png" alt="image-remove" />';
						}else{
						$p_valor .= '
						<img src="../../upload/' . $res["imagem"] . '" width="50" alt="" />';
						}
						$p_valor .= '
						</td>
						<td align="center" valign="middle">' . $res["status"] . '</td>
						<td align="center" valign="middle"><a href="fachada-edit.php?id=' . $res["id_empresa"] . '" title="Clique aqui"><img src="../images/paginas/bt-editar.png" alt="bt-editar" /></a></td>';
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