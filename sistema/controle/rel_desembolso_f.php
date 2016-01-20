<?
require('header.php');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);	

$permissao = verifica_permissao('Financeiro_rel',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_id_usuario!='46'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
?>
<div style="margin:15px;">
<table border="0" height="100%" width="100%" >
<tr>
	<td valign="top">
    <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" /> Relatório de Direcionamento de pedidos por franquia</h1>
    <hr class="tit"/><br />

<? 


    ?>

            <form enctype="multipart/form-data" action="" method="post" name="pedido_print" target="_blank">
              <center>
       <table width="650" class="tabela">
       <tr>
                  <td colspan="4" class="tabela_tit"> Direcionamento por franquia</td>
      </tr>

          <tr>
                  <td width="100"> <div align="right"><strong>Período: </strong></div></td>
      <td width="313" colspan="3">
        <input type="text" name="datai" value="<?= date('d/m/Y'); ?> 00:00:00" /> a
        <input type="text" name="dataf" value="<?= date('d/m/Y'); ?> 23:59:00" /><br>
		<input type="radio" name="enviados" value="Enviado" checked /> Pedidos enviados para outra franquia (Comissões e Custas à Pagar)<br>
		<input type="radio" name="enviados" value="" /> Pedidos recebidos de franquia (Comissões e Custas à Receber)<br>

        </td>
        </tr>



          <tr>
      <td colspan="4" align="center">
        <input type="submit" name="submit_analitico" value="Comissão" onclick="document.pedido_print.action='gera_sint_f_com.php'"class="button_busca" />&nbsp;
		<input type="submit" name="submit_sintetico" value="Desembolso" onclick="document.pedido_print.action='gera_sint_f.php'" class="button_busca" />&nbsp; 
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

