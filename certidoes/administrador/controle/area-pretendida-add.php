<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'rh';
$title_pg = 'Cadastro: Novo �rea';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','area_pretendida');

$permissao = verifica_permissao('cadastro_area_pretendida',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($area_pretendida==""){
			if($area_pretendida=="")	$errors['area_pretendida']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho s�o obrigat�rios.</span><br />";
		}
		if(count($errors)<1){
			$query="INSERT INTO cp_area_pretendida (area_pretendida, data, st_id) values ('".$area_pretendida."',NOW(),'1')";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;
			$done=1;
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
							<img src="../images/paginas/icon-oportunidade.png" alt="icon-oportunidade" />
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
				<? require_once('menu-add.php'); ?>
			<div class="next">
				<a href="#" title="Clique aqui para avan�ar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:adicionar-usu�rio/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						ADICIONAR UMA NOVA �REA
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
								<a href="javascript:history.back()" title="Clique aqui" class="link_normal">Voltar para p�gina anterior</a>
							</td>
						</tr>
						<?
						if($error!=''){
							echo'<tr>
									<td align="center" valign="middle" class="td_info">
										<img src="../images/paginas/info.png" alt="info" align="center" />
									</td>
									<td align="left" valign="bottom" class="td_info">
										<strong>Ocorreram os seguintes erros:</strong>
									</td>
								</tr>
								<tr>
									<td align="left" valign="middle" colspan="2">';
										if($errors){
											echo $error;
										}
								echo'</td>
								</tr>';
						}?>
						<tr>
							<?
							$permissao = verifica_permissao('lista_area_pretendida',$controle_permissao_p,$controle_permissao_s);
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
										$permissao = verifica_permissao('lista_area_pretendida',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="area-pretendida-list.php" title="Clique aqui" class="link_lista">Lista: �reas</a>
										<?}?>
									</li>
								</ul>
							</td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divis�o/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<?
				if($done!=1){
				?>
				<!--/fomul�rio:keywords-add/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="area_pretendida" accesskey="1">Nome da �rea</label></td>
						</tr>
						<tr>
							<td><input name="area_pretendida" type="text" id="area_pretendida" value="<?= $area_pretendida?>" <?=($errors['area_pretendida'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td><input name="submit1" type="submit" value="Cadastrar" title="Clique aqui para fazer o cadastro" /></td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</form>
				<!--/fomul�rio:fim/-->
				<?
				}
				?>
				<?
				if($done){
					echo '<div id="load"><img src="../images/paginas/load.gif" alt="load" width="28" /></div>
						<img src="../images/paginas/resposta-confirmacao.png" alt="resposta-confirmacao" />';
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=area-pretendida-add.php" />';
				}
				?>
				</td>
				<tr>
					<td colspan="2" class="th_info"></td>
				</tr>
			</table>
			<!--/tabela:fim/-->
		</div>
	</div>
</div>
<?
require_once('../includes/footer.php');
?>