<?
	header("Content-Type: text/html; charset=ISO-8859-1",true);
	include_once( "../includes/verifica_logado_ajax.inc.php");
	include_once( "../includes/funcoes.php" );
	include_once( "../includes/global.inc.php" );
	

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
	pt_register('GET','id_financeiro');
	pt_register('GET','id_pedido_item');
    if($id_financeiro<>'' and $id_pedido_item<>''){
	// Pesquisa ID localidade-----------------------------------		
		$sql 	= "SELECT f.*, uu.nome FROM vsites_financeiro as f, vsites_user_usuario as uu where f.id_pedido_item='$id_pedido_item' and f.id_financeiro='$id_financeiro' and f.financeiro_tipo='Recebimento' and f.id_usuario=uu.id_usuario";
		$query 	= $objQuery->SQLQuery($sql);
		$res = mysql_fetch_array($query);
		$nome			 			= $res['nome'];
		$financeiro_tipo 			= $res['financeiro_tipo'];
		$financeiro_data 			= $res['financeiro_data'];
		$financeiro_data = invert($financeiro_data,'/','php').' '.substr($res["financeiro_data"],11, 8);
		$financeiro_nossa_conta		= $res['financeiro_nossa_conta'];
		$financeiro_autorizacao 	= $res['financeiro_autorizacao'];
		$financeiro_autorizacao_data= $res['financeiro_autorizacao_data'];
		$financeiro_autorizacao_data = invert($financeiro_autorizacao_data,'/','php').' '.substr($res["financeiro_autorizacao_data"],11, 8);
		$financeiro_conferido 		= $res['financeiro_conferido'];
		$financeiro_classificacao	= $res['financeiro_classificacao'];
		$financeiro_banco 			= $res['financeiro_banco'];
		$financeiro_agencia			= $res['financeiro_agencia'];
		$financeiro_conta 			= $res['financeiro_conta'];
		$financeiro_identificacao	= $res['financeiro_identificacao'];
		$financeiro_favorecido		= $res['financeiro_favorecido'];
		$financeiro_cpf 			= $res['financeiro_cpf'];
		$financeiro_descricao 		= $res['financeiro_descricao'];
		$financeiro_desembolsado 	= $res['financeiro_desembolsado'];
		$financeiro_troco 			= $res['financeiro_troco'];
		$financeiro_data_p 			= $res['financeiro_data_p'];
		$financeiro_valor 			= number_format($res['financeiro_valor'],2,".","");
		$financeiro_forma 			= $res['financeiro_forma'];

?>   <form enctype="multipart/form-data" action="" method="post" name="pedido_financeiro_add">
     <table width="650" class="tabela">
	  <tr>
                  <td colspan="4" class="tabela_tit"> Recebimento <?= $financeiro_data.' - '.$nome ?></td>
      </tr>
          <tr>
                  <td width="150"> <div align="right"><strong>Conta: </strong></div></td>
      <td>
              <select name="financeiro_nossa_conta" style="width:150px" class="form_estilo">
			<?
			$p_valor = '<option value="'.$financeiro_nossa_conta.'">'.$financeiro_nossa_conta.'</option>';
			$contaDAO = new ContaDAO();
			$contas = $contaDAO->listarConta($controle_id_empresa);
			foreach($contas as $conta){
				$p_valor .= '<option value="'.$conta->sigla.'">'.$conta->sigla.'</option>';
			}
			echo $p_valor;

			?>
		</select><font color="#FF0000">*</font>

		</td>
		<td><div align="right"><b>Forma:</b></div></td>
		<td>
              <select name="financeiro_forma" style="width:150px" class="form_estilo">
                <option value=""   <? 	if($financeiro_forma=='') echo ' selected="select"'; ?>></option>
				<option value="Dinheiro"   <? 	if($financeiro_forma=='Dinheiro') echo ' selected="select"'; ?>>Dinheiro</option>
                <option value="Cheque"     <? 	if($financeiro_forma=='Cheque') echo ' selected="select"'; ?>>Cheque</option>
                <option value="Boleto"     <? 	if($financeiro_forma=='Boleto') echo ' selected="select"'; ?>>Boleto</option>
                <option value="Depósito"   <? 	if($financeiro_forma=='Depósito') echo ' selected="select"'; ?>>Depósito</option>
                <option value="C. Correio" <? 	if($financeiro_forma=='C. Correio') echo ' selected="select"'; ?>>Vale Postal</option>
                <option value="Dinheiro Certo" <? 	if($financeiro_forma=='Dinheiro Certo') echo ' selected="select"'; ?>>Dinheiro Certo</option>
                <option value="Malote"     <? 	if($financeiro_forma=='Malote') echo ' selected="select"'; ?>>Malote</option>
        	</select><font color="#FF0000">*</font>
			  
        </td>
          </tr>

          <tr>
                  <td width="150"> <div align="right"><strong>Classificação: </strong></div></td>
      <td colspan="3">
              <select name="financeiro_classificacao" style="width:450px" class="form_estilo">
      <?
      	$sql = $objQuery->SQLQuery("SELECT * from vsites_classificacao  where recebimento='1' order by classificacao");
		while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_classificacao'].'"';
				if($financeiro_classificacao==$res['id_classificacao']) echo ' selected="select"';
                echo ' >'.$res['classificacao'].'</option>';
		}
	  ?>	</select><font color="#FF0000">*</font>

		</td>
          </tr>

          <tr>
                  <td width="150"> <div align="right"><strong>Identificação: </strong></div></td>
      <td>
            <input type="text" class="form_estilo" name="financeiro_identificacao" value="<?= $financeiro_identificacao ?>" style="width:150px" />

		</td>
		<td>
		 <div align="right"><strong>Data de Rec.: </strong></div>
		 </td>
		<td>
         <input type="text" class="form_estilo" name="financeiro_data_p" value="<?= invert($financeiro_data_p,'/','PHP') ?>" onKeyUp="masc_numeros(this,'##/##/####');" style="width:150px" />
        </td>
          </tr>

           <tr>
                  <td width="150"> <div align="right"><strong>Descrição: </strong></div></td>
      <td colspan="3">
            <input type="text" class="form_estilo" name="financeiro_descricao" value="<?= $financeiro_descricao ?>" style="width:450px" /><font color="#FF0000">*</font>

		</td>

          </tr>
          <tr>
                  <td width="150"> <div align="right"><strong>Valor: </strong></div></td>
      <td>
            <input type="text" class="form_estilo" id="financeiro_valor_edit" <? if($permissao == 'FALSE' and $financeiro_autorizacao!='Pedente') echo 'readonly="readonly"'; ?> onkeyup="moeda(event.keyCode,this.value,'financeiro_valor_edit');" name="financeiro_valor" value="<?= $financeiro_valor ?>" style="width:150px" /><font color="#FF0000">*</font><br> Forma ####.##


		</td>
         <td></td>
            <td>
            <div class="form_estilo" style="width:150px">
             <input type="checkbox" name="financeiro_conferido" <? if($financeiro_conferido=='on') echo 'checked="checked"'; ?>/><b>Conferido </b>
            </div>


		</td>
          </tr>
          


          <tr>
                  <td width="150"> <div align="right"><b>Autorização: </b></div></td>
      <td>

          <input type="text" class="form_estilo" name="financeiro_autorizacao_data" readonly="readonly" value="<?= $financeiro_autorizacao ?>" style="width:150px" />
         </td>
         <td><div align="right">
            <b>Data da Autorização: </b></div></td>
            <td>
            <input type="text" class="form_estilo" name="financeiro_autorizacao_data" readonly="readonly" value="<?= $financeiro_autorizacao_data ?>" style="width:150px" />

		</td>

          </tr>
          <tr>
      <td colspan="4">
            <center>            <input type="hidden" name="financeiro_old_autorizacao" value="<?= $financeiro_autorizacao ?>" />
			<input type="hidden" name="id_financeiro" value="<?= $id_financeiro ?>" />
            <input type="submit" class="button_busca" name="submit_financeiro_edit_r" value="Atualizar" />&nbsp;<input type="submit" class="button_busca" name="submit_financeiro_edit_r_d" value="Remover" /></center>

		</td>

          </tr>
          </table>
            </form>
		     <? } ?>
