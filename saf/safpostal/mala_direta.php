<?
require "../includes/topo.php";
$permissao = verifica_permissao('USUARIOS',$safpostal_departamento_saf);
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
<td align="left" valign="top">
<table width="768" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png">
	<table width="768" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="345" height="20" align="left" valign="middle"><strong>Mala Direta</strong></td>
	<td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
    <div id="conteudo">
			<?
			pt_register('POST','submit1');
			if ($submit1){
				//check for errors
				$departamento_m = '';
				$onde = '';
				$error = '';
				$errors = '';
				pt_register('POST','id_news');
				pt_register('POST','id_empresa');

				$texto = str_replace('\"','"',$texto);

				$sql = $objQuery->SQLQuery("SELECT * FROM saf_news as n WHERE id_news='".$id_news."'");
				$res = mysql_fetch_array($sql);
				$Subject = $res['assunto'];
				$html = $res['texto'];
			//error_reporting(0);
				set_time_limit(0);
				require("../includes/maladireta/config.inc.php");			
				require("../includes/maladireta/class.Email.php");
				$Sender = "Mala Direta <diretoria.geral@cartoriopostal.com.br>";
				 
				
				$sql = $objQuery->SQLQuery("SELECT * FROM vsites_departamento as d WHERE id_departamento!='1' ORDER BY departamento");			
				$cont_dep='';
				while($res = mysql_fetch_array($sql)){
					$id_departamento=$res['id_departamento'];
					pt_register('POST','envia_'.$id_departamento);
					if(${'envia_'.$id_departamento}=='on'){ 
						if($cont_dep==''){ 
							$onde .= " and (uu.departamento_p like '%".$id_departamento."%' "; 
						} else {
							$onde .= " or uu.departamento_p like '%".$id_departamento."%' ";
						}
						$departamento = $id_departamento.',';
						$cont_dep++;
					}
				}
				if($cont_dep<>0) $onde .= ')';
				if($id_news=='') { $error = "Selecione o departamento"; $errors=1; }
				if($id_empresa<>'') $onde .= " and uu.id_empresa='".$id_empresa."'";
				
				if($erro==''){
					$sql = $objQuery->SQLQuery("select uu.email, uu.nome from vsites_user_usuario as uu, vsites_user_empresa as ue where 
					(ue.status='Ativo' or ue.status='Inativo') and 
					ue.id_empresa=uu.id_empresa and
					(uu.status='Ativo' or uu.status='Inativo') 
					".$onde);
					while($res = mysql_fetch_array($sql)){
						$Recipiant = $res['email']; 

						//** you can still specify custom headers as long as you use the constant
						//** 'EmailNewLine' to separate multiple headers.
			
						$CustomHeaders= '';
			
						//** create the new email message. All constructor parameters are optional and
						//** can be set later using the appropriate property.
			
						$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
						$message->Cc = $Cc; 
						$message->Bcc = $Bcc; 
						
						$message->SetHtmlContent($html);
			
						$pathToServerFile ="attachments/$at[1]/$at[2]";        //** attach this very PHP script.
						$serverFileMimeType = 'multipart/mixed';  //** this PHP file is plain text.
			
						//** attach the given file to be sent with this message. ANy number of
						//** attachments can be associated with an email message. 
			
						//** NOTE: If the file path does not exist or cannot be read by PHP the file
						//** will not be sent with the email message.
						$message->Send();						
						echo $res['email'].'<br>';
					}
					$sql = $objQuery->SQLQuery("insert into saf_maladireta(data,id_news,id_empresa,departamento,id_usuario) values(NOW(),'".$id_news."','".$id_empresa."','".$departamento."','".$safpostal_id_usuario."')");
					$done = 1;
				} else {
					echo $erro;
				}
				
			}
        
		if ($errors) {
		echo '<div class="respotas_erro">'.$error.'</div>';
		}
		?>
        
        <?
		if ($done) {
		echo '<div class="respotas_sucesso"><br>MALA DIRETA ENVIADA COM SUCESSO!<br><a href="mala_direta.php">Clique para voltar</a><br>
			  </div>';
		 }	  
		
if($done == ''){			
			?>
        
		<form name="form_forum" action="" method="post" enctype="multipart/form-data">
        <table align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#0071B6">
        <tr>
        <td>
			<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
			<tr>
			<td height="50" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><strong>MALA DIRETA</strong></td>
			</tr>
						
			<? 
			$cont_seg=0;
			$cont_sub=0;
			$sql = $objQuery->SQLQuery("SELECT * FROM vsites_departamento WHERE id_departamento!='1' ORDER BY departamento");
				
			while($res = mysql_fetch_array($sql)){
			?>        
            	<tr>
				<td align="right" nowrap bgcolor="#FFFFFF" class="result_celula"><strong><?= $res['departamento'] ?>:</strong></td>
				<td align="center" nowrap bgcolor="#FFFFFF" class="result_celula">
				<input type="checkbox" name="envia_<?= $res['id_departamento'] ?>" />
				</td>
				</tr>
			<?
			}
			?>
			<tr>
			<td align="right" valign="middle" bgcolor="#FFFFFF"><span style="font-weight: bold">Franquias:</span></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF">
			<select name="id_empresa" style="width:315px" id="empresas">
			<option value="">Todas</option>
			
			<?
			$sql = $objQuery->SQLQuery("SELECT id_empresa, fantasia FROM vsites_user_empresa as ue WHERE status = 'Ativo' or status = 'Inativo' ORDER BY fantasia");
			
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_empresa'].'" ';
				
				if($busca_id_empresa==$res['id_empresa']) echo ' selected="selected"'; 
				echo '>'.$res['fantasia'].'</option>';			
			}
			?>
			
			</select>
			</td>
			</tr>
			<tr>
			<td align="right" valign="middle" bgcolor="#FFFFFF"><span style="font-weight: bold">Newsletter:</span></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF">
			<select name="id_news" style="width:315px" id="assunto">
           	<?
			$sql = $objQuery->SQLQuery("SELECT id_news, assunto, texto FROM saf_news as n WHERE status = 'Ativo' ORDER BY assunto");
			
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_news'].'" ';
				
				if($busca_id_news==$res['id_news']) echo ' selected="selected"'; 
				echo '>'.$res['assunto'].'</option>';			
			}
			?>
			</select>
			</td>
			</tr>
			<tr>
			<td bgcolor="#FFFFFF"></td>
			<td align="left" valign="middle" bgcolor="#FFFFFF">
			<input name="submit1" type="submit" class="botoes" value="Enviar" /></td>
			</tr>
			</table>
        </td>
        </tr>
        </table>
    	</form>
         
		<? } ?>
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