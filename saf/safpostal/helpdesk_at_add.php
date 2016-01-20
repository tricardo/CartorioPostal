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
            <td width="345" height="20" align="left" valign="middle"><strong>Help Desk</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?
pt_register('POST','submit1');

if ($submit1){
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b> ";
	
	pt_register('POST','id_departamento');
	pt_register('POST','titulo');
	pt_register('POST','problema');
	
	if($titulo=="" || $problema==""){
		$errors=1;
		$error.="<span style='color:#FF0000'>Os campos com * são obrigatórios.</samp>";
	}
	

	
    if($errors!=1) {	
	$query="INSERT INTO saf_helpdesk (id_usuario, id_departamento, titulo, problema,data) values ('".$safpostal_id_usuario."','".$id_departamento."','".$titulo."','".$problema."',NOW())";
	
	$result = $objQuery->SQLQuery($query);
	$id = $objQuery->ID;
	$done=1;
	}
}
?>
        <?
        if($done!=1){
		
		pt_register('GET','id');
		$sql = $objQuery->SQLQuery("SELECT * FROM saf_helpdesk as h WHERE id_helpdesk='" . $id . "'");
		$res = mysql_fetch_array($sql);
		$titulo			= $res['titulo'];
		$problema	= $res['problema'];
		?>
        
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
        <tr>
          <td height="30" colspan="5" align="center" valign="middle">
          <a href="helpdesk_at_add.php" title="Clique aqui"><strong>Cadastrar chamada</strong></a> |
<a href="helpdesk_at_list.php" title="Clique aqui"><strong>Meus chamados</strong></a>          </td>
        </tr>
        </tr>
        </table>
        <form name="form_helpdesk_at_add" action="" method="post" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
        <tr>
        <td>
        <table width="550" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
        <tr>
        <td height="50" colspan="2" align="center" valign="middle">
        <strong>CADASTRO DE CHAMADAS</strong></td>
        </tr>
        <td colspan="2" align="center" bgcolor="#F8F8F8">Entre aqui com os dados do chamado, o preenchimento de todos os campos &eacute; obrigat&oacute;rio.</td>
        </tr>
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td width="20">Departamentos:</td>
        <td width="500">
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
        </tr>
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td>Título:</td><td><input type="text" value="<?= $titulo ?>" name="titulo" class="textfield" style="width:400px;"/><span style="color:#FF0000"> *</span></td>
        </tr>
        <tr>
        <td valign="top">Pergunta:</td><td><textarea name="problema" id="textarea" style="width:400px; height:100px;"><?= $problema ?></textarea><span style="color:#FF0000"> *</span></td>
        </tr>
        <tr>
        <td height="2px"></td>
        </tr>
        <tr>
        <td></td>
        <td>
        <input name="submit1" type="submit" class="botoes" value="Enviar" />
        </td>
        </tr>
        <tr>
        <td colspan="2" align="center" valign="middle">
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
    	</form>
        
        <?
        }
		?>
        
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
        <td align="center">
        
        <?
		if ($errors) {
		echo '<div class="respotas_erro">'.$error.'</div>';
		}
		?>
        
        <?
		if ($done) {
		echo '<div class="respotas_sucesso">Registro efetuado com sucesso!<br><br>
			  <a href="helpdesk_at_list.php" title="Clique aqui"><span style="font-size:12px">Clique aqui para visualizar o chamados</span></a>
			  </div>';
		 }	  
		?>
        
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