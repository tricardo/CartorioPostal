<?
require('header.php');

$permissao = verifica_permissao('Empresa', $controle_id_departamento_p, $controle_id_departamento_s);
if ($controle_id_empresa != 1) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}

pt_register('GET', 'busca');
pt_register('GET', 'pagina');
$correioDAO = new CorreioDAO();
$empresaDAO = new EmpresaDAO();
if ($controle_id_empresa != 1)
    $id_empresa = $controle_id_empresa;
else
    pt_register('GET', 'id_empresa');
$lista = $correioDAO->listar($id_empresa, $busca, $pagina);
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_conta.png" alt="Título" /> Agências dos Correios</h1>
    <hr class="tit" />
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="buscador" action="" method="get" ENCTYPE="multipart/form-data">
                    <div>
                        <label>Buscar: </label>
                        <input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" size="30" /> 
                        <? if ($controle_id_empresa == 1) { ?>
                            <label>Franquia: </label>
                            <select name="id_empresa" class="form_estilo" style="width:200px">
                                <option></option>
                                <?php
                                $emp = $empresaDAO->listarTodasFranquias();
                                foreach ($emp as $l) {
                                    ?>
                                    <option value="<?= $l->id_empresa; ?>"<?= ($id_empresa == $l->id_empresa) ? 'selected="selected"' : '' ?>><?= $l->fantasia; ?></option>
                                <?php } ?>
                            </select>
                        <? } ?>
                        <input type="submit" name="submit" class="button_busca" value=" Buscar " />
                    </div>
                </form>
                <br />

                <a href="correio_add.php">
                    <h3><img src="../images/botao_add.png" border="0" /> Adicionar novo	registro</h3>
                </a> <br />
                <table cellpadding="4" cellspacing="1" class="result_tabela">
                    <tr>
                        <td class="result_menu"><b>Franquia</b></td>
                        <td class="result_menu"><b>Nome</b></td>
                        <td align="center" width="80" class="result_menu"><b>Data do Cartaz</b></td>
                        <td align="center" class="result_menu" width="80"><b>Status</b></td>
                        <td align="center" width="80" class="result_menu"><b>Editar</b></td>
                    </tr>

                    <?php
                    foreach ($lista as $l) {
                        if ($l->status == 1)
                            $status = 'Ativo'; else
                            $status = 'Cancelado';
                        ?>
                        <tr>
                            <td class="result_celula"><?= $l->fantasia ?></td>
                            <td class="result_celula"><?= $l->nome ?></td>
                            <td class="result_celula"><?= invert($l->data_cartaz, '/', 'PHP') ?></td>
                            <td class="result_celula"><?= $status ?></td>
                            <td class="result_celula" align="center">
                                <a	href="correio_edit.php?id=<?= $l->id_agcorreios; ?>">
                                    <img src="../images/botao_editar.png" title="Editar" border="0" />
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="9" class="barra_busca">
                            <? $correioDAO->QTDPagina(); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<?php
require('footer.php');
?>