<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Cadastro: Novo Usuário';
require_once('../includes/header.php');
pt_register('POST','submit1');
pt_register('POST','usuario');
pt_register('POST','email');
pt_register('POST','senha');
pt_register('POST','confirmar_senha');

$permissao = verifica_permissao('cadastro_usuarios',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE'){ 
	require_once('resposta-permissao.php');
	exit;
}

if($submit1){
	$errors=array();
		if($usuario=="" || $email=="" || $senha==""){
			if($usuario=="")	$errors['usuario']=1;
			if($email=="")		$errors['email']=1;
			if($senha=="")		$errors['senha']=1;
				$error.="<span style='color:#FF0000;'>Os campos em vermelho são obrigatórios.</span><br />";
		}
		$valida = validaEMAIL($email);
		if($valida=='false'){
			$errors['email']=1;
			$error.="<span style='color:#FF0000;'>E-mail Inválido, digite corretamente.</span><br />";
		}
		if($senha!=$confirmar_senha){
			$errors['confirmar_senha']=1;
			$error.="<span style='color:#FF0000;'>A senha não confere.</span><br />";
		}
		$sql = "SELECT u.email FROM cp_user as u WHERE u.email='$email'";
		$result = $objQuery->SQLQuery($sql);
		$num = mysql_num_rows($result);
		if($num<>'0'){
			$errors = 1; 
			$error .= "<span style='color:#FF0000;'>Esse email já foi cadastrado.</span><br />";
		}
		if(count($errors)<1){
			$senha_new  = $email.$senha;
			$senha_new  = md5($senha_new);
			$query="INSERT INTO cp_user (usuario, email, senha, data, st_id) values ('".$usuario."','".$email."','".$senha_new."',NOW(),'1')";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;
			$done=1;
				set_time_limit(0);
				require("../includes/maladireta/config.inc.php");
				error_reporting(1);
				require("../includes/maladireta/class.Email.php");
				$Sender = "Admin Center - Softfox Brasil <suporte@softfox.com.br>";
				$Recipiant = $email;
				$url_site = 'http://www.webvans.com.br/administrador/';
				$Cc = '';
				$Bcc = '';
				$Subject = 'Senha do Acesso ao Admin Center da Softfox Brasil';
				$html = 'Prezado(a) '.$usuario.',<br /><br />
				As informações abaixo são confidenciais e importantes para você acessar a ferramenta Admin Center.<br /><br />
				Seu login é: '.$email.'<br />
				E sua senha de acesso é: '.$senha.'<br /><br />
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
							<img src="../images/paginas/icon-user.png" alt="icon-user" />
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
				<a href="#" title="Clique aqui para avançar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:adicionar-usuário/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						ADICIONAR UM NOVO USUÁRIO
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
						<tr>
							<?
							$permissao = verifica_permissao('lista_usuario',$controle_permissao_p,$controle_permissao_s);
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
										$permissao = verifica_permissao('lista_usuario',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="usuario-list.php" title="Clique aqui" class="link_lista">Lista: Usuários</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_permissao',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="permissao-list.php" title="Clique aqui" class="link_lista">Lista: Permissão</a>
										<?}?>
									</li>
									<li>
										<?
										$permissao = verifica_permissao('lista_keyword',$controle_permissao_p,$controle_permissao_s);
										if($permissao == 'TRUE'){
										?>
										<a href="meta-tag-list.php" title="Clique aqui" class="link_lista">Lista: Keywords</a>
										<?}?>
									</li>
								</ul>
							</td>
						</tr>
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="center" valign="top" class="td_info" width="75%">
				<?
				if($done!=1){
				?>
				<!--/fomulário:usuario-add/-->
				<form name="form" action="" method="post" enctype="multipart/form-data">
					<!--/tabela:lado-right/-->
					<table width="100%">
						<tr>
							<td><label for="usuario" accesskey="1">Nome do usuário</label></td>
							<td><label for="email" accesskey="2">Email do usuário</label></td>
						</tr>
						<tr>
							<td><input name="usuario" type="text" id="usuario" value="<?= $usuario?>" <?=($errors['usuario'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
							<td><input name="email" type="text" id="email" value="<?= $email?>" <?=($errors['email'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td><label for="senha" accesskey="3">Senha</label></td>
							<td><label for="confirmar_senha" accesskey="4">Confirmar senha</label></td>
						</tr>
						<tr>
							<td><input name="senha" type="password" id="senha" value="<?= $senha?>" <?=($errors['senha'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
							<td><input name="confirmar_senha" type="password" id="confirmar_senha" value="<?= $confirmar_senha?>" <?=($errors['confirmar_senha'])?'style="border:1px solid #FF0000;"':''; ?> /></td>
						</tr>
						<tr>
							<td colspan="6"><input name="submit1" type="submit" value="Cadastrar" title="Clique aqui para fazer o cadastro" tabindex="5" /></td>
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
					echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=usuario-add.php" />';
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