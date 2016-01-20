<?
require "../includes/topo.php";
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
		<td width="345" height="20" align="left" valign="middle"><strong>Mídia Social</strong></td>
		<td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td align="left" valign="middle">
		<div class="fundo_midia_social">
			<div class="form_midia_social">
				<?
				pt_register('POST','submit1');
				if ($submit1){
					$errors=array();

					pt_register('POST','safpostal_fantasia');
					pt_register('POST','assunto');

					if($assunto==""){
						if($assunto=="")		$errors['assunto']=1;
						$error.="<span style='color:#FFF'>Os campos com * são obrigatórios. | </span>";
					}

					if(count($errors)<1){
						$f->safpostal_fantasia = $safpostal_fantasia;
						$f->assunto = $assunto;
						$done=1;
						echo '<div style="font-size:18px;color:#FFF"><center><br><br><b>Seu contato foi enviado com sucesso.</b><br><br> Em breve retornaremos seu contato!</center></div>';
						$msg .= "<b>Franquia:</b> ".$safpostal_fantasia."<br>";
						$msg .= "<b>Assunto:</b> ".$assunto."<br>";

						$formato = "\nContent-type: text/html\n";
						$destinatario = "imprensa@cartoriopostal.com.br";
						#$destinatario = "antonio.alves@canaldosprofissionais.com.br";

						mail($destinatario,"Mídia Social: Saf Postal",$msg,"from: ".$formato);
					}
				}
				if($done!=1){
					if ($errors){
						echo '<div class="form_erro">'.$error.'</ul></div>';
					}
					?>
				<form name="fale_conosco" action="" method="post" enctype="multipart/form-data">
					<table border="0" width="100%" cellpadding="1" cellspacing="3">
						<tr>
							<td colspan="2">
								<strong style="color:#FFF;">FRANQUIA DE:</strong>
								<input type="text" name="safpostal_fantasia" readonly="true" value="<?= $safpostal_fantasia ?>" style="width:75%" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<strong style="color:#FFF;">NOS CONTE MAIS SOBRE SUA NOTÍCIA:</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<textarea name="assunto" style="width:98%; height:80px;" <?= $assunto ?> <?=($errors['assunto'])?'style="border:1px solid #FF0000;"':''; ?>></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<strong style="font-size:10px;color:#FFF;">
									CASO TENHA FOTOS OU VÍDEOS, VOCÊ PODE COLOCAR
									NA MENSAGEM, ASSIM ENVIAMOS E-MAIL PARA VOCÊ!
								</strong>
							</td>
							<td align="center" valign="middle">
								<input type="submit" name="submit1" class="submit" value=" ENVIAR " />
							</td>
						</tr>
					</table>
				</form>
				<?
				}
				?>
				<?
				if($done){
					echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL=index.php">';
				}
				?>
			</div>
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