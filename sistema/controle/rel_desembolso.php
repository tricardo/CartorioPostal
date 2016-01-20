<?
require('header.php');
$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="T�tulo" /> Relat�rio de Desembolso</h1>
    <hr class="tit" />
</div>   
<div id="meio">
    <table border="0" height="100%" width="100%" >
        <tr>
            <td valign="top">
                <form enctype="multipart/form-data" action="gera_desembolso_anal.php" method="post" name="pedido_print" target="_blank">
                    <center>
                        <table width="650" class="tabela">
                            <tr>
                                <td colspan="4" class="tabela_tit"> Depósito por banco</td>
                            </tr>
                            <tr>
                                <td width="100"> <div align="right"><strong>Per�odo: </strong></div></td>
                                <td width="313" colspan="3">
                                    <input type="text" name="datai" value="<?= date('d/m/Y'); ?> 00:00:00" /> a
                                    <input type="text" name="dataf" value="<?= date('d/m/Y'); ?> 23:59:00" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input type="submit" name="submit_analitico" value="Anal�tico" onclick="document.pedido_print.action='gera_desembolso_anal.php'"class="button_busca" />&nbsp;
                                    <input type="submit" name="submit_sintetico" value="Sint�tico" onclick="document.pedido_print.action='gera_desembolso_sint.php'" class="button_busca" />&nbsp; 
                                    <input type="submit" name="cancelar" value="Voltar" onclick="document.pedido_print.target='_self'; document.pedido_print.action='rels.php'" class="button_busca" />
                                </td>
                            </tr>
                        </table>
                    </center>
                </form>
                <br/><br/><br/>
                <b>Observa��es:</b>
                <br/>- O relat�rio acima mostra apenas os desembolsos realizados em dep�sito;
                <br/>- A fun��o desse relat�rio � agrupar os desembolsos por banco;
                <br/>- A diferen�a do Analitico � a linha com a descri��o do desembolso.
            </td>
        </tr>
    </table>
</div>
<?php
require('footer.php');
?>