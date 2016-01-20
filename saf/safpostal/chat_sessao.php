<?
require "../includes/topo.php";

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
		<input type="button" value="Enviar" border="0" size="18" onclick="enviaChat(document.getElementById('assunto','retorno','form_chat_moderador').value); document.getElementById('assunto').value=''" id="enviar">
		<script language="javascript">
			enviaChat(document.getElementById('assunto').value,'retorno','form_chat_moderador');
		</script>

	</td>
  </tr>  
   </table>
   <div id="status_moderador">
		<table border="0" cellpadding="0" cellspacing="0" width="447">
		<tr>
        <td  align="left" valign="middle"></td>
        <td  align="right" valign="middle">Fechar</td>
        </tr>
        </table>
        </div>
    	</form>
        </div>
       
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