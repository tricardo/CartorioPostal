<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$title_pg = 'Alterar senha: Usuário';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','senha');
pt_register('POST','confirmar_senha');

if($submit1){
	$errors=array();
		if($senha=="" || $confirmar_senha==""){
			if($senha=="")				$errors['senha']=1;
			if($confirmar_senha=="")	$errors['confirmar_senha']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		if($senha!=$confirmar_senha){
			$errors['confirmar_senha']=1;
			$error.="<span style='color:#FF0000;'>A senha não confere.</span><br />";
		}
		if(count($errors)<1){
			$senha_new  = $controle_login.$senha;
			$senha_new  = md5($senha_new);
			$query="UPDATE cp_user SET senha='$senha_new' WHERE id_usuario='$controle_id_usuario'";
			$result = $objQuery->SQLQuery($query);
			$_SESSION['controle_senha'] = $senha;
			$done=1;
			set_time_limit(0);
			require("../includes/maladireta/config.inc.php");
			error_reporting(1);
			require("../includes/maladireta/class.Email.php");
			$Sender = "Admin Center - Softfox Brasil <suporte@softfox.com.br>";
			$Recipiant = $controle_email;
			$url_site = 'http://www.webvans.com.br/administrador/';
			$Cc = '';
			$Bcc = ''; 
			$Subject = 'Alteração da Senha do Acesso ao Admin Center';
			$html = 'Prezado(a) '.$controle_usuario.',<br /><br />
			As informações abaixo são confidenciais e importantes para você acessar a ferramenta Admin Center.<br /><br />
			O seu login continua sendo: '.$controle_email.'<br />
			A sua senha foi alterada para: '.$controle_senha.'<br /><br />
			Para usar a ferramenta Admin Center da Softfox Brasil, acesse: '.$url_site.' <br /><br />
			Caso não está conseguindo acessar, envie um e-mail para suporte@softfox.com.br<br /><br />
			Att,<br />
			Equipe Softfox Brasil';
			$CustomHeaders= '';
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->Cc = $Cc; 
			$message->Bcc = $Bcc; 
			$message->SetHtmlContent($html);
			$pathToServerFile ="attachments/$at[1]/$at[2]";
			$serverFileMimeType = 'multipart/gased';
			$message->Send();
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
							<img src="../images/paginas/icon-senha.png" alt="icon-senha" />
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
						ALTERAR SENHA DO USUÁRIO: <span style="text-transform:uppercase;"><?= $controle_usuario ?></span>
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
				<!--/fomulário:alterar-senha/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="senha" accesskey="3">Senha</label></td>
							<td><label for="confirmar_senha" accesskey="4">Confirmar senha</label></td>
						</tr>
						<tr>
							<td><input name="senha" type="password" id="senha" value="<?= $senha?>" <?=($errors['senha'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
							<td><input name="confirmar_senha" type="password" id="confirmar_senha" value="<?= $confirmar_senha?>" <?=($errors['confirmar_senha'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td colspan="6"><input name="submit1" type="submit" value="Atualizar" title="Clique aqui para atualizar o cadastro" tabindex="3" /></td>
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
						<img src="../images/paginas/resposta-atualizacao.png" alt="resposta-atualizacao" />';
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=sair.php" />';
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