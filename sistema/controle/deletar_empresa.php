<?
require('header.php');
$permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
pt_register('GET', 'busca');
pt_register('GET', 'pagina');
?>
<div id="topo">
    <h1 class="tit"><img src="../images/tit/tit_empresa.png" alt="Título" /> Franquias</h1>
    <a href="#" class="topo">topo</a> 
    <hr class="tit" />
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="buscador" action="" method="get"  ENCTYPE="multipart/form-data">
                    <div>
                        <input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" size="30" /> 
                        <input type="submit" name="submit" class="button_busca" value=" Buscar " />
                    </div>
                </form>
                <br />
                <?
                $permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
                if ($permissao == 'TRUE') {
                ?> 
                    <a href="empresa_add.php">
                        <h3><img src="../images/botao_add.png" border="0" /> Adicionar novo registro</h3>
                    </a>
                <? } ?> <br />
                <table width="100%" cellpadding="4" cellspacing="1" class="result_tabela">
                    <tr>
                        <td class="result_menu"><b>Responsável</b></td>
                        <td class="result_menu"><b>Franquia</b></td>
                        <td align="center" width="80" class="result_menu"><b>Usuários</b></td>
                        <td align="center" width="80" class="result_menu"><b>Status</b></td>
                        <td align="center" width="80" class="result_menu"><b>Editar</b></td>
                        <td align="center" width="80" class="result_menu"><b>Mensagens</b></td>
                        <? if ($controle_depto_p[28] == 1) { ?>
                            <td align="center" width="80" class="result_menu"><b>Monitoramento</b></td>
                        <? } ?>
                    </tr>
                    <?php
                    $empresaDAO = new EmpresaDAO();
                    $empresas = $empresaDAO->listar($busca, $pagina);

                    foreach ($empresas as $empresa) {
                        $usuarios = $empresaDAO->getQntUsuarios($empresa->id_empresa);
                        ?>

                        <tr>
                            <td class="result_celula"><?= $empresa->nome . ' - ' . $empresa->email ?></td>
                            <td class="result_celula"><?= str_replace('Cartório Postal - ', '', $empresa->fantasia) ?></td>
                            <td class="result_celula" align="center">
                                <a href="usuario.php?id_empresa=<?= $empresa->id_empresa ?>">
                                    <img src="../images/icon/icon_cliente.png" alt="Título" border="0" />
                                </a>
                                <?= $usuarios ?>
                            </td>
                            <td class="result_celula" align="center"><?= $empresa->status ?></td>
                            <td class="result_celula" align="center">
                                <a href="empresa_edit.php?id=<?= $empresa->id_empresa ?>">
                                    <img src="../images/botao_editar.png" title="Editar" border="0" />
                                </a>
                            </td>
                            <td class="result_celula" align="center">
                                <a href="empresa_msg.php?id_empresa=<?= $empresa->id_empresa ?>"><img src="../images/botao_editar.png" title="Mensagens" border="0" /></a>
                            </td>
                            <? if ($controle_depto_p[28] == 1) { ?>
                                <td class="result_celula" align="center">
                                    <a href="login_vai_admin.php?login=<?= str_replace('@cartoriopostal.com.br', '', str_replace('diretoria.', '', $empresa->email)) ?>"><img src="../images/botao_editar.png" title="Mensagens" border="0" /></a>
                                </td>
                            <? } ?>
                        </tr>
                    <? } ?>
                    <tr>
                        <td colspan="10" class="barra_busca"><? $empresaDAO->QTDPagina(); ?>
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