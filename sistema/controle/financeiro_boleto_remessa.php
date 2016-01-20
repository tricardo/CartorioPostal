<?
require('header.php');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$contaDAO = new ContaDAO();

$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
    echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
    exit;
}
?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_rel.png" alt="T�tulo"/>Gera Remessa</h1>
        <hr class="tit"/>
    </div>
    <div id="meio">
        <center>
        <table border="0" height="100%" width="100%">
            <tr>
                <td valign="top">
                    <table cellpadding="4" cellspacing="1" class="result_tabela">
                        <tr>
                            <td align="center" class="result_menu"><b>Banco</b></td>
                            <td align="center" width="60" class="result_menu"><b>Visualizar</b></td>
                        </tr>
                        <tr>
                            <td class="result_celula" nowrap>Banco Bradesco</td>
                            <td class="result_celula" align="center" nowrap>
                                <a href="financeiro_boleto_rem.php"><img src="../images/botao_editar.png" title="Editar"
                                                                  border="0"/></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="result_celula" nowrap>Banco do Brasil</td>
                            <td class="result_celula" align="center" nowrap>
                                <a href="financeiro_boleto_brasil.php"><img src="../images/botao_editar.png" title="Editar"
                                                                  border="0"/></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </center>
    </div>
<?php
require('footer.php');
?>