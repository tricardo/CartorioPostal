<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

$atividadeDAO = new AtividadeDAO();
pt_register('POST','acao');

$id_status = ''; 
$dias      = '';

switch($acao){
    case 'acompanhar':
        $id_atividade = 120;
        $dias = 3; 
        break;
    case 'notificar':
        $id_atividade = 214;
        break;
    case 'notificado':
        $id_atividade = 215;
        $dias = 12;
        break;
    case 'apoio_juridico':
        $id_atividade = 216;
        break;
    case 'efetuado':
        $id_atividade = 119;
        $id_status = 10;
        break;
}
$atividade = $atividadeDAO->selecionaPorID($id_atividade); ?>
<div class="show-box-close" onclick="$('#dv_direcionamento_pedido').remove()">Fechar X</div>
<div class="content-forms">
    <?php CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'cobranca-listar.php'));">
        <h3>Atividade - Acompanhar</h3>
        <dl>
            <dt>Atividade:</dt>
            <dd class="line1"><?=utf8_encode($atividade->atividade); ?></dd>
            <dt>Observação:</dt>
            <dd class="line1 txta-h">
                <textarea name="status_obs" id="status_obs" placeholder="Observação"></textarea>
            </dd>
            <div class="buttons">
                <input type="hidden" name="id_atividade" id="id_atividade" value="<?php echo $id_atividade ?>">
                <input type="hidden" name="id_status" id="id_status" value="<?php echo $id_status ?>">
                <input type="hidden" name="dias" id="dias" value="<?php echo $dias ?>">
                <input type="hidden" id="acao_direcionamento" name="acao_direcionamento" value="<?=$acao?>">
                <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>
        aplicarClass();
        preencheCampo();
    </script>
</div>