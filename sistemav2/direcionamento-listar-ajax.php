<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

$atividadeDAO = new AtividadeDAO();


pt_register('POST','status');
if($_POST){ ?>

    <div class="show-box-close" onclick="$('#dv_direcionamento_pedido').remove()">Fechar X</div>
    <div class="content-forms">
        <?php CamposObrigatorios(); ?> 
        <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'direcionamento-listar.php'));">
            <h3>alterar status</h3>
            <dl>
                <dt>Atividade <span>*</span>:</dt>
                <dd class="line1">
                    <select name="acao_id_atividade" id="acao_id_atividade" class="chzn-select line1 required">
                        <?php $p_valor = "";
                        foreach($atividadeDAO->listaAtividades($controle_atividade) as $ati){
                            $p_valor .= '<option value="'.$ati->id_atividade.'" >'.utf8_encode($ati->atividade).'</option>';
                        }
                        echo $p_valor;  ?>
                    </select>
                </dd>
                <dt>Dias:</dt>
                <dd>
                    <input type="text" name="status_dias" id="status_dias" value="" placeholder="Dias" class="numero" onkeyup="RetData(this.id,1)">
                </dd>
                <dt>Hora:</dt>
                <dd>
                    <input type="text" name="status_hora" id="status_hora" value="" placeholder="Horas" class="hora">
                </dd>
                <dt>Data:</dt>
                <dd>
                    <input id="data_posdias" name="data_posdias" class="data" readonly="readonly" placeholder="Data">
                </dd>
                <dt>&nbsp;</dt>
                <dd>&nbsp;</dd>
                <dt>Observação:</dt>
                <dd class="line1 txta-h">
                    <textarea name="status_obs" id="status_obs" placeholder="Observação"></textarea>
                </dd>
                <div class="buttons">
                    <input type="hidden" id="acao_direcionamento" name="acao_direcionamento" value="alterar_senha">
                    <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
                </div>
            </dl>
        </form>
        <script>
            aplicarClass();
            preencheCampo();
        </script>
    </div>
    
<?php 
exit;
} ?><script>$('#dv_direcionamento_pedido').remove()</script>