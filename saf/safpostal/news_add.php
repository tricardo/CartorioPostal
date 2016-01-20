<?
require "../includes/topo.php";
require( '../js/fckeditor/fckeditor.php' );
pt_register('GET','id_news');
$permissao = verifica_permissao('NEWS',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
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
            <td width="345" height="20" align="left" valign="middle"><strong>Newsletter</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo">
        <?
pt_register('POST','submit1');

if ($submit1){
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b> ";

	pt_register('POST','assunto');
	pt_register('POST','texto');
	pt_register('POST','status');
	pt_register('POST','id_news');
		
	if($assunto=="" || $texto==""){
		$errors=1;
		$error.="<span style='color:#FF0000'>Os campo com * é obrigatório.</samp>";
	}
	
    if($errors!=1) {
		if($id_news==''){
			$query="INSERT INTO saf_news (id_usuario, assunto, texto, data) values ('".$safpostal_id_usuario."','".$assunto."','".$texto."',NOW())";
		} else {
			$query="UPDATE saf_news SET assunto='".$assunto."', texto='".$texto."', status='".$status."' where id_news='".$id_news."'";	
		}
		$result = $objQuery->SQLQuery($query);
		$id = $objQuery->ID;
		$done=1;
	}
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
		echo '<div class="respotas_sucesso">Newsletter cadastrada com sucesso!<br><br>
			  <a href="news_list.php" title="Clique aqui"><span style="font-size:12px">Clique aqui para visualizar a Lista</span></a>
			  </div>';
		 }	  
		?>
        
        </td>
        </tr>    
        </table>

        <?
        if($done!=1){
		
		if($id_news<>'' and !$errors){
			$sql = $objQuery->SQLQuery("SELECT assunto, texto, status FROM saf_news as n WHERE n.id_news='". $id_news ."'");
			$res = mysql_fetch_array($sql);
			$assunto = $res['assunto'];
			$texto = $res['texto'];
			$status = $res['status'];	
	}
		?>
        
        <form name="form_forum" action="" method="post" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
        <tr>
        <td>
        <table width="555" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
        <td height="50" colspan="2" align="center" valign="middle">
        <strong>CADASTRO DE NEWSLETTER</strong></td>
        </tr>
        <tr>
        <td height="2" colspan="2"></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><span style="font-weight: bold">Status:</span></td>
          <td align="left" valign="middle">
          <select name="status">
			<option name="Ativo" <? if($status=='Ativo') echo 'selected'; ?>>Ativo</option>
			<option name="Inativo" <? if($status=='Inativo') echo 'selected'; ?>>Inativo</option>
			<option name="Cancelado" <? if($status=='Cancelado') echo 'selected'; ?>>Cancelado</option>
		  </select>
            </td>
        </tr>
        <tr>
          <td align="left" valign="middle"><span style="font-weight: bold">Assunto:</span></td>
          <td align="left" valign="middle">
          <input type="text" value="<?= $assunto ?>" name="assunto" class="textfield" style="width:460px;"/>
            <span style="color:#FF0000">*</span></td>
        </tr>
        <tr>
        <td colspan="2" align="left" valign="middle">
		<?
		$oFCKeditor = new FCKeditor('texto');
		$oFCKeditor->voltarConfig['AutoDetectLanguage'] = false; 
		$oFCKeditor->Config['DefaultLanguage'] = 'pt';
		$oFCKeditor->BasePath = '../js/fckeditor/';
		$oFCKeditor->Value = $texto;
		$oFCKeditor->ToolbarSet = 'Default' ; //'Default'
		$oFCKeditor->Width = '700px';
		$oFCKeditor->Height = '450px';
		$oFCKeditor->Create() ;
		?>		
		<input type="hidden" value="<?= $id_news ?>" name="id_news">
		</td>
        </tr>
        <tr>
        <td height="2" colspan="2"></td>
        </tr>
        <tr>
        <td></td>
        <td align="left" valign="middle">
        <input name="submit1" type="submit" class="botoes" value="Gravar" /></td>
        </tr>
        <tr>
        <td colspan="2" align="center" valign="middle"></td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
    	</form>
        
        <?
        }
		?>
        </div>
        </td>
      </tr>
    </table>
    </td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>