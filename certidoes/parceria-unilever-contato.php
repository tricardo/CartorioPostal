<?
$id_meta=127;
$pg = 'paginas';
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require_once(URL_SITE_INCLUDE.'header-parceria-u.php');
?>
<div id="container-parceria">
	<div class="box-01-parceria">
		<div class="nav-parceria">
			<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">FALE CONOSCO</h1>
			<div class="faixa-h-parceria"></div>
		</div>
	</div>
	<div class="box-01-parceria">
		<div class="nav-parceria">
			<div id="texto-parceria">
				<?
				pt_register('POST','submit1');
				if($submit1){
					$errors=array();
					pt_register('POST','nome');
					pt_register('POST','email');
					pt_register('POST','assunto');
					if($nome=="" || $email=="" || $assunto==""){
						if($nome=="")       $errors['nome']=1;
						if($email=="")      $errors['email']=1;
						if($assunto=="")    $errors['assunto']=1;
						$error.="<span style='font: 12px Arial; color:#000000;'>Nome / E-mail / Assunto / </span>";
					}
					$valida = validaEMAIL($email);
					if($valida=='false'){
						$errors['email']=1;
						$error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
					}
					if(count($errors)<1){
						$query="INSERT INTO cp_fale_conosco(";
						$query .="nome, email, assunto, data)";
						$query .="VALUES";
						$query .="('".$nome."','".$email."','".$assunto."',NOW())";
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
						$destinatario = "cartoriopostal@cartoriopostal.com.br";
						#$destinatario = "antonio.alves@softfox.com.br";
						$titulo = "Fale Conosco: Cartório Postal";
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
										echo '
											<div id="apDiv-contato">
												<table width="100%" border="0" height="200" cellspacing="0" cellpadding="0">
												<tr>
													<td colspan="3" align="center" valign="middle" height="50">
														<strong style="font-size:15px;">OCORRERAM OS SEGUINTES ERROS</strong>
													</td>
												</tr>
												<tr>
													<td width="30%" align="center" valign="top">

													</td>
													<td width="70%" colspan="2" align="left" valign="top">
														'.$error.'
													</td>
												</tr>
												<tr>
													<td colspan="3" align="center" valign="top">
													   <a href="#" onclick="fecharContato()"><img src="'.URL_IMAGES.'pages/image-bt-fechar.png" alt="Clique aqui para fechar este informativo." title="Clique aqui para fechar este informativo." /></a>
													</td>
												</tr>
												</table>
											</div>';
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
					echo '<img src="'.URL_IMAGES.'pages/mensagem-enviada-com-sucesso.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />';
					echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'/parceria-unilever/">';
				}
				?>
				<br /><br /><h2 style="font-weight: bold; color: #202A72; text-transform: uppercase;">ENTRE EM CONTATO CONOSCO</h2>
				<div class="faixa-h-parceria"></div>
				<strong>Central de Atendimento</strong>
				<ul>
					<li class="list-ordenada-a">Telefone: <strong style="font: bold 15px Arial; color: #202A72;">55 (11) 3103.0800</strong></li>
					<li class="list-ordenada-a">E-mail: <a href="mailto:contato@cartoriopostal.com.br" class="link_normal">contato@cartoriopostal.com.br</a></li>
				</ul>
			</div>
			<div class="nav-08-parceria">
				<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
					<tr>
						<td align="right" valign="middle" bgcolor="#FFFFFF">
							<a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" class="link_voltar">VOLTAR PARA PÁGINA ANTERIOR</a>
						</td>
					</tr>
					<tr>
						<td align="right" valign="middle" bgcolor="#FFFFFF">
							<a href="<?= URL_SITE;?>parceria-unilever-certidao/" title="Solicite sua certidão"><img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao.png" alt="solicite sua certidao" title="Solicite sua certidão" width="280" /></a>
						</td>
					</tr>
					<tr>
						<td align="right" valign="middle" bgcolor="#FFFFFF">
							<a href="<?= URL_SITE;?>parceria-unilever-quem-somos/" title="Saiba mais sobre a Cartório Postal"><img src="<?= URL_IMAGES;?>pages/saiba-mais-sobre-a-cartorio-postal.png" alt="saiba mais sobre a cartorio postal" title="Saiba mais sobre a Cartório Postal" width="280" /></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-u.php'); ?>