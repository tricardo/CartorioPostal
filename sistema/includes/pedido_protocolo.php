<?
$ext = explode(',',$_COOKIE['p_id_pedido']);
$ext_num = count ($ext)-1;
?>

            <form enctype="multipart/form-data" action="gera_protocolo.php" method="post" name="pedido_print" target="_blank">
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
                  <td colspan="4" class="tabela_tit"> Selecione o Modelo de Protocolo</td>
      </tr>

          <tr>
                  <td width="100"> <div align="right"><strong>Modelo: </strong></div></td>
      <td width="313" colspan="3">
        <select name="id_impresso" style="width:470px" class="form_estilo">
			<?
			
			$sql = $objQuery->SQLQuery("SELECT * from vsites_impresso as i where departamento = 'Protocolo' order by tipo_impresso");
    	    while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['id_impresso'].'">'.$res['tipo_impresso'].'</option>';	
			}
			?>
	        
        </select></td></tr>
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