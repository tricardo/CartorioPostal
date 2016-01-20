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
            <td width="345" height="20" align="left" valign="middle"><strong>Perguntas e Respostas</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquias: <? echo $safpostal_fantasia ?></span></td>
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

	pt_register('POST','categoria');
	pt_register('POST','status');
		
	if($categoria==""){
		$errors=1;
		$error.="<span style='color:#FF0000'>Os campo com * é obrigatório.</samp>";
	}
	

    if($errors!=1) {	
	$query="INSERT INTO saf_forum_categoria (id_usuario, categoria, status, data) values ('".$safpostal_id_usuario."','".$categoria."','Ativado',NOW())";
	
	$result = $objQuery->SQLQuery($query);
	$id = $objQuery->ID;
	$done=1;
	}
}
?>
        <?
        if($done!=1){
		?>
        
        <form name="form_forum_categoria" action="" method="post" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
        <tr>
        <td>
        <table width="555" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
        <td height="50" colspan="2" align="center" valign="middle">
        <strong>CADASTRO DE CATEGORIA DO F&Oacute;RUM</strong></td>
        </tr>
        <tr>
          <td width="58" align="left" valign="middle"><span style="font-weight: bold">Categoria:</span></td>
          <td width="485" align="left" valign="middle">
          <input type="text" value="<?= $categoria ?>" name="categoria" class="textfield" style="width:455px;"/>
            <span style="color:#FF0000">*</span></td>
        </tr>
        <tr>
        <td></td>
        <td align="left" valign="middle">
        <input name="submit1" type="submit" class="botoes" value="Enviar" /></td>
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
		echo '<div class="respotas_sucesso">Categoria registrada com sucesso!<br><br>
			  <a href="forum_sub_categoria.php" title="Clique aqui"><span style="font-size:12px">Clique aqui para cadastrar a sub categoria</span></a>
			  </div>';
		 }	  
		?>
        
        </td>
        </tr>    
        </table>
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