<? require('header.php'); 
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
	
<div style="margin:15px">
<h1 class="tit"><img src="../images/tit/tit_servico.png" alt="Título" /> Serviço</h1>
<hr class="tit"/><br />

<?
pt_register('POST','submit');
if ($submit) {//check for errors
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b><ul>";
	pt_register('POST','id_servico');
	pt_register('POST','valor');
	pt_register('POST','variacao');
	pt_register('POST','dias');
	$status = 'Ativo';

	if($id_servico=="" || $variacao=="" || $valor=="" || $dias==""){
		$errors=1;
		$error.="<li><b>Os campos com * são obrigatórios.</b></li>";
	}



if($errors!=1) {
	$query="insert into vsites_servico_var(id_servico,variacao,valor_1,dias_1) values ('".$id_servico."','".$variacao."','".$valor."','".$dias."')";
	$result = $objQuery->SQLQuery($query);
	$id = $objQuery->ID;
	$done=1;
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
		?><h3>Novo registro adicionado com sucesso!</h3>
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
?>
<?	if (!$done) { ?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">
		
          <blockquote>
            <form enctype="multipart/form-data" action="" method="post" name="servico_add">
              <table width="650" class="tabela">
<tr>
                  <td colspan="4" class="tabela_tit"> Dados do Servi&ccedil;o</td>                  
      </tr>                

                <tr>
                <td> <div align="right"><strong>Serviço: </strong></div></td>
      <td colspan="3">
        		<select name="id_servico" style="width:470px" class="form_estilo">
		<?
			$sql = $objQuery->SQLQuery("SELECT * from vsites_servico where status='Ativo' order by descricao");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_servico'].'">'.$res['descricao'].'</option>';
			}
		?>        
        </select>   
         <font color="#FF0000">*</font></td></tr>    		 
<tr>

                  <td> <div align="right"><strong>Varia&ccedil;&atilde;o: </strong></div></td>
      <td colspan="3">
        <input type="text" name="variacao" value="<?= $variacao ?>" style="width:470px" class="form_estilo">
        <font color="#FF0000">*</font></td></tr>          
  

  <tr>
     <td><div align="right"><strong>Dias: </strong></div></td>
      <td><input type="text" name="dias" value="<?= $dias ?>" maxlength="4" style="width:50px" onkeyup="masc_numeros(this,'####');" class="form_estilo"/>
        <font color="#FF0000">*</font></td>
  <td> <div align="right"><strong>Valor:</strong></div></td>
      <td><input type="text" name="valor" value="<?= $valor ?>" style="width:150px" class="form_estilo"/>
        <font color="#FF0000">*</font></td>
</tr> 
                <tr>
                  <td colspan="4"><div align="center">
                    <input type="submit" name="submit" value="Adicionar" class="button_busca" />&nbsp;  <input type="submit" name="cancelar" value="Cancelar" onclick="document.servico_add.action='servico.php'" class="button_busca" />
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