<? 
if($_GET['fontstyle']<>''){
	// redirecionamento permanente
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.cartoriopostal.com.br/avaliacao");
	exit();
}
?>
<?require('includes/header.php');?>
<div id="bg"></div>
	<div id="wrapper">
<? require('includes/topo.php'); ?>
	<div id="page">
		<div id="content">
			<div class="post">
			<h1 class="title">PESQUISA DE SATISFAÇÃO | AVALIAÇÃO DO TREINAMENTO</h1>
			<?
			pt_register('POST','submit2');
			if($submit2){
				$errors=array();
				$error="";
				$periodo_ini	= $_COOKIE['c_periodo_term'];
				$periodo_term	= $_COOKIE['c_periodo_term'];
				$franquia		= $_COOKIE['c_franquia'];
				pt_register('POST','id_treinador');
				pt_register('POST','periodo_ini');
				pt_register('POST','periodo_term');
				pt_register('POST','franquia');
				pt_register('POST','area');
				pt_register('POST','performance');
				pt_register('POST','nova_participacao');
				pt_register('POST','criticas');
				pt_register('POST','elogios');
				pt_register('POST','eficiencia');
				pt_register('POST','questao1');
				pt_register('POST','questao2');
				pt_register('POST','questao3');
				pt_register('POST','questao4');
				pt_register('POST','questao5');
				pt_register('POST','questao6');
				pt_register('POST','questao7');
				pt_register('POST','questao8');
					if($questao1=="" || $questao2=="" || $questao3=="" || $questao4=="" || $questao5=="" || $questao6=="" || $questao7=="" || $questao8=="" || $criticas==""){
						if($questao1=="")			$errors['questao1']=1;
						if($questao2=="")			$errors['questao2']=1;
						if($questao3=="")			$errors['questao3']=1;
						if($questao4=="")			$errors['questao4']=1;
						if($questao5=="")			$errors['questao5']=1;
						if($questao6=="")			$errors['questao6']=1;
						if($questao7=="")			$errors['questao7']=1;
						if($questao8=="")			$errors['questao8']=1;
						if($criticas=="")			$errors['criticas']=1;
							$error.="<label style='color:#FF0000;'>Os campos com (*) e/ou vermelho são obrigatório.</label><br>";
					}
					if(count($errors)<1){
						$query="INSERT INTO site_avaliacao(id_treinador, periodo_ini, periodo_term, franquia, area, performance, nova_participacao, criticas, elogios, eficiencia, questao1, questao2, questao3, questao4, questao5, questao6, questao7, questao8, data, status) VALUES 
						('".$id_treinador."','".$periodo_ini."','".$periodo_term."','".$franquia."','".$area."','".$performance."','".$nova_participacao."','".$criticas."','".$elogios."','".$eficiencia."','".$questao1."','".$questao2."','".$questao3."','".$questao4."','".$questao5."','".$questao6."','".$questao7."','".$questao8."',NOW(),'Pendente')";
						$result = $objQuery->SQLQuery($query);
						$id = $objQuery->ID;
						$done=1;
					}
			}
			?>
			<?
			if($done!=1){
			?>
			<?
			if($errors){
				echo '<fieldset><legend><strong>Ocorreram os seguintes erros:</strong></legend>'.$error.'</fieldset>';
			}
			?>
			<form name="form_avaliacao_add" action="" class="form_certidao" method="post" enctype="multipart/form-data">
					<table width="100%" border="0" cellspacing="1" cellpadding="3">
					<tr>
						<td colspan="5" align="left" valign="middle" height="25">
						<label style="margin-left:0px;" class="texto3">Instrutor(a): </label>
						<select name="id_treinador" tabindex="3" title="Selecione o Treinador">
						<?
						$sql = $objQuery->SQLQuery("SELECT t.id_treinador, t.treinador, t.status FROM site_treinadores as t WHERE t.status='Ativo' ORDER BY t.id_treinador DESC");
						while($res = mysql_fetch_array($sql)){
							echo '<option value="'.$res['id_treinador'].'"';
							if($id_treinador==$res['id_treinador']) echo 'selected="selected"'; 
							echo '>'.$res['treinador'].'</option>';
						}
						?>
						</select>
						<label style="margin-left:0px;" class="texto3">Módulo: </label>
						<select name="area" title="Selecione o Treinador">
						<?
						$sql = $objQuery->SQLQuery("SELECT * FROM site_treinadores as t WHERE t.status='Ativo' ORDER BY t.area ASC");
						while($res = mysql_fetch_array($sql)){
							echo '<option value="'.$res['area'].'"';
							if($area==$res['area']) echo 'selected="selected"'; 
							echo '>'.$res['area'].'</option>';
						}
						?>
						</select>
						</td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao1" type="radio" value="10" <? if($questao1=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao1'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao1" type="radio" value="7.5" <? if($questao1=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao1'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao1" type="radio" value="5" <? if($questao1=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao1'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao1" type="radio" value="2.5" <? if($questao1=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao1'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">O Treinamento foi eficiente? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao2" type="radio" value="10" <? if($questao2=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao2'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao2" type="radio" value="7.5" <? if($questao2=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao2'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao2" type="radio" value="5" <? if($questao2=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao2'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao2" type="radio" value="2.5" <? if($questao2=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao2'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">Parte teórica foi condizente com a parte prática? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao3" type="radio" value="10" <? if($questao3=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao3'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao3" type="radio" value="7.5" <? if($questao3=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao3'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao3" type="radio" value="5" <? if($questao3=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao3'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao3" type="radio" value="2.5" <? if($questao3=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao3'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">Parte prática foi suficiente para seu aprendizado? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao4" type="radio" value="10" <? if($questao4=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao4'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao4" type="radio" value="7.5" <? if($questao4=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao4'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao4" type="radio" value="5" <? if($questao4=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao4'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao4" type="radio" value="2.5" <? if($questao4=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao4'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">O conteúdo foi suficiente para seu aprendizado? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao5" type="radio" value="10" <? if($questao5=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao5'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao5" type="radio" value="7.5" <? if($questao5=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao5'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao5" type="radio" value="5" <? if($questao5=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao5'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao5" type="radio" value="2.5" <? if($questao5=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao5'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">Carga Horária foi adequada? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao6" type="radio" value="10" <? if($questao6=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao6'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao6" type="radio" value="7.5" <? if($questao6=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao6'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao6" type="radio" value="5" <? if($questao6=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao6'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao6" type="radio" value="2.5" <? if($questao6=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao6'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">O instrutor soube tirar as dúvidas com clareza? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao7" type="radio" value="10" <? if($questao7=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao7'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao7" type="radio" value="7.5" <? if($questao7=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao7'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao7" type="radio" value="5" <? if($questao7=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao7'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao7" type="radio" value="2.5" <? if($questao7=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao7'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">Como foi sua participação no treinamento? *</label></td>
					</tr>
					<tr>
					<td width="2%" align="center" valign="middle" bgcolor="#0099CC"><input name="questao8" type="radio" value="10" <? if($questao8=='10') echo 'checked'; ?> class="form_estilo<?=($errors['questao8'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FF6666"><input name="questao8" type="radio" value="7.5" <? if($questao8=='7.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao8'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#FFCC00"><input name="questao8" type="radio" value="5" <? if($questao8=='5') echo 'checked'; ?> class="form_estilo<?=($errors['questao8'])?'_erro':''; ?>"/></td>
					<td width="2%" align="center" valign="middle" bgcolor="#CC3300"><input name="questao8" type="radio" value="2.5" <? if($questao8=='2.5') echo 'checked'; ?> class="form_estilo<?=($errors['questao8'])?'_erro':''; ?>"/></td>
					<td width="89%" align="left" valign="middle"><label style="margin-left:2px;">Sala de treinamento estava adequada para o aprendizado? *</label></td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<strong>Quais suas atitudes para melhorar sua performance profissional?</strong>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<textarea name="performance" style="width:99%;height:50px;" class="form_estilo<?=($errors['performance'])?'_erro':''; ?>"/><?= $performance ?></textarea>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<strong>Se você participasse novamente deste treinamento, o que faria de diferente?</strong>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<textarea name="nova_participacao" style="width:99%;height:50px;" class="form_estilo<?=($errors['nova_participacao'])?'_erro':''; ?>"/><?= $nova_participacao ?></textarea>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<strong>Críticas e pontos a melhorar em nosso treinamento:</strong>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<textarea name="criticas" style="width:99%;height:50px;" class="form_estilo<?=($errors['criticas'])?'_erro':''; ?>"/><?= $criticas ?></textarea>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<strong>Elogios e sugestões:</strong>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<textarea name="elogios" style="width:99%;height:50px;" class="form_estilo<?=($errors['elogios'])?'_erro':''; ?>"/><?= $elogios ?></textarea>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<strong>Pensando em eficiência, o que poderia ser melhorado para o próximo treinamento?</strong>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
						<textarea name="eficiencia" style="width:99%;height:50px;" class="form_estilo<?=($errors['eficiencia'])?'_erro':''; ?>"/><?= $eficiencia ?></textarea>
					</td>
					</tr>
					<tr>
					<td colspan="6" align="left" valign="middle">
					<input name="submit2" type="submit" value="Gravar"/>
					</td>
					</tr>
					</table>
			</form>
			<?
			}
			?>
			<?
			if($errors){
				echo '<fieldset><legend><strong>Ocorreram os seguintes erros:</strong></legend>'.$error.'</fieldset>';
			}
			?>
			<?
			if ($done){
				echo '<div id="resposta_sucesso6">
						<p align="center"><br /><br /><br />A avaliação do treinador(a) foi enviada com sucesso!</p>
					</div>';
				echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=questoes.php">';
			}
			?>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<img src="images/questoes.png" border="0" alt="imagem_avaliacao">
			<img src="images/imagem_avaliacao.png" border="0" alt="imagem_avaliacao">
		</div>
		<!-- end #sidebar -->
		<div style="clear:both; margin:0;"></div>
	</div>
	<!-- end #page -->


<? require('includes/rodape.php'); ?>