<?
require "../includes/topo.php";
$permissao = verifica_permissao('FORUM',$safpostal_departamento_saf);
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
            <td width="345" height="20" align="left" valign="middle"><strong>Perguntas e Respostas</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        <div id="conteudo_forum_list">
		
        <div id="titulo_forum_list">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
        <td width="100%" align="left" valign="middle">Tópico</td>
        </tr>
        </table>
        </div>
<?
$sql = $objQuery->SQLQuery("SELECT * FROM saf_forum as f WHERE f.id_forum='". $id ."'");
$res = mysql_fetch_array($sql);
?>		
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">
		<tr>
		<td width="100%" align="left" valign="middle" height="25" bgcolor="#0099FF"><b><?= $res['titulo'] ?></b></td>
		</tr>
		<tr>
		<td width="100%" align="left" valign="middle" height="25"><?= $res['pergunta'] ?></td>
		</tr>
		
		<tr>
		<td width="100%" align="left" valign="middle" height="25">
        <form name="form_forum_resposta" action="" method="post" enctype="multipart/form-data">
		<div id="topico_<?= $id ?>">
		<input type="button" name="ativar_<?= $id ?>" onclick="forum_topico_acao('topico_<?= $id ?>','<?= $id ?>','Ativo')" value = "Ativar">
		<input type="button" name="inativar_<?= $id ?>" onclick="forum_topico_acao('topico_<?= $id ?>','<?= $id ?>','Inativo')" value = "Inativar">
		<b>Status:</b> <?= $res['status'] ?>
		<div>
		</form>
		</td>
		</tr>
		</table>
		<br><br>
        <div id="titulo_forum_list">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
        <td width="100%" align="left" valign="middle">Respostas</td>
        </tr>
        </table>
        </div>
		<?
$p_valor = '<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">';
$sql = $objQuery->SQLQuery("SELECT f.resposta, date_format(f.data, '%d/%m/%y') as data, uu.nome, f.id_forum_resposta, f.status FROM saf_forum_resposta as f, vsites_user_usuario as uu WHERE f.id_forum='". $id ."' and f.id_usuario=uu.id_usuario and (f.status='Ativo' or f.status='Pendente' and f.id_usuario='".$safpostal_id_usuario."')");
while($res = mysql_fetch_array($sql)){
	$p_valor .= '
		<tr>
		<td width="100%" align="left" valign="middle" height="25" bgcolor="#0099FF"><b>' . $res['data'] . ' - ' . $res['nome'] . '</b></td>
		</tr>
		<tr class="dif">
		<td width="100%" align="left" valign="middle" height="25">' . $res['resposta'] . '</td>
		</tr>	
		<tr class="dif">
		<td width="100%" align="left" valign="middle" height="25">
		<div id="resposta_'.$res['id_forum_resposta'].'">
		<input type="text" readonly name="status_'.$res['id_forum_resposta'].'" value = "'.$res['status'].'">
		<input type="button" name="excluir_'.$res['id_forum_resposta'].'" onclick="forum_resposta_acao(\'resposta_'.$res['id_forum_resposta'].'\',\''.$res['id_forum_resposta'].'\',\'Excluído\')" value = "Excluir">
		<input type="button" name="aprovar_'.$res['id_forum_resposta'].'" onclick="forum_resposta_acao(\'resposta_'.$res['id_forum_resposta'].'\',\''.$res['id_forum_resposta'].'\',\'Ativo\')" value = "Aprovar">
		<div>
		</td>
		</tr>		
	';
}
$p_valor .= '</table>';
echo $p_valor;
?>
</td>
</tr>
</table>
<?
pt_register('POST','submit1');
if ($submit1){
	$errors=0;
	$error="<b>Ocorreram os seguintes erros:</b> ";

	pt_register('POST','resposta');
		
	if($resposta==""){
		$errors=1;
		$error.="<span style='color:#FF0000'>Preencha o campo resposta.</samp>";
	}
	

    if($errors!=1) {	
		$query="INSERT INTO saf_forum_resposta (id_usuario, id_forum, resposta, data) values ('".$safpostal_id_usuario."','".$id."','".$resposta."',NOW())";
		$result = $objQuery->SQLQuery($query);
		$id = $objQuery->ID;
		$done=1;
	}
}
?>

        <?
        if($done!=1){
		?>
        
        <form name="form_forum_resposta" action="" method="post" enctype="multipart/form-data">
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
        <td align="left" valign="middle"><strong>Postar Resposta:</strong></td>
        </tr>
        <tr>
        <td width="485" align="left" valign="middle">
          <textarea name="resposta" id="textarea" cols="45" rows="5" style="width:740px"><?= $resposta ?></textarea>
          <span style="color:#FF0000">*</span>
		</td>
        </tr>
        <tr>
        <td height="2"></td>
        </tr>
        <tr>
        <td align="left" valign="middle">
        <input name="submit1" type="submit" class="botoes" value="Enviar" /></td>
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
		echo '<div class="respotas_sucesso">Resposta enviada com sucesso!<br><br>
		<a href="forum_list.php" title="Clique aqui"><span style="font-size:12px">Clique aqui para voltar aos tópicos</span></a>
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
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>