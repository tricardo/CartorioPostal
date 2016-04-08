<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

$contaDAO = new ContaDAO();
$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();

pt_register('POST','acao');
if($_POST){
    $financeiroverificaDAO = new FinanceiroVerificaDAO();
    $financeiro_valor_rec = 0;
    
    if(isset($_SESSION) AND isset($_SESSION['fi_franquia']) AND is_array($_SESSION['fi_franquia']) AND
        count($_SESSION['fi_franquia']) > 0){
        for($i = 0; $i < count($_SESSION['fi_franquia']); $i++){
            if(isset($_SESSION['fi_franquia'][$i]) AND strlen($_SESSION['fi_franquia'][$i]) > 0){
                $items = explode(';',$_SESSION['fi_franquia'][$i]);
                if(count($items) == 2 AND strlen($items[0]) > 0 AND strlen($items[1]) > 0){ 
                    $ret = $financeiroverificaDAO->verificaAprovaPedidoLista($items[0], $controle_id_empresa);
                    if(count($ret) > 0){
                        $valor_rec = $ret->valor_rec;
                        $financeiro_valor = $ret->financeiro_valor;
                        $financeiro_valor = ($valor_rec < $financeiro_valor) ? (float) ($financeiro_valor) - (float) ($valor_rec) : ''; 
                        $financeiro_valor_rec = (float) ($financeiro_valor_rec) + (float) ($financeiro_valor);
                        $financeiro_valor_rec = number_format($financeiro_valor_rec, 2, '.', '');
                    }
                }
            }
        }
    }
    
    ?>
    <div class="show-box-close" onclick="$('#dv_recoutras').remove()">Fechar X</div>
    <div class="content-forms">
        <?php CamposObrigatorios(); ?> 
        <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'direcionamento-listar.php'));">
            <h3>aprovar royalties</h3>
            <dl>
                <dt>conta <span>*</span>:</dt>
                <dd>
                    <select name="financeiro_nossa_conta" id="financeiro_nossa_conta" class="chzn-select required">
                        <?php $p_valor='';                       
                        foreach($contaDAO->listarConta($controle_id_empresa) as $l){
                            $p_valor .= '<option value="'.utf8_encode($l->sigla).'" >'.utf8_encode($l->sigla).'</option>';
                        }
                        echo $p_valor; ?>
                    </select>
                </dd>
                <dt>Forma <span>*</span>:</dt>
                <dd>
                    <select name="financeiro_forma" id="financeiro_forma" class="chzn-select required">
                        <?php $p_valor = "";
                        foreach($financeiroDAO->listarForma() as $f){
                            $p_valor .='<option value="'.$f->forma_2.'" '.(($financeiro_forma==$f->forma_2) ? ' selected ' : '').'>'.utf8_encode($f->forma).'</option>';
                        }
                        echo $p_valor; ?>                  
                    </select>
                </dd>
                <dt>Classificação <span>*</span>:</dt>
                <dd>
                    <select name="financeiro_classificacao" id="financeiro_classificacao" class="chzn-select required">
                        <?php foreach($financeiroDAO->listarClassificacaoRec() as $l){
                                echo '<option value="'.$l->id_classificacao.'" >'.utf8_encode($l->classificacao).'</option>';
                        } ?>
                    </select>
                </dd>
                <dt>Identificação:</dt>
                <dd>
                    <input type="text" name="financeiro_identificacao" id="financeiro_identificacao" placeholder="Identificação">
                </dd>
                <dt>Data de Rec. <span>*</span>:</dt>
                <dd>
                    <input type="text" class="data required" required="required" name="financeiro_data_p" id="financeiro_data_p" placeholder="Data de Rec.">
                </dd>
                <dt>Valor <span>*</span>:</dt>
                <dd>
                    <input type="text" class="money required" <?=$financeiro_valor_rec?> required="required" name="financeiro_valor_ff" id="financeiro_valor_ff" placeholder="Valor">
                </dd>
                <dt>Descrição:</dt>
                <dd>
                    <input type="text" name="financeiro_descricao" id="financeiro_descricao" placeholder="Descrição">
                </dd>
                <div class="buttons">
                    <input type="hidden" id="acao_direcionamento" name="acao_direcionamento" value="aprovar">
                    <input type="submit" value="aprovar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
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
} ?><script>$('#dv_recoutras').remove()</script>