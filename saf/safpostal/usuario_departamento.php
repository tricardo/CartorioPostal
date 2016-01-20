<?
require "../includes/topo.php";
$permissao = verifica_permissao('USUARIOS',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
pt_register('GET','id');
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
            <td width="345" height="20" align="left" valign="middle"><strong>Usuários</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo_adm_usuario_departamento">
	<?
	
pt_register('POST','submit');
if ($submit) {//check for errors
	$departamento_saf = '';
	pt_register('POST','id');
	$sql = $objQuery->SQLQuery("SELECT * FROM saf_departamento_permissao as dp WHERE dp.status='Ativo' ORDER BY departamento");
	while($res = mysql_fetch_array($sql)){
		$cont_seg++;
		$id_departamento_permissao=$res['id_departamento_permissao'];
		pt_register('POST','pertence_'.$id_departamento_permissao);
		if(${'pertence_'.$id_departamento_permissao}=='on'){ $departamento_saf .= $id_departamento_permissao.','; }
	}

	$sql_update = "UPDATE vsites_user_usuario SET departamento_saf = '".$departamento_saf."' WHERE id_usuario='$id'";
	$update = $objQuery->SQLQuery($sql_update);						
	

	?>
    <table border="0">
		<tr>
        	<td valign="top">
	<?
	if ($done) {
		?>
	<h3>Registro atualizado com sucesso!</h3>
	<?
	}
	?>
		</td>
    	</tr>
    </table>
<?
}
$sql_atual = $objQuery->SQLQuery("SELECT nome, departamento_saf FROM vsites_user_usuario as uu WHERE id_usuario='".$id."' and uu.status='Ativo' and id_empresa='1'");
$res_atual = mysql_fetch_array($sql_atual);
$nome = $res_atual['nome'];
$departamento_saf_ext = explode(',',$res_atual['departamento_saf']);

?>


<table border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#0071B6">
	<tr>
		<td valign="top" align="center">
        <form name="form_usuario_departamento" action="" method="post" enctype="multipart/form-data">
        <table cellpadding="4" cellspacing="1" class="result_tabela" border="0">
        <tr>
        
		<td width="510" class="result_menu" colspan="2" bgcolor="#FFFFFF" align="left"><b>Departamentos de <?= $nome ?></b></td>
		<td class="result_menu" align="center" width="59" bgcolor="#FFFFFF"><b>Pertence</b></td>
		</tr> 
			<? 
                $cont_seg=0;
                $cont_sub=0;
                $sql = $objQuery->SQLQuery("SELECT dp.*, m.modulo FROM saf_departamento_permissao as dp,  saf_modulo as m where dp.id_modulo=m.id_modulo AND dp.status='Ativo' ORDER BY modulo, departamento");
                while($res = mysql_fetch_array($sql)){
			?>        
                <tr>
                	<td class="result_celula" nowrap bgcolor="#FFFFFF" align="left"><?= $res['modulo'] ?></td>
                    <td class="result_celula" nowrap bgcolor="#FFFFFF" align="left"><?= $res['departamento'] ?></td>
                    <td class="result_celula" align="center" nowrap bgcolor="#FFFFFF">
                    <input type="checkbox" name="pertence_<?= $res['id_departamento_permissao'] ?>" <? if(in_array($res['id_departamento_permissao'], $departamento_saf_ext)) echo ' checked="checked"';  ?> />
                    </td>                  
      			</tr>
            <? } ?>
            <tr>
                  <td colspan="4" bgcolor="#FFFFFF">
                  	<div align="center">
                    	<input type="submit" name="submit" value=" Atualizar " class="button_busca" />
&nbsp;
                     <input type="submit" name="cancelar" value="Cancelar" onClick="document.form_usuario_departamento.action='usuarios.php'" class="button_busca" />                        
                        <input type="hidden" name="id" value="<?= $id ?>"/>
                    </div>
              </td>
        </tr>
          </table>
          </form>                    
</table>
</td>
</tr>
</table>
    </td>
  </tr>
</table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>