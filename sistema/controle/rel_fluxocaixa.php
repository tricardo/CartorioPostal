<?php
require('header.php');
$dia = (int) date('d');
$mes = (int) date('m');
$ano = (int) date('Y');
?>
<div id="topo">
    <h1 class="tit">
        <img src="../images/tit/tit_cartorio.png" alt="T�tulo" />Relat�rio de Fluxo de Caixa</h1>
    <hr class="tit" />
    <br />
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="buscador" id="buscador" action="gera_exporta_fluxo.php" method="post" target="_blank">
                    <div style="width: 280px; position: relative">
                        <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Mes/Ano: </label>
                    <!-- <select name="dia" id="dia" class="form_estilo" style="width: 50px; float: left">
                        <?
                        $p_valor = '<option value="" >Todos</option>';
                        for ($i = 1; $i <= 31; $i++) {
                            if ($i < 10)
                                $i2 = '0' . $i; else
                                $i2 = $i;
                            $p_valor .= '<option value="' . $i2 . '" ';
                            if ($dia == $i)
                                $p_valor.= 'selected="select"';
                            $p_valor.='>' . $i2 . '</option>';
                        }
                        echo $p_valor;
                        ?>
                    </select> -->
                        <select name="mes" id="mes" class="form_estilo" style="width: 50px; float: left">
                            <?
                            $p_valor = '';
                            for ($i = 1; $i <= 12; $i++) {
                                if ($i < 10)
                                    $i2 = '0' . $i; else
                                    $i2 = $i;
                                $p_valor .= '<option value="' . $i2 . '" ';
                                if ($mes == $i)
                                    $p_valor.= 'selected="select"';
                                $p_valor.='>' . $i2 . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select> 
                        <select name="ano" id="ano" class="form_estilo" style="width: 50px; float: left">
                            <? for ($i = 2010; $i <= (int) date('Y'); $i++) { ?>
                                <option value="<?= $i ?>" <? if ($ano == $i)
                                echo 'selected="select"'; ?>><?= $i ?></option>
                            <? } ?>
                        </select> 
                        <label style="width: 120px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Banco: </label>
                        <select name="banco" id="banco" class="form_estilo" style="width: 150px; float: left">
                            <?
                            $contaDAO = new ContaDAO();
                            $contas = $contaDAO->listarConta($controle_id_empresa);
                            $p_valor = '<option value="" >Todos</option>';
                            foreach ($contas as $conta) {
                                $p_valor .= '<option value="' . $conta->sigla . '" >' . $conta->sigla . '</option>';
                            }
                            echo $p_valor;
                            ?>
                        </select> 
                        <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Atualiza Caixa: </label>
                        <select name="atualiza" id="atualiza" class="form_estilo" style="width: 150px; float: left">
                            <option value="1" >Sim</option>
                            <option value="" >N�o</option>
                        </select>			
                        <label style="width: 90px; font-weight: bold; padding-top: 5px; float: left; text-align: right">Caixa Anal�tico: </label>
                        <select name="analitico" id="analitico" class="form_estilo" style="width: 150px; float: left">
                            <option value="1" >Sim</option>
                            <option value="" selected>N�o</option>
                        </select>			
                        <input type="submit" name="submit" class="button_busca" style="float:left; margin-top:10px;" value=" Exportar " />
                    </div>
                </form>
            </td>
        </tr>
    </table>
    <br/><br/>
    <b>Observa��es:</b>
    <br/>- O relatrio acima mostra a movimenta��o financeira dos caixas;
    <br/>- As Sa�das s�o lan�andas na tela de desembolso e contas a pagar;
    <br/>- As Entradas s�o lan�andas na tela de recebimento e recebimento franquia;
</div>
<?php require('footer.php'); ?>
