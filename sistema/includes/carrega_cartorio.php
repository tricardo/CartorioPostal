<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	pt_register('GET','id_cartorio');
		


	$sql = $objQuery->SQLQuery("SELECT * from vsites_cartorio where id_cartorio='" . $id_cartorio . "'");
	$res = mysql_fetch_array($sql);
	$nome			= $res['nome'];
	$fantasia		= $res['fantasia'];
	$tipo			= $res['tipo'];
	$cpf			= $res['cpf'];
	$rg				= $res['rg'];
	$endereco		= $res['endereco'];
	$cidade			= $res['cidade'];
	$estado			= $res['estado'];
	$bairro			= $res['bairro'];
	$cep			= $res['cep'];
	$numero			= $res['numero'];
	$complemento	= $res['complemento'];
	$distrito		= $res['distrito'];
	$comarca		= $res['comarca'];
	$contato		= $res['contato'];
	$tel			= $res['tel'];
	$cel			= $res['cel'];
	$ramal			= $res['ramal'];
	$fax			= $res['fax'];
	$email			= $res['email'];
	$site			= $res['site'];
	$status			= $res['status'];
	$banco			= $res['banco'];
	$cod_banco		= $res['cod_banco'];
	$agencia		= $res['agencia'];
	$conta			= $res['conta'];
	$favorecido		= $res['favorecido'];
	$atribuicao		= $res['atribuicao'];
	$tel2			= $res['tel2'];
	$ramal2			= $res['ramal2'];
	$obs			= $res['obs'];
	$valor_busca	= $res['valor_busca'];
	$valor_certidao	= $res['valor_certidao'];
?>

<table width="100%" border="0" cellpadding="10" cellspacing="0">
	<tr>
		<td valign="top" align="center">

          <blockquote>

               <table width="650" class="tabela">
<tr>
                  <td colspan="4" class="tabela_tit"> Dados do Cartório</td>
      </tr>
                <tr>
                  <td width="100"> <div align="right"><strong>Status:</strong></div></td>
      <td width="243">
          <select name="status" class="form_estilo" style="width:150px">
              <option value="Ativo" <? if($status=='Ativo') echo 'selected="selected"'; ?>>Ativo</option>
              <option value="Inativo" <? if($status=='Inativo') echo 'selected="selected"'; ?>>Inativo</option>
              <option value="Cancelado" <? if($status=='Cancelado') echo 'selected="selected"'; ?>>Cancelado</option>
            </select>
      </td>
      <td width="70"></td>
      <td width="219">
        </td>
    </tr>
                <tr>
                <td> <div align="right"><strong>Nome: </strong></div></td>
      <td colspan="3">
        <input type="text" name="nome" value="<?= $nome ?>" style="width:470px" class="form_estilo"/>
        <font color="#FF0000">*</font></td></tr>
<tr>
                  <td> <div align="right"><strong>Fantasia: </strong></div></td>
      <td colspan="3">
        <input type="text" name="fantasia" value="<?= $fantasia ?>" style="width:470px" class="form_estilo">
		<font color="#FF0000">*</font>
		</td></tr>
                <tr>
                  <td> <div align="right"><strong>CNPJ: </strong></div></td>
      <td>
      <input type="hidden" name="tipo" value="cnpj" />
        <div id="cpf" style="float:left"></div>
				<script type="text/javascript">
					carrega_cpf('cnpj', '<?= $cpf ?>');
				</script>
        </td>
      <td><div align="right"><strong>IE: </strong></div></td>
      <td><input type="text" name="rg" value="<?= $rg ?>" style="width:150px" class="form_estilo" /></td>
        </tr>
<tr>
                  <td> <div align="right"><strong>Contato: </strong></div></td>
      <td colspan="3">
        <input type="text" name="contato" value="<?= $contato ?>" style="width:470px" class="form_estilo"></td></tr>
        <tr>
     <td><div align="right"><strong>Tel / Ramal: </strong></div></td>
      <td><input type="text" name="tel" value="<?= $tel ?>" style="width:150px" onKeyUp="masc_numeros(this,'(##) ####-####');" class="form_estilo" />
      -
      <input type="text" name="ramal" value="<?= $ramal ?>" style="width:50px" class="form_estilo"/></td>
      <td> <div align="right"><strong>Cel: </strong></div></td>
      <td><input type="text" name="cel" value="<?= $cel ?>" style="width:150px" onKeyUp="masc_numeros(this,'(##) ####-####');" class="form_estilo"/></td>
        </tr>
<tr>
     <td><div align="right"><strong>Tel / Ramal: </strong></div></td>
      <td><input type="text" name="tel2" value="<?= $tel2 ?>" style="width:150px" onkeyup="masc_numeros(this,'(##) ####-####');" class="form_estilo" />
-
  <input type="text" name="ramal2" value="<?= $ramal2 ?>" style="width:50px" class="form_estilo"/></td>
      <td> <div align="right"><strong>Fax: </strong></div></td>
      <td><input type="text" name="fax" value="<?= $fax ?>" style="width:150px" onkeyup="masc_numeros(this,'(##) ####-####');" class="form_estilo" /></td>
</tr>
                <tr>
                  <td> <div align="right"><strong>Email: </strong></div></td>
      <td colspan="3">
        <input type="text" name="email" value="<?= $email ?>" style="width:470px" class="form_estilo"/></td></tr>
               <tr>
                  <td> <div align="right"><strong>Site: </strong></div></td>
      <td colspan="3">
        <input type="text" name="site" value="<?= $site ?>" style="width:470px" class="form_estilo"/></td>
               </tr>
<tr>
                  <td> <div align="right"><strong>Comarca: </strong></div></td>
      <td colspan="3">
        <input type="text" name="comarca" value="<?= $comarca ?>" style="width:470px" class="form_estilo"></td></tr>
<tr>
                  <td> <div align="right"><strong>Distrito: </strong></div></td>
      <td colspan="3">
        <input type="text" name="distrito" value="<?= $distrito ?>" style="width:470px" class="form_estilo"></td></tr>
<tr>
                  <td> <div align="right"><strong>Atribuição: </strong></div></td>
      <td colspan="3">
          <select name="atribuicao" class="form_estilo" style="width:150px">
          	<?
          	$sql = $objQuery->SQLQuery("SELECT * from vsites_cartorio_atribuicoes order by atribuicao");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_atribuicao'].'" ';
				if($id_atribuicao==$res['id_atribuicao']) echo ' selected="selected"';
				echo '>'.$res['atribuicao'].'</option>';
			}
			?>
           </select>

        </td></tr>
               <tr>
                  <td> <div align="right"><strong>Valor da Busca: </strong></div></td>
      <td>
        <input type="text" name="valor_busca" style="width:200px" value="<?= $valor_busca ?>" class="form_estilo"/></td>
                  <td> <div align="right"><strong>Valor da Certidão:</strong></div></td>
      <td>
        <input type="text" name="valor_certidao" style="width:150px" value="<?= $valor_certidao ?>" class="form_estilo"/></td>
        </tr>
<tr>
                  <td colspan="4" class="tabela_tit"> Endereço</td>
      </tr>
                <tr>
      <td><div align="right"><strong>CEP: </strong></div></td>
      <td colspan="3"><input type="text" name="cep" style="width:150px" value="<?= $cep ?>" class="form_estilo" onKeyUp="masc_numeros(this,'#####-###');" onblur="carrega_endedeco(this.value, 'cartorio_edit');" />
        <font color="#FF0000">*</font> </td>
				</tr>
                <tr>
                  <td> <div align="right"><strong>Endere&ccedil;o: </strong></div></td>
      <td colspan="3">
        <input type="text" name="endereco" value="<?= $endereco ?>" style="width:350px" class="form_estilo"/>
        <strong>N&deg;</strong>
        <input type="text" name="numero" style="width:95px" value="<?= $numero ?>" class="form_estilo"/></td>
                </tr>
                <tr>
                  <td> <div align="right"><strong>Complemento: </strong></div></td>
      <td>
        <input type="text" name="complemento" style="width:200px" value="<?= $complemento ?>" class="form_estilo"/></td>
                  <td> <div align="right"><strong>Bairro:</strong></div></td>
      <td>
        <input type="text" name="bairro" style="width:150px" value="<?= $bairro ?>" class="form_estilo"/></td>
        </tr>

                <tr>
                  <td> <div align="right"><strong>Cidade: </strong></div></td>
      <td>
        <input type="text" name="cidade" style="width:200px" value="<?= $cidade ?>" class="form_estilo"/>
        <input type="hidden" name="id" value="<?= $id ?>"/>
        <input type="hidden" name="old_login" value="<?= $login ?>"/></td>
                  <td> <div align="right"><strong>Estado:</strong></div></td>
      <td>
        <input type="text" name="estado" style="width:150px" value="<?= $estado ?>" class="form_estilo" maxlength="2"/></td>
        </tr>
       <tr>
        	<td colspan="4" class="tabela_tit"> Dados Bancários</td>
	    </tr>
                <tr>
                  <td> <div align="right"><strong>Banco: </strong></div></td>
      <td>
        <input type="text" name="banco" style="width:200px" value="<?= $banco ?>" class="form_estilo"/></td>
                  <td> <div align="right"><strong>Código:</strong></div></td>
      <td>
        <input type="text" name="cod_banco" style="width:150px" value="<?= $cod_banco ?>" class="form_estilo"/></td>
        </tr>
                <tr>
                  <td> <div align="right"><strong>Agência: </strong></div></td>
      <td>
        <input type="text" name="agencia" style="width:200px" value="<?= $agencia ?>" class="form_estilo"/></td>
                  <td> <div align="right"><strong>C/C:</strong></div></td>
      <td>
        <input type="text" name="conta" style="width:150px" value="<?= $conta ?>" class="form_estilo"/></td>
        </tr>
                <tr>
                  <td> <div align="right"><strong>Favorecido: </strong></div></td>
      <td colspan="3">
        <input type="text" name="favorecido" style="width:470px" value="<?= $favorecido ?>" class="form_estilo"/>
        <input type="hidden" name="id" value="<?= $id ?>"/></td>
        </tr>
       <tr>
        	<td colspan="4" class="tabela_tit"> Observações</td>
	    </tr>
                <tr>
                  <td valign="top"> <div align="right"><strong>Obs: </strong></div></td>
      <td colspan="3">
        <textarea name="obs" class="form_estilo" style="width:470px; height:150px"><?= $obs ?></textarea></td>
        </tr>
              </table>
              <div id="resgata_endereco"></div>

      </blockquote></td>
</tr>
</table>
</div>
