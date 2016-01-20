<?
setcookie ("eti_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie ("eti_id_pedido", $_COOKIE['p_id_pedido']);

$ext = explode(',',$_COOKIE['p_id_pedido']);
$ext_num = count ($ext)-1;
?>

            <form enctype="multipart/form-data" action="gera_etiqueta.php" method="post" name="pedido_print" target="_blank">
              <center>
       <table width="650" class="tabela">
	  <tr>
                  <td colspan="4" class="tabela_tit"> Ordens Selecionadas</td>
      </tr>
	  <tr>
                  <td colspan="4">
      <?= str_replace(',',' - ',$_COOKIE['p_id_pedido']); ?>
	  <br><br><b>Foram selecionados <?= $ext_num ?> pedidos.</b>				  
				  </td>
      </tr>
          <tr>
                  <td width="150"> <div align="right"><strong>Coluna: </strong></div></td>
      <td>
			<select name="coluna" style="width:150px" class="form_estilo">
				<option value="0" >1</option>
                <option value="1" >2</option>
        	</select>

		</td>
		<td><div align="right"><b>Linha:</b></div></td>
		<td>
              <select name="linha" style="width:150px" class="form_estilo">			  
				<option value="0" >1</option>
				<option value="1" >2</option>
				<option value="2" >3</option>
				<option value="3" >4</option>
				<option value="4" >5</option>
				<option value="5" >6</option>
				<option value="6" >7</option>
				<option value="7" >8</option>
				<option value="8" >9</option>
				<option value="9" >10</option>
				<option value="10" >11</option>
				<option value="11" >12</option>
        	</select>
        </td>
          </tr>
          <tr>
      <td colspan="4" align="center">
        <input type="submit" name="submit" value="Gerar" class="button_busca" />&nbsp; <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='pedido.php'" class="button_busca" /></td></tr>
      </table>
                </center>
            </form>
<? #fim da alteração de status
		exit;
?>