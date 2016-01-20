<form name="form_interesse" action="expansao_interessados_edit.php?id=<?=$id?>#aba2" method="post">
	<? if($errors > 0){ ?>
	<div style="color:#FF0000; border:solid 1px #0071B6; width:800px; margin:10px 0;">
		<p><?= $error ?></p>
	</div><? }?>
	<div id="dados_administrativos" class="div_titulo" style="width:800px;">&nbsp;- Aprovar Cadastro
	<img src="../images/null.gif" onload="javascript:document.getElementById('frm').src='busca_cep.php';" /></div>
	<div class="div_form" style="width:800px;">
		<label style="width:750px;">&nbsp;</label>
		<label style="margin-left:10px;"><strong>UF de Interesse:</strong></label>
		<label style="margin-left:30px;"><strong>Cidade de Interesse:</strong></label>
		<label style="margin-left:10px;"><strong>Faixa de CEP:</strong></label><br />		
		
		<input style="margin-left:10px;" type="text" class="form_estilo" name="estado" id="estado" value="<?=$c->estado_interesse?>" style="width:60px;" />
		<input style="margin-left:17px;" type="text" class="form_estilo" name="cidade" id="cidade" value="<?=$c->cidade_interesse?>" style="width:237px; text-transform:uppercase" />
		<input type="hidden" id="cont_outro_cep" name="cont_outro_cep" value="0" />
		<input  style="margin-left:28px; width:70px;" type="text" maxlength="9" class="form_estilo" value="<?=$cep_i?>" name="cep_i" id="cep_i" /> - <input 
		type="text" maxlength="9" class="form_estilo" value="<?=$cep_f?>" name="cep_f" id="cep_f" style="width:70px;" />
		<input name="submit3" id="submit3" type="submit" value="Alterar" style="width:90px; margin-top:-28px;" />
		<div id="outro_cep"></div>
		<p style="text-transform:none; font-weight:normal; margin-bottom:0; width:800px; float:left">
		<!--<a href="#outro_cep_lk" name="outro_cep_lk" onclick="AddOutroCep();" style="color:#0000CC">&nbsp;Adicionar outro CEP.</a><br />-->
		<span style="color:#FF0000">&nbsp;Obs.:</span> Verifique se os campos estão sendo digitados corretamente. <br />
		&nbsp;O Sistema não fará a inclusão dos CEP's nos seguintes casos:<br />
		&nbsp;- o primeiro campo de CEP é obrigatário e não pode ser vazio;<br />
		&nbsp;- campos de CEP vazio;<br />
		&nbsp;- um dos campos de CEP vazio;<br />
		&nbsp;- caso já exista o CEP cadastrado; e<br />
		&nbsp;- caso o CEP esteja dentro da faixa de um CEP já existente.
		</p>
	</div>
	<div style="width:740px;">
		<iframe id="frm" style="width:490px; height:190px; margin:0;" allowtransparency="1" frameborder="0" scrolling="no"></iframe>
	</div>	
	<div style="width:80px; text-align:right; float:left; margin-top:-80px; padding-left:15px;">
		<a href="#" onclick="javascript:document.getElementById('frm').src='busca_cep.php';"><img src="../images/voltar.png" border="0" /></a>
	</div><br />
	
 </form>