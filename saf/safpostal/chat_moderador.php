<?
require "../includes/topo.php";
$permissao = verifica_permissao('CHAT',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>

<span id="clock1" style="display:none"></span><br/>

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
    <td align="left" valign="top"><table width="768" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png"><table width="768" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" height="20" align="left" valign="middle"><strong>Chat</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div id="conteudo_chat_sessao">
<div id="titulo_chat_sessao">
    <strong>SEJA BEM VINDO AO ATENDIMENTO ON-LINE</strong>
    </div>
    <div id="lista_espera">
    <a href="?atender=1" title="Clique aqui"><strong>Atender próximo da lista</strong></a>
    </div>
		<script>
			chat_proximo('lista_espera');
		</script>
<?
pt_register('GET','atender');

if ($atender){
	$sql = $objQuery->SQLQuery("SELECT cse.id_sessao FROM saf_chat_sessao as cse WHERE cse.status_espera='Aguardando' and cse.id_departamento IN (".$safpostal_departamento_saf."0) order by cse.data limit 1");
	$res = mysql_fetch_array($sql);
	$id_sessao = $res['id_sessao'];
	$done=1;
	$sql = $objQuery->SQLQuery("update saf_chat_sessao set status_espera='Atendido', id_moderador='".$safpostal_id_usuario."', data_i=NOW() where id_sessao='".$id_sessao."'");
	$_SESSION['safpostal_id_sessao'] = $id_sessao;
}
?>
        <?
        if($done==1){
		
		?>
        
        <div id="form_chat_login_sessao">
        <form name="form_chat_moderador" action="" method="post" enctype="multipart/form-data">
<table width="200" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">
		<div id="fundo_chat_sessao">
	   		<div id="dados" style="width:457px; height:180px; overflow:scroll"></div>
		</div> 
    </td>
  </tr>
  <tr>
  <td><div style="margin-left:3px; margin-top:2px; margin-bottom:2px;"><strong>Digite o assunto e clique em Enviar</strong></div></td>
  </tr>
  <tr>
    <td align="right">
      <textarea name="assunto" id="assunto" style="width:403px; height:45px;"></textarea>
    </td>
    <td align="right">
		<input type="button" value="Enviar" border="0" size="18" onclick="enviaChat(document.getElementById('assunto').value,'retorno','form_chat_moderador'); document.getElementById('assunto').value=''" id="enviar">
		<script language="javascript">
			enviaChat(document.getElementById('assunto').value,'retorno','form_chat_moderador');
		</script>
	</td>
  </tr>  
   </table>
   <div id="status_moderador">
		<table border="0" cellpadding="0" cellspacing="0" width="447">
		<tr>
        <td  align="left" valign="middle">Online</td>
        <td  align="right" valign="middle">Fechar</td>
        </tr>
        </table>
        </div>
    	</form>
        </div>
        <?
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
   </td>
  </tr>
</table>
<?
require "../includes/rodape.php";
?>