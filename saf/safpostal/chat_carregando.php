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
        <td><div id="conteudo_chat">
<?
	$sql_fila = "SELECT COUNT(cse.id_sessao) FROM saf_chat_sessao as cse WHERE cse.status_espera='Aguardando' and cse.id_departamento=cs.id_departamento and cse.data >= cs.data";
	
	$sql = $objQuery->SQLQuery("SELECT (".$sql_fila.") as fila FROM saf_chat_sessao as cs WHERE cs.status_espera = 'Aguardando' and cs.id_usuario='".$safpostal_id_usuario."'");
	$res = mysql_fetch_array($sql);
	$fila = $res['fila'];
echo '<div id="carregando">
	  <table>
	  <tr>
	  <td align="center" height="30"><img src="../images/paginas/chat/progressbar_3.gif" /><td>
	  </tr>
	  <tr>
	  <td>Por favor! aguarde na fila de espera<br /><br />
	  Você está na fila: '.$fila.'</div>
	  </td>
	  </tr>
	  </table>';
	  
	  if($fila>=1){
		echo "
		<script language=\"javascript\">
			setTimeout(\"location.href='chat_carregando.php'\",10000);
		</script>";
	  } else {
		echo "
		<script language=\"javascript\">
			setTimeout(\"location.href='chat_sessao.php'\",200);
		</script>";
	  }
	  
?><br><br> 
<b>
<a href="chat.php">Sair</a>
</b>
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