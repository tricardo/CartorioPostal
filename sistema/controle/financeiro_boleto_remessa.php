<?
require('header.php');
$departamento_s = explode(',', $controle_id_departamento_s);
$departamento_p = explode(',', $controle_id_departamento_p);

$contaDAO = new ContaDAO();

$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}

pt_register("GET", "submit_form");
pt_register("GET", "id_conta");

if (isset($submit_form)) {

    $errors = array();

    if (empty($id_conta)) {
        $errors['id_conta'] = 1;
        $result .= "<li>O campo <strong>Banco</strong> é obrigatório.</li>";
    }

    if (count($errors) == 0) {
        if ($id_conta > 2) {
            echo "<script>location.href='financeiro_boleto_brasil.php?id=" . $id_conta . "';</script>";
        } else {
            echo "<script>location.href='financeiro_boleto_rem.php?id=" . $id_conta . "';</script>";
        }
    }

}


?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_rel.png" alt="Título"/>Gera Remessa</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit"/>
    </div>
    <div id="meio">
        <form method="GET" action="" name="form_auto" id="form_auto" enctype="multipart/form-data">
            <div id="retorno" style="position:relative;width:350px;margin:auto;border:solid 1px #0D357D;padding:1px">
                <table style="width:350px;border:0" class="tabela">
                    <tbody>
                    <tr>
                        <td class="tabela_tit">Lista de Bancos</td>
                    </tr>
                    <tr>
                        <td id="td_implantacao">
                            <label>Banco: </label>
                            <select name="id_conta" id="id_conta"
                                    class="form_estilo<? if ($errors['id_conta'] == 1) echo '_erro' ?>"
                                    style=" width:170px; ">
                                <option value="" selected>
                                    <?
                                    $contaDAO = new ContaDAO();
                                    $lista = $contaDAO->listarContaBoleto($controle_id_empresa);
                                    $p_valor = '';
                                    foreach ($lista as $l) {
                                        $p_valor .= '<option value="' . $l->id_conta . '"';
                                        if ($l->id_conta == $id_conta) $p_valor .= 'selected="select"';
                                        $p_valor .= '>' . $l->sigla . '</option>';
                                    }
                                    echo $p_valor;
                                    ?>
                            </select>
                            <br/>

                            <div style="text-align:center;width:100%">
                                <input type="submit" name="submit_form" value="Entrar"
                                       class="button_busca"/>&nbsp;
                                <input type="submit"
                                       onclick="document.form_auto.action='financeiro_boleto.php'"
                                       name="submit_form2" value="Voltar" class="button_busca"/>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
<?

if (count($errors) > 0) {
    ?>
    <br/>
    <div class="erro">
        <b>Ocorreram os seguintes erros:</b>
        <ul>

            <? echo $result; ?>
        </ul>
    </div>
<?
}
?>
<?php
require('footer.php');
?>