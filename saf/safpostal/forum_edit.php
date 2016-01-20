<?
require "../includes/topo.php";
pt_register('GET','id');
pt_register('POST','altera_status');
pt_register('POST','atualizar');
pt_register('POST','submit1');
pt_register('POST','aprova_resposta');
pt_register('POST','atualiza_resposta');

$permissao = verifica_permissao('FORUM',$safpostal_departamento_saf);
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
		$done=1;
	}
}else if($altera_status && $permissao=='TRUE'){
	pt_register('POST','id_forum');
	switch($altera_status){
		case 'aprova':
			$st=1;
			break;
		case 'reprovar':
			$st=2;
			break;
		default:$st=0;
	}
	
	$query="UPDATE saf_forum SET status=$st WHERE id_forum=$id_forum";
	$result = $objQuery->SQLQuery($query);
	$done=1;
}else if($aprova_resposta){
	pt_register('POST','id_forum_resposta');
	switch($aprova_resposta){
		case 'aprova':
			$st=1;
			break;
		case 'reprovar':
			$st=2;
			break;
		default:$st=0;
	}
	$query="UPDATE saf_forum_resposta SET status=$st WHERE id_forum_resposta=$id_forum_resposta";
	$result = $objQuery->SQLQuery($query);
	$done=1;
}else if($atualizar){
	pt_register('POST','id_forum');
	$sql = $objQuery->SQLQuery("SELECT id_usuario FROM saf_forum as f WHERE f.id_forum='". $id_forum ."'");
	$num = mysql_num_rows($sql);
	$perg = mysql_fetch_array($sql);
	
	if($perg['id_usuario']==$safpostal_id_usuario){
		pt_register('POST','pergunta');
		$query="UPDATE saf_forum SET pergunta='$pergunta' WHERE id_forum=$id_forum";
		$result = $objQuery->SQLQuery($query);
		$id = $id_forum;
		$done=1;
	}
}else if($atualiza_resposta){
	pt_register('POST','id_forum_resposta');
	pt_register('POST','resposta');
	$sql = $objQuery->SQLQuery("SELECT id_usuario,id_forum,status FROM saf_forum_resposta as f WHERE f.id_forum_resposta='". $id_forum_resposta ."'");
	$num = mysql_num_rows($sql);
	$resp = mysql_fetch_array($sql);
	$id_forum = $resp['id_forum'];
	if($resp['id_usuario']==$safpostal_id_usuario && $resp['status']==0){
		pt_register('POST','pergunta');
		$query="UPDATE saf_forum_resposta SET resposta='$resposta' WHERE id_forum_resposta=$id_forum_resposta";
		$result = $objQuery->SQLQuery($query);
		$id = $id_forum;
		$done=1;
	}else{
		$errors=1;
		$error='Não é permitido editar esse post';
	}
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
        <td width="100%" align="left" valign="middle">Pergunta</td>
        </tr>
        </table>
        </div>
<?
$p_valor = "";
$sql = $objQuery->SQLQuery("SELECT * FROM saf_forum as f WHERE f.id_forum='". $id ."'");
$num = mysql_num_rows($sql);
$perg = mysql_fetch_array($sql);

if($num=='' 
		|| ($perg['status']==0 && $permissao=='FALSE' && $safpostal_id_usuario!=$perg['id_usuario']) 
		|| ($perg['status']==2 && $permissao=='FALSE')){
	$errors=1;
	$error = 'Esse tópico já foi encerrado.';	
}else{
		$p_valor .= '
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">
		<tr>
		<td width="100%" align="left" valign="middle" bgcolor="#0099FF"><b>' . $perg['titulo'] . '</b></td>
		<tr>
		<tr class="dif">
		<td width="100%" align="left" valign="middle" >';
		$p_valor.=($perg['status']==0 && $perg['id_usuario']==$safpostal_id_usuario)?'
		<form method="post" action="">
			<textarea name="pergunta" id="textarea" cols="45" rows="3" style="width:740px">'.$perg['pergunta'].'</textarea>
			<input type="submit" value="atualizar" name="atualizar"/>
			<input type="hidden" value="'.$perg['id_forum'].'" name="id_forum"/>
		</form>':
		nl2br($perg['pergunta'])."<br>";
		$p_valor.= '<br></td></tr>
		<tr>
		</table>
        <div id="titulo_forum_list">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
        <td width="100%" align="left" valign="middle">Respostas</td>
        </tr>
        </table>
        </div>

		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">
		';

	
	$sql = $objQuery->SQLQuery("SELECT f.resposta,f.id_forum_resposta, date_format(f.data, '%d/%m/%y') as data, uu.nome,ue.fantasia as empresa,f.status,f.id_usuario
	FROM saf_forum_resposta as f, vsites_user_usuario as uu, vsites_user_empresa as ue 
	WHERE f.id_forum='". $id ."' and 
	f.id_usuario=uu.id_usuario and 
	uu.id_empresa = ue.id_empresa ORDER BY f.data DESC");
	while($res = mysql_fetch_array($sql)){
		if(($res['id_usuario']==$safpostal_id_usuario && $res['status']!=2)|| $res['status']==1 || $permissao=='TRUE'){
			$p_valor .= 
			'<tr>
				<td width="100%" align="left" valign="middle" bgcolor="#0099FF"><b>' . $res['data'] . ' - ' . $res['nome'] . ' - ['.$res['empresa'].']</b></td>
				<tr>
				<tr class="dif">
				<td width="100%" align="left" valign="middle" >';
			$p_valor.=($res['status']==0 && $res['id_usuario']==$safpostal_id_usuario)?
			'<form method="post" action="">
				<textarea cols="45" rows="3" style="width:740px"  name="resposta">'.$res['resposta'].'</textarea>
				<input type="hidden" name="id_forum_resposta" value="'.$res['id_forum_resposta'].'"/>
				<input type="submit" value="Atualizar" name="atualiza_resposta"/>
			</form>'
			:
			nl2br($res['resposta'])."<br><br>";
			if($permissao=='TRUE'){
				$p_valor.= '<form method="post"><br>
						<input type="hidden" name="id_forum_resposta" value="'.$res['id_forum_resposta'].'"/>';
				if($res['status']!=1){
					$p_valor.='<input type="submit" value="aprova" name="aprova_resposta"/>';
				}
				$p_valor.='<input type="submit" value="reprovar" name="aprova_resposta"/>';
				$p_valor.='</form>';
				$p_valor.='<br></td>
				<tr>';
			}
		}
	}
	$p_valor .= '</table>';
	echo $p_valor;
}
?>
</td>
</tr>
</table>
        <?if($done!=1 && !$errors){?>
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
			        	<td align="left" valign="middle"><input name="submit1" type="submit" class="botoes" value="Enviar" /></td>
			        </tr>
		        </table>
	    	</form>        
	    	<?php 
	    	if($permissao=='TRUE'){ ?>
		    <form method="post" name="form_forum_aprova" action="">
				<input type="hidden" value="<?php echo $perg['id_forum']?>" name="id_forum"/>
			    <?php if($perg['status']!=1){?>
			    	<input type="submit" value="aprova" name="altera_status"/>
			    <?php } ?>
		    	<input type="submit" value="reprovar" name="altera_status"/>
			</form>
	    	<?php }?>
        <? }?>
        
        <table align="center" border="0" cellpadding="3" cellspacing="0" width="550">
        <tr>
        <td align="center">
        
        <?
		if ($errors) {
		echo '<div class="respotas_erro">'.$error.'</div>';
		}
		if ($done) {
			echo '<div class="respotas_sucesso">';
			echo 'Resposta enviada com sucesso!';
			echo '<br><br>
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