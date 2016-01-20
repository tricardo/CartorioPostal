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
<div id="titulo_chat">
    <strong>SEJA BEM VINDO AO ATENDIMENTO ON-LINE</strong><br /><br />
	Por favor escolha o departamento que deseja contactar.
    </div>
		
<?
pt_register('POST','submit1');

	if($submit1<>""){

	pt_register('POST','id_departamento');
	pt_register('POST','assunto');
	
    if($errors!=1) {	
	$query="INSERT INTO saf_chat_sessao (id_departamento, id_usuario, assunto, status_espera,  data) values ('".$id_departamento."', '".$safpostal_id_usuario."', '".$assunto."', 'Aguardando',NOW())";
	$result = $objQuery->SQLQuery($query);
	$id = $objQuery->ID;
	$query="INSERT INTO saf_chat (id_usuario, assunto, chat_data, id_sessao) values ('".$safpostal_id_usuario."', '".$assunto."', NOW(),'".$id."')";
	$result = $objQuery->SQLQuery($query);
	$_SESSION['safpostal_id_sessao'] = $id;

	$done=1;
		
	echo '<meta HTTP-EQUIV="refresh" CONTENT="1; URL=chat_carregando.php">';
	exit;
	}
}
?>	
		<div id="form_chat_login">
        <form name="form_chat_login" action="" method="post" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="3" cellspacing="0">
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td width="10">Departamentos:</td>
        <td>
        <select name="id_departamento">
        <?
        $sql = $objQuery->SQLQuery("SELECT * FROM saf_departamento_permissao as D WHERE id_modulo = '2' ORDER BY departamento ");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['id_departamento_permissao'].'" ';
			
				if($id_departamento==$res['id_departamento_permissao']) echo ' selected="selected"'; 
				echo '>'.$res['departamento'].'</option>';			
			}
		?>
          </select>
        </td>
        <td></td>
        </tr>
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td valign="top">Assunto:</td>
        <td valign="top"><textarea name="assunto" <?= $assunto ?> id="textarea" style="width:300px; height:50px;"></textarea></td><td><input name="submit1" type="submit" class="botoes" value="Iniciar" style="width:50px; height:57px;"/></td>
        </tr>
        </table>
    	</form>
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