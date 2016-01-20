<?
setcookie ("detran_id_pedido_item", $_COOKIE['p_id_pedido_item']);
setcookie ("detran_id_pedido", $_COOKIE['p_id_pedido']);

$ext = explode(',',$_COOKIE['p_id_pedido']);
$ext_num = count ($ext)-1;
?>

      <form enctype="multipart/form-data" action="gera_processos.php" method="post" name="pedido_print" target="_blank">
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
                  <td width="100"> <div align="right"><strong>Orgão: </strong></div></td>
      <td width="313" colspan="3">

        <input type="text" name="orgao" style="width:470px" value="DETRAN" class="form_estilo">

        </td></tr>
        <tr>
                  <td width="100"> <div align="right"><strong>Resultado da declaração: </strong></div></td>
      <td width="313" colspan="3">
       
        <input type="text" name="resultado" style="width:470px" value="Nada Constou" class="form_estilo">

        </td>
		</tr>
        <tr>
                  <td width="100"> <div align="right"></div></td>
      <td width="313" colspan="3">
		<input type="radio" name="anexar" value="" checked="checked">
		<strong>Apenas gerar o arquivo para download</strong>
        <input type="radio" name="anexar" value="on">
		<strong>Gerar arquivo e anexar</strong>
		

        </td>
		</tr>		
          <tr>
      <td colspan="4" align="center">
        <input type="submit" name="submit" value="Imprimir" class="button_busca" />&nbsp; <input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='pedido.php'" class="button_busca" /></td></tr>
      </table>
                </center>
            </form>
			</td>
</tr>
</table>  
</div>
<? #fim da alteração de status
require('footer.php');
		exit;
?>