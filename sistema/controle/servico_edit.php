<?
require('header.php');
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

?>
	
<div style="margin:15px">
<h1 class="tit"><img src="../images/tit/tit_servico.png" alt="Título" /> Servi&ccedil;o</h1>
<hr class="tit"/><br />

<?
pt_register('POST','submit');
if ($submit) {//check for errors
	$error="";
	pt_register('POST','id');
$errors=0;
$error="<b>Ocorreram os seguintes erros:</b><ul>";

	pt_register('POST','valor');
	pt_register('POST','status');
	pt_register('POST','dias');

	if($status=="" || $valor=="" || $dias==""){
		$errors=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}

if ($errors!=1) {
	$sql = "update vsites_servico_var set valor_".$controle_id_empresa."='$valor', dias_".$controle_id_empresa."='$dias' where id_servico_var='$id'";
	$result = $objQuery->SQLQuery($sql);
	$done = 1;
}
?>
    <table border="0">
		<tr>
        	<td valign="top">
<?
	if ($errors) {
		echo $error;
	}
	if ($done) {
		?><h3>Registro atualizado com sucesso!</h3>
		<h3>O que você deseja fazer?</h3>
		<h3 style="margin:0"><img src="../images/seta.png" /> <a href="servico.php">Visualizar Registros</a></h3>
		<?
	}	
	?> 
    		</td>
    	</tr>
    </table>
	<?
}	
if (!$done) {
	$id				= $_GET["id"];
	$sql = $objQuery->SQLQuery("select vsites_servico.id_departamento, vsites_servico.status, vsites_servico.descricao, vsites_servico_departamento.departamento, vsites_servico_var.* from vsites_servico, vsites_servico_var, vsites_servico_departamento where
    vsites_servico.id_servico = vsites_servico_var.id_servico  and
    vsites_servico.id_departamento = vsites_servico_departamento.id_servico_departamento and
    vsites_servico_var.id_servico_var='" . $id . "'");
	$res = mysql_fetch_array($sql);
	$id_departamento	= $res['id_departamento'];
	$variacao			= $res['variacao'];
	$valor				= $res['valor_'.$controle_id_empresa];
	$dias				= $res['dias_'.$controle_id_empresa];
	$status				= $res['status'];
	$descricao			= $res['descricao'];
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
		
          <blockquote>
                        <form enctype="multipart/form-data" action="" method="post" name="servico_edit">
              <table width="650" class="tabela">
<tr>
                  <td colspan="4" class="tabela_tit"> Dados do Servi&ccedil;o</td>                  
      </tr>                
                <tr>
                  <td width="100"> <div align="right"><strong>Status:</strong></div></td>
      <td width="243">
          <input type="text" name="status" readonly="readonly" value="<?= $status ?>" style="width:150px" class="form_estilo">
          <font color="#FF0000">*</font> </td>
      <td width="70"></td>
      <td width="219">        </td>
    </tr>
                <tr>
                <td> <div align="right"><strong>Departamento: </strong></div></td>
      <td colspan="3">
        		<select name="id_departamento" style="width:470px" class="form_estilo">
		<?
			$sql = $objQuery->SQLQuery("SELECT * from vsites_servico_departamento where id_servico_departamento='".$id_departamento."' order by departamento");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_servico_departamento'].'">'.$res['departamento'].'</option>';
			}
		?>        
        </select>   
        <font color="#FF0000">*</font></td></tr>    
<tr>
                  <td> <div align="right"><strong>Descri&ccedil;&atilde;o: </strong></div></td>
      <td colspan="3">
        <input type="text" name="descricao" readonly="readonly" value="<?= $descricao ?>" style="width:470px" class="form_estilo">
        <font color="#FF0000">*</font></td></tr>
<tr>
                  <td> <div align="right"><strong>Varia&ccedil;&atilde;o: </strong></div></td>
      <td colspan="3">
        <input type="text" name="variacao" readonly="readonly" value="<?= $variacao ?>" style="width:470px" class="form_estilo">
        <font color="#FF0000">*</font></td></tr>          
  
<tr>
     <td><div align="right"><strong>Dias: </strong></div></td>
      <td><input type="text" name="dias" value="<?= $dias ?>" maxlength="4" style="width:50px" onkeyup="masc_numeros(this,'####');" class="form_estilo"/>
        <font color="#FF0000">*</font></td>

      <td> <div align="right"><strong>Valor:</strong></div></td>
      <td><input type="text" name="valor" value="<?= $valor ?>" id="valor" onkeyup="moeda(event.keyCode,this.value,'valor');" style="width:150px" class="form_estilo"/>
        <font color="#FF0000">*</font></td>
</tr> 
                <tr>
                  <td colspan="4"><div align="center">
                    <input type="submit" name="submit" value="Atualizar" class="button_busca" />&nbsp;  <input type="submit" name="cancelar" value="Cancelar" onclick="document.servico_edit.action='servico.php'" class="button_busca" />
                    <input type="hidden" name="id" value="<?= $id ?>" />
                  </div></td>
      </tr>
              </table>
            </form>
      </blockquote></td>
</tr>
</table>
</div>
<?php 
}
require('footer.php');
?>
