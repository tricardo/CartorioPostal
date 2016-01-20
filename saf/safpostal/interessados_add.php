<?
require "../includes/topo.php";
$permissao = verifica_permissao('INTERESSADOS',$safpostal_departamento_saf);
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
            <td width="345" height="20" align="left" valign="middle"><strong>Página inicial</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="middle">
		
		<?

		pt_register('POST','submit1');

	if ($submit1){
		$errors=0;
		$error="<b>Ocorreram os seguintes erros:</b> ";

		pt_register('POST','nome');
		pt_register('POST','email');
		pt_register('POST','data_nasc');
		pt_register('POST','sexo');
		pt_register('POST','rg');
		pt_register('POST','cpf');
		pt_register('POST','tel');
		pt_register('POST','tel2');
		pt_register('POST','cel');
		pt_register('POST','endereco');
		pt_register('POST','numero');
		pt_register('POST','complemento');
		pt_register('POST','bairro');
		pt_register('POST','cidade');
		pt_register('POST','cep');
		pt_register('POST','estado');
		pt_register('POST','estado_interesse');
		pt_register('POST','id_cidade_interesse');
		pt_register('POST','obs');
		pt_register('POST','status');
		
		if($nome=="" || $email=="" || $tel=="" || $id_cidade_interesse =="" || $estado_interesse==""){
		$errors=1;
		$error.="<span style='color:#FF0000'>Os campos com * são obrigatórios.</samp>";
		}

	
			if($errors!=1) {	
			$query="INSERT INTO saf_interesse (nome, email, data_nasc, sexo, rg, cpf, tel, tel2, cel, endereco, numero, complemento, bairro, cidade, cep, estado, estado_interesse, id_cidade_interesse, obs, status, data) values ('".$nome."','".$email."','".$data_nasc."','".$sexo."','".$rg."','".$cpf."','".$tel."','".$tel2."','".$cel."','".$endereco."','".$numero."','".$complemento."','".$bairro."','".$cidade."','".$cep."','".$estado."','".$estado_interesse."','".$id_cidade_interesse."','".$obs."','Pendente',NOW())";
	
			$result = $objQuery->SQLQuery($query);
			$id = $objQuery->ID;
			$done=1;
			}
	}
?>

<?
        if($done!=1){
		

		?>
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="600">
			<tr>
			<td align="center">
			<?
			if ($errors) {
			echo '<div class="respotas_erro">'.$error.'</div>';
			}
			?>
			
			<?
			if ($done) {
			echo '<div id="respotas_sucesso" style="font-size:16px">O cadastro foi efetuado com sucesso!</div>';
			}	  
			?>        
			</td>
			</tr>    
			</table>		
			<form name="form_interesse" action="" method="post" enctype="multipart/form-data">
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			<td height="20"></td>
			</tr>
			<tr>
			<td height="30" colspan="5" align="center" valign="middle" bgcolor="#0071B6" style="color:#FFFFFF"><strong>CADASTRO DE INTERESSADOS</strong></td>
			</tr>
			<tr>
			<td height="6" colspan="5" align="center" valign="midlle"></td>
			</tr>
			<tr>
			<td colspan="5" align="center" valign="middle" height="30">Para obter informações de como adquirir uma franquia Cartório Postal, preencha esse cadastro</td>
			</tr>
			<tr>
			<td height="30" colspan="5" align="left" valign="middle" bgcolor="#95D8FF">DADOS PESSOAIS</td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Nome completo:</td>
			<td colspan="4" align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="nome" value="<?= $nome ?>" type="text" style="width:420px"/><samp style="color:#FF0000">*</samp></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Email:</td>
			<td colspan="4" align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="email" value="<?= $email ?>" type="text" style="width:420px"/><samp style="color:#FF0000">*</samp></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Data de Nascimento:</td>
			<td align="left" valign="middle">
			<input name="data_nasc" value="<?= $data_nasc ?>" type="text" /></td>
			<td align="right" valign="middle">Sexo:</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<select name="sexo" id="sexo">
			<option value="">.:SELECIONE:.</option>
			<option value="Masculino" <? if($sexo=='Masculino') echo 'selected'; ?>>Masculino</option>
			<option value="Feminino" <? if($sexo=='Feminino') echo 'selected'; ?>>Feminino</option>
			</select></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">RG:</td>
			<td align="left" valign="middle">
			<input name="rg" value="<?= $rg ?>" type="text" /></td>
			<td align="right" valign="middle">CPF:</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="cpf" value="<?= $cpf ?>" type="text" /></td>
			</tr>
			<tr>
			<td height="30" colspan="5" align="left" valign="middle" bgcolor="#95D8FF">DADOS PARA CONTATO</td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Tel residencial:</td>
			<td align="left" valign="middle">
			<input name="tel" value="<?= $tel ?>" type="text"/><samp style="color:#FF0000">*</samp></td>
			<td align="right" valign="middle">Tel comercial:</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="tel2" value="<?= $tel2 ?>" type="text" /></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Tel celular:</td>
			<td align="left" valign="middle">
			<input name="cel" value="<?= $cel ?>" type="text" /></td>
			<td align="right" valign="middle">&nbsp;</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">&nbsp;</td>
			</tr>
			<tr>
			<td height="30" colspan="5" align="left" valign="middle" bgcolor="#95D8FF">ENDERE&Ccedil;O PARA CONTATO</td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Rua/Av:</td>
			<td colspan="4" align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="endereco" value="<?= $endereco ?>" type="text" style="width:438px"/></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">N&ordm;:</td>
			<td align="left" valign="middle">
			<input name="numero" value="<?= $numero ?>" type="text" /></td>
			<td align="right" valign="middle">Complemento:</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="complemento" value="<?= $complemento ?>" type="text" /></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Bairro:</td>
			<td align="left" valign="middle">
			<input name="bairro" value="<?= $bairro ?>" type="text" /></td>
			<td align="right" valign="middle">Cidade:</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<input name="cidade" value="<?= $cidade ?>" type="text" /></td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Cep:</td>
			<td align="left" valign="middle">
			<input name="cep" value="<?= $cep ?>" type="text" /></td>
			<td align="right" valign="middle">Estado:</td>
			<td align="left" valign="middle">&nbsp;</td>
			<td align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<select name="estado" id="estado">
        	<?
			$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado ");
		
			while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['estado'].'"';
			
			if($estado==$res['estado']) echo 'selected="selected"'; 
			echo '>'.$res['estado'].'</option>';			
			}
		    ?>
			</select></td>
			</tr>
			<tr>
			<td height="30" colspan="5" align="left" valign="middle" bgcolor="#95D8FF">SELECIONE A REGIÃO DE INTERESSE</td>
			</tr>
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Estado de Interesse:</td>
			<td colspan="4" align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<select name="estado_interesse" onclick="carrega_cidades(this.value,'');">
			<option value="">UF</option>
        	<?
			$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado ");
		
			while($res = mysql_fetch_array($sql)){
			echo '<option value="'.$res['estado'].'"';
			
			if($estado_interesse==$res['estado']) echo 'selected="selected"'; 
			echo '>'.$res['estado'].'</option>';			
			}
		    ?>
			</select><samp style="color:#FF0000">*</samp></td>
			</tr>			
			<tr>
			<td height="30" align="right" valign="middle" style="border-left:1px solid #95D8FF">Cidade de Interesse:</td>
			<td colspan="4" align="left" valign="middle" style="border-right:1px solid #95D8FF">
			<select name="id_cidade_interesse" id="carrega_cidade">
			</select><samp style="color:#FF0000">*</samp>
			<script>
				carrega_cidades('<?= $estado_interesse ?>','<?= $id_cidade_interesse ?>');
			</script>
			</td>
			</tr>

			<tr>
			<td height="100" colspan="5" align="center" valign="middle" bgcolor="#FFFFFF" style="border-left:1px solid #95D8FF;border-right:1px solid #95D8FF"><strong>OBS:</strong><textarea name="obs" id="obs" cols="62" rows="5" ><?= $obs ?></textarea></td>
			</tr>
			<tr>
			<td height="30" colspan="5" align="center" valign="middle" bgcolor="#0071B6"><input name="submit1" type="submit" value="Cadastrar"/></td>
			</tr>
			</table>
			</form>
			
			<?
			}
			?>
			
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="600">
			<tr>
			<td align="center">
			<?
			if ($errors) {
			echo '<div class="respotas_erro">'.$error.'</div>';
			}
			?>
			
			<?
			if ($done) {
			echo '<div id="respotas_sucesso" style="font-size:16px">O cadastro foi efetuado com sucesso!</div>';
			
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