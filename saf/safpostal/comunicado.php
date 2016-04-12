<?
require "../includes/topo.php";
require( '../js/fckeditor/fckeditor.php' );
$permissao = verifica_permissao('COMUNICADO',$safpostal_departamento_saf);
if($safpostal_id_empresa=="1" and $permissao=='FALSE'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	echo $safpostal_id_usuario;
	exit;
}
?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="3" height="2"></td>
	</tr>
	<tr>
		<td width="150" align="left" valign="top">
			<table width="150" border="0" cellspacing="0" cellpadding="0" align="left">
				<tr>
					<td><? require "menu_lateral.php"; ?></td>
				</tr>
			</table>
		</td>
		<td width="2"></td>
		<td align="left" valign="top">
			<table width="768" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png">
						<table width="768" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="345" height="20" align="left" valign="middle"><strong>Mala Direta</strong></td>
							<td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<div id="conteudo">
							<?
							pt_register('POST','submit1');
							if ($submit1){
								//check for errors
								$departamento_m = '';
								$onde = '';
								$error = '';
								$errors = '';
								pt_register('POST','id_empresa');
								pt_register('POST','assunto');
								pt_register('POST','texto');
								$texto = str_replace('\"','"',$texto);
								if($id_news<>''){
									$sql = $objQuery->SQLQuery("SELECT * FROM saf_news as n WHERE id_news='".$id_news."'");
									$res = mysql_fetch_array($sql);
									$Subject = $res['assunto'];
									$html = $res['texto'];
								} else {
									$Subject = $assunto;
									$html = $texto;
								}
								$sql = $objQuery->SQLQuery("INSERT INTO saf_maladireta(data,status,id_news,id_empresa,departamento, assunto, texto, id_usuario) values(NOW(),1,'".$id_news."','".$id_empresa."','".$departamento."','".$assunto."','".$texto."','".$safpostal_id_usuario."')");
								$id_maladireta = $objQuery->ID;
								
								include("../../includes/maladireta/class.PHPMailer.php");
								$mailer = new SMTPMailer();
								$_SESSION['username_send_mail']=0;
								
								$sql = $objQuery->SQLQuery("SELECT * FROM vsites_departamento as d WHERE id_departamento!='1' ORDER BY departamento");
								$cont_dep='';
								while($res = mysql_fetch_array($sql)){
									$id_departamento=$res['id_departamento'];
									pt_register('POST','envia_'.$id_departamento);
									if(${'envia_'.$id_departamento}=='on'){ 
										if($cont_dep==''){ 
											$onde .= " AND (uu.departamento_p like '%,".$id_departamento.",%' OR uu.departamento_p like '".$id_departamento.",%' OR uu.departamento_p like '%,".$id_departamento."'"; 
										} else {
											$onde .= " OR uu.departamento_p like ',%".$id_departamento."%,' OR uu.departamento_p like '".$id_departamento.",%' OR uu.departamento_p like '%,".$id_departamento."' ";
										}
										$departamento = $id_departamento.',';
										$cont_dep++;
									}
								}
								if($cont_dep<>0) $onde .= ')';
								if($id_empresa<>'') $onde .= " AND uu.id_empresa='".$id_empresa."'";
								if($erro==''){
									$sql = $objQuery->SQLQuery("SELECT uu.email, uu.nome, LENGTH(uu.email) FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE 
									(ue.status='Ativo' OR ue.status='Inativo') AND 
									ue.id_empresa=uu.id_empresa AND
									uu.status='Ativo'  AND 
									uu.id_empresa!=1
									".$onde);
									$lista_email="";
									while($res = mysql_fetch_array($sql)){
										$cont++;
										$lista_email.= $res['email'].';';
									}
									$From = 'Mala Direta';
									$AddAddress = 'claudia.mattos@cartoriopostal.com.br;fabiana.abreu@cartoriopostal.com.br;thauan.ricardo@ssiconsultoria.con.br;';
									#$AddAddress = "rafael.nascimento@softfox.com.br;erick.melo@softfox.com.br;antonio.alves@softfox.com.br;";
									$AddCC = '';
									#$AddCC = 'renato.amorim@softfox.com.br;luiz.fernando@softfox.com.br';
									$AddBCC = $lista_email.'ti@cartoriopostal.com.br';
									$Subject = 'Comunicado '.$id_maladireta.' - '.$assunto;
									$mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html); 
									$_SESSION['username_send_mail']=0;
									$done = 1;
								} else {
									echo $erro;
								}
							}
							if ($errors) {
								echo '<div class="respotas_erro">'.$error.'</div>';
							}
							?>
							<?
							if ($done) {
							echo '<div class="respotas_sucesso"><br>MALA DIRETA ENVIADA COM SUCESSO!<br><a href="comunicado.php">Clique para voltar</a><br>
									</div>';
							}
							if($done == ''){
							?>
								<form name="form_forum" action="" method="post" enctype="multipart/form-data">
									<table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
										<tr>
											<td>
												<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
													<tr>
														<td height="50" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><strong>MALA DIRETA</strong></td>
													</tr>
													<? 
													$cont_seg=0;
													$cont_sub=0;
													$sql = $objQuery->SQLQuery("SELECT * FROM vsites_departamento WHERE id_departamento!='1' ORDER BY departamento");
													while($res = mysql_fetch_array($sql)){
													?>
													<tr>
														<td align="right" nowrap bgcolor="#FFFFFF" class="result_celula"><strong><?= $res['departamento'] ?>:</strong></td>
														<td align="center" nowrap bgcolor="#FFFFFF" class="result_celula"><input type="checkbox" name="envia_<?= $res['id_departamento'] ?>" /></td>
													</tr>
													<?
													}
													?>
													<tr>
														<td align="right" valign="middle" bgcolor="#FFFFFF"><span style="font-weight: bold">Franquias:</span></td>
														<td align="left" valign="middle" bgcolor="#FFFFFF">
															<select name="id_empresa" style="width:315px" id="empresas">
																<option value="">Todas</option>
																<?
																$sql = $objQuery->SQLQuery("SELECT id_empresa, fantasia FROM vsites_user_empresa as ue WHERE status = 'Ativo' or status = 'Inativo' ORDER BY fantasia");
																while($res = mysql_fetch_array($sql)){
																	echo '<option value="'.$res['id_empresa'].'" ';
																	if($busca_id_empresa==$res['id_empresa']) echo ' selected="selected"'; 
																	echo '>'.$res['fantasia'].'</option>';
																}
																?>
																</select>
														</td>
													</tr>
													<tr>
														<td align="left" valign="middle" bgcolor="#FFFFFF"><strong>Assunto:</strong></td>
														<td align="left" valign="middle" bgcolor="#FFFFFF"><input type="text" value="<?= $assunto ?>" name="assunto" style="width:460px;"/><span style="color:#FF0000">*</span></td>
													</tr>
													<tr>
														<td colspan="2" align="left" valign="middle" bgcolor="#FFFFFF">
															<?
															$oFCKeditor = new FCKeditor('texto');
															$oFCKeditor->voltarConfig['AutoDetectLanguage'] = false; 
															$oFCKeditor->Config['DefaultLanguage'] = 'pt';
															$oFCKeditor->BasePath = '../js/fckeditor/';
															$oFCKeditor->Value = $texto;
															$oFCKeditor->ToolbarSet = 'Default' ; //'Default'
															$oFCKeditor->Width = '700px';
															$oFCKeditor->Height = '450px';
															$oFCKeditor->Create() ;
															?>
															<input type="hidden" value="<?= $id_news ?>" name="id_news">
														</td>
													</tr>
													<tr>
														<td bgcolor="#FFFFFF"></td>
														<td align="left" valign="middle" bgcolor="#FFFFFF"><input name="submit1" type="submit" class="botoes" value="Enviar" /></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</form>
							<?
							}
							?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?
require "../includes/rodape.php";
?>