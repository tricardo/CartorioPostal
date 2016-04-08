<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

$contaDAO = new ContaDAO();
$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();

pt_register('POST','acao');
if($_POST){ ?>
    <div class="show-box-close" onclick="$('#dv_royalties').remove()">Fechar X</div>
    <?php switch($acao){
        case 'aprovar': ?>
            
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
                            <dt>Descrição:</dt>
                            <dd>
                                <input type="text" name="financeiro_descricao" id="financeiro_descricao" placeholder="Descrição">
                            </dd>
                        </dl>
                        <h3>Unidades</h3>
                        <dl class="box">
                            <table class="table1">
                                <thead>
                                    <tr>
                                        <th>unidade</th>
                                        <th>data ref.</th>
                                        <th>royalties</th>
                                        <th>fpp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $color = '#FFFEEE';
                                    $total_r = 0; $total_f = 0; 
                                    for($i = 0; $i < count($_SESSION['royalties']); $i++){
                                        $dt = $financeiroDAO->RoyEmpresa($_SESSION['royalties'][$i]);
                                        if(count($dt) > 0){
                                            $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  

                                            $roy = $dt[0]->valor_royalties;
                                            if($dt[0]->roy_rec > 0){
                                                $roy = '0.00';
                                                if($dt[0]->roy_rec < $dt[0]->valor_royalties){
                                                    $roy = $dt[0]->valor_royalties - $dt[0]->roy_rec;
                                                }
                                            }
                                            $fpp = $dt[0]->valor_propaganda;
                                            if($dt[0]->fpp_rec > 0){
                                                $fpp = '0.00';
                                                if($dt[0]->fpp_rec < $dt[0]->valor_propaganda){
                                                    $fpp = $dt[0]->valor_propaganda - $dt[0]->fpp_rec;
                                                }
                                            }
                                            $total_r = $total_r + (float)$roy;
                                            $total_f = $total_f + (float)$fpp;
                                            ?>
                                            <tr <?=TRColor($color)?>>
                                                <td><?=utf8_encode($dt[0]->fantasia)?></td>
                                                <td><?=$dt[0]->ref?></td>
                                                <td><input name="roy<?=$_SESSION['royalties'][$i]?>" id="roy<?=$_SESSION['royalties'][$i]?>" type="text" class="money" value="<?=number_format((float)$roy, 2, '.', '')?>" placeholder="Royaltie"></td>
                                                <td><input name="fpp<?=$_SESSION['royalties'][$i]?>" id="fpp<?=$_SESSION['royalties'][$i]?>" type="text" class="money" value="<?=number_format((float)$fpp, 2, '.', '')?>" placeholder="FPP"></td>
                                            </tr>
                                    <?php }} ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th><?= number_format((float)$total_r, 2, '.', '')?></th>
                                        <th><?= number_format((float)$total_f, 2, '.', '')?></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th colspan="2"><?= number_format((float)($total_f+$total_r), 2, '.', '')?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </dl>
                        <dl>
                            <div class="buttons">
                                <input type="hidden" id="acao_direcionamento" name="acao_direcionamento" value="aprovar">
                                <input type="submit" value="lançar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
                            </div>
                        </dl>
                    </form>
                    <script>
                        aplicarClass();
                        preencheCampo();
                    </script>
                </div>
                <?php break;
        case 'listar': 
            $permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
            if($permissao == 'FALSE' or $controle_id_empresa!=1){
                echo "<script>RoyaltiesConfirm(0,'erro',0);$('#dv_royalties').remove()</script>";
                exit;
            }
            pt_register('POST','bt_emp');
            pt_register('POST','bt_ref'); ?>
            <div class="content-list-table">
                <table>
                    <thead>
                        <tr>
                            <th class="buttons size100">recebimento</th>
                            <th class="buttons size100">valor recebido</th>
                            <th>forma</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $color = '#FFFEEE';
                        foreach($financeiroDAO->recebimentoRoy($bt_ref,$bt_emp) AS $r){
                            $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  ?>
                            <tr <?=TRColor($color)?>>
                                <td class="buttons size100"><?=$r->financeiro_data_p?></td>
                                <td class="buttons size100"><?=number_format((float)($r->financeiro_valor), 2, '.', '')?></td>
                                <td><?=utf8_encode($r->financeiro_forma)?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
<?php                 break;
    }
exit;
} ?><script>$('#dv_royalties').remove()</script>

