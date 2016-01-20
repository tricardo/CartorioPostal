<?
require('header.php');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);	

?>
<div style="margin:15px;">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">
    <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" /> Relatório de Comissão</h1>
    <hr class="tit"/><br />

<? 


    ?>

            <form enctype="multipart/form-data" action="gera_comissao_func.php" method="post" name="pedido_print" target="_blank">
              <center>
       <table width="650" class="tabela">
       <tr>
                  <td colspan="4" class="tabela_tit"> Comissão dos Funcionários</td>
      </tr>

          <tr>
                  <td width="100"> <div align="right"><strong>Período: </strong></div></td>
      <td width="313" colspan="3">
        <input type="text" name="datai" value="<?= date('d/m/Y'); ?> 00:00:00" /> a
        <input type="text" name="dataf" value="<?= date('d/m/Y'); ?> 23:59:00" />


        </td>
        </tr>



          <tr>
      <td colspan="4" align="center">
		<input type="submit" name="submit_gerar" value="Gerar" class="button_busca" />&nbsp; 
		<input type="submit" name="cancelar" value="Cancelar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='rels.php'" class="button_busca" />
		</td>
		</tr>
      </table>
                </center>
            </form>

</div>
<?php 
	require('footer.php');
?>

