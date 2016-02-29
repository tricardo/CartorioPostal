<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Suporte ao Usuário';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','nome');
pt_register('POST','email');
pt_register('POST','assunto');
pt_register('POST','mensagem');

if($submit1){
	$errors=array();
		if($nome=="" || $email=="" || $assunto=="" || $mensagem==""){
			if($nome=="")		$errors['nome']=1;
			if($email=="")		$errors['email']=1;
			if($assunto=="")	$errors['assunto']=1;
			if($mensagem=="")	$errors['mensagem']=1;
				$error.="<span style='color:#FF0000;'>O campos vermelho obrigatórios.</span><br />";
		}
		$valida = validaEMAIL($email);
		if($valida=='false'){
			$errors['email']=1;
			$error.="<span style='color:#FF0000;'>E-mail Inválido, digite corretamente.</span><br />";
		}
		if(count($errors)<1){
			$query="INSERT INTO cp_suporte (nome, email, assunto, mensagem, data, st_id) values ('".$nome."','".$email."','".$assunto."','".$mensagem."',NOW(),'2')";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;
			$done=1;
				set_time_limit(0);
				require("../includes/maladireta/config.inc.php");
				error_reporting(1);
				require("../includes/maladireta/class.Email.php");
				$Sender = "Admin Center - Softfox <suporte@softfox.com.br>";
				$Recipiant = $email;
				$Cc = '';
				$Bcc = '';
				$Subject = 'Central de Suporte - Softfox';
				$html = 'Prezado(a) '.$controle_usuario.',<br /><br />
				Agradecemos pelo contato, em breve retornaremos o seu contato.<br /><br />
				Att,<br />
				Equipe de Suporte - Softfox';
				$CustomHeaders= '';
				$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
				$message->Cc = $Cc;
				$message->Bcc = $Bcc;
				$message->SetHtmlContent($html);
				$pathToServerFile ="attachments/$at[1]/$at[2]";
				$serverFileMimeType = 'multipart/gased';
				$message->Send();
				$url_site = 'http://www.webvans.com.br/';
				$msg .= "------------------------------------<br />";
				$msg .= "<strong>Site:</strong>$url_site<br />";
				$msg .= "------------------------------------<br />";
				$msg .= "<strong>Cliente:</strong> $nome<br />";
				$msg .= "<strong>Email:</strong> $email<br />";
				$msg .= "<strong>Assunto:</strong> $assunto<br />";
				$msg .= "<strong>Mensagem:</strong><br /> $mensagem";
				$formato = "\nContent-type: text/html\n charset=iso-8859-1\n";
				$destinatario = "suporte@softfox.com.br";
				$titulo = "Suporte: Softfox";
				mail("$destinatario","$titulo","$msg","from: ".$email.$formato);
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
							<img src="../images/paginas/icon-suporte.png" alt="icon-suporte" />
						</td>
						<td width="90%" align="left" valign="middle">
							<span style="margin-left:5px;"><?= $title_pg?></span>
						</td>
					</tr>
				</table>
				<!--/tabela:fim/-->
			</div>
		</div>
		<div class="pages">
			<!--/tabela:adicionar-usuário/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						SUPORTE AO USUÁRIO
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
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<?
				if($done!=1){
				?>
				<!--/fomulário:suporte/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="nome" accesskey="1">Nome</label></td>
							<td><label for="email" accesskey="2">Email</label></td>
						</tr>
						<tr>
							<td><input name="nome" type="text" id="nome" value="<?= $nome?>" <?=($errors['nome'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
							<td><input name="email" type="text" id="email" value="<?= $email?>" <?=($errors['email'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="assunto" accesskey="3">Assunto</label></td>
						</tr>
						<tr>
							<td colspan="2"><input name="assunto" type="text" id="assunto" value="<?= $assunto?>" <?=($errors['assunto'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td colspan="2"><label for="mensagem" accesskey="3">Mensagem</label></td>
						</tr>
						<td colspan="2">
							<textarea id="campo1" name="mensagem" onkeyup="mostrarResultado(this.value,800,'spcontando1');contarCaracteres(this.value,800,'sprestante1','campo1')" ><?= $mensagem ?></textarea><br>
							<span id="spcontando1">Ainda não temos nada digitado..</span><br />
							<span id="sprestante1"></span><br><br>
						</td>
						<tr>
							<td colspan="6"><input name="submit1" type="submit" value="Enviar" title="Clique aqui para enviar o cadastro" tabindex="5" /></td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</form>
				<!--/fomulário:fim/-->
				<?
				}
				?>
				<?
				if($done){
					echo '<div id="load"><img src="../images/paginas/load.gif" alt="load" width="28" /></div>
						<img src="../images/paginas/resposta-confirmacao.png" alt="resposta-confirmacao" />';
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=index.php" />';
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