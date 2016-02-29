<?
$url_rede = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$logar = 'Sim';
$pg = 'administrador';
$title_pg = 'Senha: Usuário';
require_once('../includes/header.php');
pt_register('GET','id');

$permissao = verifica_permissao('enviar_senha',$controle_permissao_p,$controle_permissao_s);
if($permissao == 'FALSE' or ($controle_id_usuario!='1' and $id=='1')){ 
	require_once('resposta-permissao.php');
	exit;
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
			<div class="prev">
				<a href="#" title="Clique aqui para voltar" class="prev"><img src="../images/paginas/anterior.png" alt="anterior" /></a>
			</div>
				<? require_once('menu-list.php'); ?>
			<div class="next">
				<a href="#" title="Clique aqui para avançar" class="next"><img src="../images/paginas/proximo.png" alt="proximo" /></a>
			</div>
		</div>
		<div class="pages">
			<!--/tabela:filtro-pesquisa/-->
			<table width="1000" class="table_info">
				<tr>
					<th align="center" valign="middle" colspan="6">
						ALTERAÇÃO DA NOVA SENHA PARA DO USUÁRIO
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
					</table>
					<!--/tabela:fim/-->
				</td>
				<!--/divisão/-->
				<td align="left" valign="middle" class="td_info" width="75%">
				<?
				$sql = $objQuery->SQLQuery("SELECT * FROM cp_user WHERE id_usuario ='$id'");
				$row = mysql_fetch_array($sql);
				$usuario	= $row['usuario'];
				$email		= $row['email'];
				$senha = '';
				$tamanho = 6;$caracteres = "abcdefghijkmnpqrstuvwxyz23456789"; srand((double)microtime()*1000000);
				for($i=0; $i<$tamanho; $i++){
					$senha .= $caracteres[rand()%strlen($caracteres)];
				}
				$senha_new = $email.$senha;
				$senha_new = md5($senha_new);
				$sql2 =  $objQuery->SQLQuery("UPDATE cp_user SET senha='$senha_new' WHERE id_usuario ='$id'");
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
				?>
				A senha do usuário <strong><? echo $usuario; ?></strong> foi alterada com sucesso!<br /><br />
				Esta é a nova senha: <strong><? echo $senha; ?></strong>
				<meta HTTP-EQUIV="refresh" CONTENT="5; URL=usuario-list.php" />
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