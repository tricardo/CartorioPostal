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
            <td width="345" height="20" align="left" valign="middle"><strong>PGN/DRE</strong></td>
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
	pt_register('POST','id_usuario');
	pt_register('POST','id_empresa');
	pt_register('POST','titulo1');
	pt_register('POST','titulo2');
	pt_register('POST','titulo3');
	pt_register('POST','titulo4');
	pt_register('POST','titulo5');
	pt_register('POST','arquivo');

	#upload de imagens
	$config = array();   
	// Tamanho máximo do file_anexo (em bytes)
	$config["tamanho"] = 999999;
	// Largura máxima (pixels)
	$config["largura"] = 3000;
	// Altura máxima (pixels)
	$config["altura"]  = 3000;
	// Upload
	
	$file1 = isset($_FILES["file1"]) ? $_FILES["file1"] : FALSE;
	// Formulário postado... executa as ações
	if($file1['name']<>''){  
		$error_image = valida_upload($file1, $config);
		if ($error_image){
			$error .= 'Erro na imagem 1: '.$error_image;
			$errors=1;
		}
	}
	
	$file2 = isset($_FILES["file2"]) ? $_FILES["file2"] : FALSE;
	// Formulário postado... executa as ações
	if($file2['name']<>''){  
		$error_image = valida_upload($file2, $config);
		if ($error_image){
			$error .= 'Erro na imagem 2: '.$error_image;
			$errors=1;
		}
	}

	$file3 = isset($_FILES["file3"]) ? $_FILES["file3"] : FALSE;
	// Formulário postado... executa as ações
	if($file3['name']<>''){  
		$error_image = valida_upload($file3, $config);
		if ($error_image){
			$error .= 'Erro na imagem 3: '.$error_image;
			$errors=1;
		}
	}
	
	$file4 = isset($_FILES["file4"]) ? $_FILES["file4"] : FALSE;
	// Formulário postado... executa as ações
	if($file4['name']<>''){  
		$error_image = valida_upload($file4, $config);
		if ($error_image){
			$error .= 'Erro na imagem 4: '.$error_image;
			$errors=1;
		}
	}		
	
	$file5 = isset($_FILES["file5"]) ? $_FILES["file5"] : FALSE;
	// Formulário postado... executa as ações
	if($file5['name']<>''){  
		$error_image = valida_upload($file5, $config);
		if ($error_image){
			$error .= 'Erro na imagem 5: '.$error_image;
			$errors=1;
		}
	}	
	
	if($errors!=1){	
		$file_path = "../pgn_dre_upload/";
		if($file1['name']){
			// Pega extensão do file_anexo
			preg_match("/\.(jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp){1}$/i", $file1["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = $safpostal_id_usuario.'1'.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			move_uploaded_file($file1["tmp_name"], $imagem_dir);
			$file1_name = $imagem_nome;
			
			$query="INSERT INTO saf_pgn_dre (id_usuario, id_empresa, arquivo, titulo, extensao, data) values ('".$safpostal_id_usuario."','".$id_empresa."','".$file1_name."','".$titulo1."','".$ext[1]."',NOW())";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;			
		}	
		
		if($file2['name']){
			// Pega extensão do file_anexo
			preg_match("/\.(jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp){1}$/i", $file2["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = $safpostal_id_usuario.'2'.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			move_uploaded_file($file2["tmp_name"], $imagem_dir);
			$file2_name = $imagem_nome;
			
			$query="INSERT INTO saf_pgn_dre (id_usuario, id_empresa, arquivo, titulo, extensao, data) values ('".$safpostal_id_usuario."','".$id_empresa."','".$file2_name."','".$titulo2."','".$ext[1]."',NOW())";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;				
		}	
		
		if($file3['name']){
			// Pega extensão do file_anexo
			preg_match("/\.(jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp){1}$/i", $file3["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = $safpostal_id_usuario.'3'.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem

			move_uploaded_file($file3["tmp_name"], $imagem_dir);
			$file3_name = $imagem_nome;
			
			$query="INSERT INTO saf_pgn_dre (id_usuario, id_empresa, arquivo, titulo, extensao, data) values ('".$safpostal_id_usuario."','".$id_empresa."','".$file3_name."','".$titulo3."','".$ext[1]."',NOW())";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;				
		}	

		if($file4['name']){
			// Pega extensão do file_anexo
			preg_match("/\.(jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp){1}$/i", $file4["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = $safpostal_id_usuario.'4'.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			move_uploaded_file($file4["tmp_name"], $imagem_dir);
			$file4_name = $imagem_nome;

			$query="INSERT INTO saf_pgn_dre (id_usuario, id_empresa, arquivo, titulo, extensao, data) values ('".$safpostal_id_usuario."','".$id_empresa."','".$file4_name."','".$titulo4."','".$ext[1]."',NOW())";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;				
		}		

		if($file5['name']){
			// Pega extensão do file_anexo
			preg_match("/\.(jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp){1}$/i", $file5["name"], $ext);
			// Gera um nome único para a imagem
			$imagem_nome = $safpostal_id_usuario.'5'.md5(uniqid(time())) . "." . $ext[1];
			// Caminho de onde a imagem ficará
			$imagem_dir = $file_path.$imagem_nome;
			// Faz o upload da imagem
			move_uploaded_file($file5["tmp_name"], $imagem_dir);
			$file5_name = $imagem_nome;
			
			$query="INSERT INTO saf_pgn_dre (id_usuario, id_empresa, arquivo, titulo, extensao, data) values ('".$safpostal_id_usuario."','".$id_empresa."','".$file5_name."','".$titulo5."','".$ext[1]."',NOW())";
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;				
		}	
		$done=1;
	}
}

?>
        <form name="form_upload" action="" method="POST" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
        <tr>
        <td>
        <table width="550" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
        <td height="50" colspan="4" align="center" valign="middle">
        <strong>SELECIONE A FRANQUIA DESEJADA E ENVIE O ARQUIVO</strong></td>
        <tr>
        <td height="2" colspan="4"></td>
        </tr>
        <tr>
        <td width="54">Franquia:</td>
        <td colspan="3">
        <select name="id_empresa" style="width:412px">
        <option value="">Todas</option>
        <?
        $sql = $objQuery->SQLQuery("SELECT id_empresa, fantasia FROM vsites_user_empresa as ue WHERE status = 'Ativo' ORDER BY fantasia ");
		
		while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['id_empresa'].'" ';
			
				if($id_empresa==$res['id_empresa']) echo ' selected="selected"'; 
				echo '>'.$res['fantasia'].'</option>';			
			}
		?>
          </select></td>
        </tr>
        <tr>
        <td height="2" colspan="4"></td>
        </tr>
        <tr><td>Arquivo:</td>
        <td>Título</td>
        <td><input type="text" name="titulo1"/></td>
        <td><input name="file1" type="file" class="textfield"/></td>
        </tr>
        <tr>
          <td rowspan="4">&nbsp;</td>
          <td>T&iacute;tulo</td>
          <td><input type="text" name="titulo2"/></td>
          <td><input name="file2" type="file" class="textfield"/></td>
        </tr>
        <tr>
          <td>T&iacute;tulo</td>
          <td><input type="text" name="titulo3"/></td>
          <td><input name="file3" type="file" class="textfield"/></td>
        </tr>
        <tr>
          <td>T&iacute;tulo</td>
          <td><input type="text" name="titulo4"/></td>
          <td><input name="file4" type="file" class="textfield"/></td>
        </tr>
        <tr>
          <td>T&iacute;tulo</td>
          <td><input type="text" name="titulo5"/></td>
          <td><input name="file5" type="file" class="textfield"/></td>
        </tr>
        <tr>
        <td height="2" colspan="4"></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="3">
        <input name="submit1" type="submit" class="botoes" value=" Enviar " /></td>
        </tr>
        </table>          
        </td>
        </tr>
        </table>
        </form>
        <?
		if ($errors){
		echo '<div id="mensagem_error_ftp">'.$error.'</div>';
		}
		?>        
        <?
		if ($done){
		echo '<div id="mensagem_ftp"><strong><span style="font-size:12px">Registro efetuado com sucesso!</span></strong><br><br>
			  <a href="pgn_dre_list.php" title="Clique aqui"><span style="font-size:12px">Clique aqui para visualizar a lista de arquivos</span></a>
			  </div>';
		}	  
		?>

</div>

</div>
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