<?
$id_pagina=5;
$pg = 'paginas_hotsite';
require('../includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-imagens-paginas">
			<img src="<?= URL_IMAGES;?>hotsite/fale-conosco.png" alt="Fale conosco" title="Fale conosco" />
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-03">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
								<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">FALE CONOSCO:.</h1>
								<div class="faixa-h"></div>
							</td>
						</tr>
					</table>
					<?
					pt_register('POST','submit1');
					if($submit1){
						$errors=array();
						pt_register('POST','id_empresa');
						pt_register('POST','nome');
						pt_register('POST','email');
						pt_register('POST','assunto');
						if($nome=="" || $email=="" || $assunto==""){
							if($nome=="")		$errors['nome']=1;
							if($email=="")		$errors['email']=1;
							if($assunto=="")	$errors['assunto']=1;
							$error.="<span style='font: 12px Arial; color:#000000;'>Nome / E-mail / Assunto / </span>";
						}
						$valida = validaEMAIL($email);
						if($valida=='false'){
							$errors['email']=1;
							$error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
						}
						if(count($errors)<1){
							$query="INSERT INTO cp_fale_conosco(";
							$query .="id_empresa, nome, email, assunto, data)";
							$query .="VALUES";
							$query .="('".$fr->id_empresa."','".$nome."','".$email."','".$assunto."',NOW())";
							$result = $objQuery->SQLQuery($query);
							$id = $objQuery->ID;
							$done=1;
							$msg .= "------------------------------------------------------------------------<br />";
							$msg .= "<strong>Mensagem enviada pelo Fale Conosco:.</strong><br />";
							$msg .= "------------------------------------------------------------------------<br />";
							$msg .= "<strong>Nome completo:</strong> $nome<br />";
							$msg .= "<strong>E-mail:</strong> $email<br />";
							$msg .= "<strong>Assunto:</strong><br /> $assunto<br />";
							$formato = "\nContent-type: text/html\n charset=iso-8859-1\n";
							$destinatario = str_replace('diretoria','contato',$fr->email);
							#$destinatario = "antonio.alves@softfox.com.br";
							$titulo = "Fale Conosco: ".$fr->fantasia."";
							mail("$destinatario","$titulo","$msg","from: ".$email.$formato);
						}
					}
					if($done!=1){
					?>
					<form name="frm" action="" method="post" enctype="multipart/form-data">
						<table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
							<tr>
								<td align="left" valign="middle" colspan="4">
									<?
									if($error!=''){
											echo '<fieldset>
												  <legend><strong style="font-size: 12px; color: #FF0000;">Ocorreram os seguintes erros:</strong></legend>';
											if ($errors){
												echo $error;
											}
											echo '</fieldset>';
									}
									?>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle">
									 <label for="nome" accesskey="1">Nome:</label>
								</td>
								<td align="left" valign="middle">
									 <label for="email" accesskey="2">E-mail:</label>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle">
									 <input name="nome" type="text" id="nome" value="<?= $nome;?>" <?=($errors['nome'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
								</td>
								<td align="left" valign="middle">
									 <input name="email" type="text" id="email" value="<?= $email;?>" <?=($errors['email'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" colspan="2">
									 <label for="campo1" accesskey="3">Assunto:</label>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" colspan="2">
									<textarea name="assunto" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['assunto'])?'style="border: 1px solid #FF0000; width: 100%; height: 80px;"':''; ?> ><?= $assunto;?></textarea>
									<span id="spcontando1" style="font-size: 12px;">Ainda não temos nada digitado..</span><br />
									<span id="sprestante1" style="font-size: 12px;"></span>
								</td>
							</tr>
							<tr>
								<td align="right" valign="middle" colspan="4">
									<input name="submit1" type="submit" value=" " title="Clique aqui para fazer o cadastro" class="bt_enviar" />
								</td>
							</tr>
						</table>
					</form>
					<?
					}
					if($done){
						echo '<img src="'.URL_IMAGES.'hotsite/mensagem-contato.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />';
						echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE_H.''.$fr->id_empresa.'/'.$fr->link_estado.'/'.$fr->link_cidade.'">';
					}
					?>
				<table width="100%" border="0" align="center" cellspacing="10" cellpadding="8" bgcolor="#F0F0F0" style="margin: 20px 0 0 0;">
					<tr>
						<td align="left" valign="top"><strong style="font-size: 15px; color: #202A72;">CENTRAL DE ATENDIMENTO</strong></td>
					</tr>
					<tr>
						<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">
							<?
							if($fr->tel)
								echo '<strong style="font-size: 15px; color: #333333;">'.$fr->tel.'</strong>' .' / '. '<strong style="font-size: 15px; color: #333333;">'.$fr->cel.'</strong>';
							else
							   echo '<strong style="font-size: 15px; color: #333333;">(11) 3103.0800</strong>';
							?>
						</td>
					</tr>
					<tr>
						<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">
							<?
							if($fr->tel)
								echo '<a href="mailto:'.str_replace('diretoria','contato',$fr->email).'" title="Clique para enviar um e-mail para a Cartório Postal '.$fr->fantasia.'" class="link_contato">'.str_replace('diretoria','contato',$fr->email).'</a>';
							else
								echo '<a href="mailto:contato@cartoriopostal.com.br" title="Clique para enviar um e-mail para a Cartório Postal" class="link_contato">contato@cartoriopostal.com.br</a>';
							?>
						</td>
					</tr>
					<tr>
						<td height="30" align="left" valign="middle" bgcolor="#FFFFFF" style="font: 15px Arial;">
							<span style="font: bold 15px Arial; color: #333333;">Endereço:</span> <?= $fr->endereco ?>, <?= $fr->numero?><br />
							<span style="font: bold 15px Arial; color: #333333;">Complemento:</span> <?= $fr->complemento?><br />
							<span style="font: bold 15px Arial; color: #333333;">Bairro:</span> <?= $fr->bairro?><br />
							<span style="font: bold 15px Arial; color: #333333;">Cidade:</span> <?= $fr->cidade?><br />
							<span style="font: bold 15px Arial; color: #333333;">Estado:</span> <?= $fr->estado?><br />
						</td>
					</tr>
				</table>
				</div>
				<div class="nav-04">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF">
								<span style="font-weight: bold; font-size: 15px; color: #202A72; text-transform: uppercase;">PRINCIPAIS SERVIÇOS:.</span>
								<div class="faixa-h"></div>
								<ul class="marcador-servicos">
									<?= PRINCIPAIS_SERVICOS;?>
								</ul>
								<ul class="marcador-servicos">
									<?= OFERECEMOS_TAMBEM;?>
								</ul>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-hotsite.php'); ?>