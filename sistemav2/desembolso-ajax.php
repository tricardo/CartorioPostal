<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

pt_register('POST','acao');
pt_register('POST','pedido');
pt_register('POST','servico');
pt_register('POST','acao');
pt_register('POST','item');
pt_register('POST','financeiro');
$financeiroDAO = new FinanceiroDAO(); 
?>
<div class="show-box-close" onclick="$('#dv_desembolso_pedido').remove()">Fechar X</div>
    <?php
    switch($acao){
        case 'view': ?>
            <div class="content-list-table"> 
                <table>
                    <thead>
                        <tr>
                            <th colspan="6">desembolsos</th>
                        </tr>        
                        <tr>
                            <th>data</th>
                            <th>status</th>
                            <th>descrição</th>
                            <th class="buttons size100">custas</th>
                            <th class="buttons size100">correio</th>
                            <th class="buttons size100">honorários</th>
                        </tr>          
                    </thead>
                    <tbody>
                        <?php
                        $color = '#FFFEEE';
                        $listar = $financeiroDAO->desembolso_view($item, $controle_id_empresa);
                        if(count($listar) > 0){
                        foreach($listar AS $res){ 
                            $res = ObjToArray($res); ?>    
                            <tr <?=TRColor($color)?>>
                                <td><?=invert($res['financeiro_data'],'/','php').'<br>'.utf8_encode($res['nome'])?></td>
                                <td><?=utf8_encode($res['financeiro_autorizacao'])?></td>
                                <td><?=utf8_encode($res['financeiro_conta'].'-'.$res['financeiro_favorecido'].'<br>'.$res['financeiro_descricao'])?></td>
                                <td class="buttons size100"><?=number_format((float)($res['financeiro_valor']),2,".","")?></td>
                                <td class="buttons size100"><?=number_format((float)($res['financeiro_sedex']),2,".","")?></td>
                                <td class="buttons size100"><?=number_format((float)($res['financeiro_rateio']),2,".","")?></td>
                            </tr>
                        <?php }} else { ?>
                            <tr>
                                <td colspan="6"><?=RetornaVazio()?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
    <?php break; 
    
        case 'form':             
            $item =isset($item) ? $item : 0;
            $financeiro = isset($financeiro) ? $financeiro : 0;
            $res = $financeiroDAO->desembolso_form($item, $financeiro);
            if($financeiro > 0 and $item > 0 and count($res) > 0){ 
                $res = ObjToArray(UTF_Encodes($res[0]));
                $nome			 			= $res['nome'];
                $financeiro_tipo 			= $res['financeiro_tipo'];
                $financeiro_data 			= $res['financeiro_data'];
                $financeiro_data = invert($financeiro_data,'/','php').' '.substr($res["financeiro_data"],11, 8);
                $financeiro_nossa_conta		= $res['financeiro_nossa_conta'];
                $financeiro_autorizacao 	= $res['financeiro_autorizacao'];
                $financeiro_autorizacao_data= $res['financeiro_autorizacao_data'];
                $financeiro_autorizacao_data = invert($financeiro_autorizacao_data,'/','php').' '.substr($res["financeiro_autorizacao_data"],11, 8);
                $financeiro_conferido 		= $res['financeiro_conferido'];
                $financeiro_classificacao	= $res['financeiro_classificacao'];
                $financeiro_banco 			= $res['financeiro_banco'];
                $financeiro_agencia			= $res['financeiro_agencia'];
                $financeiro_conta 			= $res['financeiro_conta'];
                $financeiro_identificacao	= $res['financeiro_identificacao'];
                $financeiro_favorecido		= $res['financeiro_favorecido'];
                $financeiro_cpf 			= $res['financeiro_cpf'];
                $financeiro_descricao 		= $res['financeiro_descricao'];
                $financeiro_desembolsado 	= $res['financeiro_desembolsado'];
                $financeiro_troco 			= $res['financeiro_troco'];
                $financeiro_valor 			= number_format((float)($res['financeiro_valor']),2,".","");
                $financeiro_sedex			= number_format((float)($res['financeiro_sedex']),2,".","");
                $financeiro_rateio 			= number_format((float)($res['financeiro_rateio']),2,".","");
                $financeiro_forma 			= $res['financeiro_forma'];
                
                
                
                ?>
            <div class="content-forms">
                <?php CamposObrigatorios(); ?> 
                <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'desembolso-listar.php'));">
                    <h3>Desembolso <?= $financeiro_data.' - '.$nome ?></h3>
                    <dl>
                        <dt>Conta <span>*</span>:</dt>
                        <dd>
                            <select name="financeiro_nossa_conta" id="financeiro_nossa_conta" class="chzn-select required">
                                <option value="<?=$financeiro_nossa_conta?>"><?=strlen($financeiro_nossa_conta) == 0 ? 'Conta' : utf8_encode($financeiro_nossa_conta)?></option>
                                    <?php $contaDAO = new ContaDAO();
                                    $contas = $contaDAO->listarConta($controle_id_empresa);
                                    foreach($contas as $conta){
                                            $p_valor .= '<option value="'.utf8_encode($conta->sigla).'">'.utf8_encode($conta->sigla).'</option>';
                                    }
                                    echo $p_valor; ?>
                            </select>
                        </dd>
                        <dt>Forma <span>*</span>:</dt>
                        <dd>
                            <select name="financeiro_forma" id="financeiro_forma" class="chzn-select required">
                                <option value=""<?php if($financeiro_forma=='') echo ' selected="select"'; ?>>FORMA</option>
                                <option value="Dinheiro"<?php if($financeiro_forma=='Dinheiro') echo ' selected="select"'; ?>>Dinheiro</option>
                                <option value="Cheque"<?php if($financeiro_forma=='Cheque') echo ' selected="select"'; ?>>Cheque</option>
                                <option value="Boleto"<?php if($financeiro_forma=='Boleto') echo ' selected="select"'; ?>>Boleto</option>
                                <option value="Depósito"<?php if($financeiro_forma=='Depósito') echo ' selected="select"'; ?>>Depósito</option>
                                <option value="C. Correio"<?php if($financeiro_forma=='C. Correio') echo ' selected="select"'; ?>>Vale Postal</option>
                                <option value="Dinheiro Certo"<?php if($financeiro_forma=='Dinheiro Certo') echo ' selected="select"'; ?>>Dinheiro Certo</option>
                                <option value="Malote"<?php if($financeiro_forma=='Malote') echo ' selected="select"'; ?>>Malote</option>
                            </select>
                        </dd>
                        <dt>Classificação <span>*</span>:</dt>
                        <dd>
                            <select name="financeiro_classificacao" id="financeiro_classificacao" class="chzn-select required">
                                <?php
                                foreach($financeiroDAO->classificacao() AS $f){
                                    echo '<option value="'.$f->id_classificacao.'"';
                                    echo ($financeiro_classificacao==$f->id_classificacao) ? ' selected="select"' : '';
                                    echo ' >'.utf8_encode($f->classificacao).'</option>';                                    
                                }
                                ?>
                            </select>
                        </dd>
                         <dt>Banco:</dt>
                        <dd>
                            <select name="financeiro_banco" id="financeiro_banco" class="chzn-select">
                                <?php
                                $bancoDAO = new BancoDAO();
                                foreach($bancoDAO->listar() AS $f){
                                    echo '<option value="'.$res['id_banco'].'"';
                                    echo ($financeiro_banco==$f->id_banco) ? ' selected="select"' : '';
                                    echo ' >'.utf8_encode($f->banco).'</option>';                                   
                                }
                                ?>
                            </select>
                        </dd>
                        <dt>Agência:</dt>
                        <dd>
                            <input type="text" name="financeiro_agencia" id="financeiro_agencia" value="<?= $financeiro_agencia ?>" placeholder="Agência">
                        </dd>
                        <dt>Conta:</dt>
                        <dd>
                            <input type="text" name="financeiro_conta" id="financeiro_conta" value="<?= $financeiro_conta ?>" placeholder="Conta">
                        </dd>
                        <dt>Identificação:</dt>
                        <dd>
                            <input type="text" name="financeiro_identificacao" id="financeiro_identificacao" value="<?= $financeiro_identificacao ?>" placeholder="Identificação">
                        </dd>
                        <dt>CPF/CNPJ:</dt>
                        <dd>
                            <input type="text" name="financeiro_cpf" id="financeiro_cpf" value="<?= $financeiro_cpf ?>" placeholder="CPF/CNPJ" class="cpf">
                        </dd>
                        <dt>Favorecido:</dt>
                        <dd>
                            <input type="text" name="financeiro_favorecido" id="financeiro_favorecido" value="<?= $financeiro_favorecido ?>" placeholder="Favorecido">
                        </dd>
                        <dt>Descrição:</dt>
                        <dd>
                            <input type="text" name="financeiro_descricao" id="financeiro_descricao" value="<?= $financeiro_descricao ?>" placeholder="Descrição">
                        </dd>
                        <dt>Custas:</dt>
                        <dd>
                            <input class="money" type="text" name="financeiro_valor" id="financeiro_valor" value="<?= $financeiro_valor ?>" placeholder="Custas">
                        </dd>
                        <dt>Conferido:</dt>
                        <dd class="checks">
                            <input  id="financeiro_conferido" name="financeiro_conferido[]" type="checkbox"<?=($financeiro_conferido=='on') ? 'checked="checked"' : '';?> onclick="DesembolsoConferido()">
                            <span>Sim</span>
                        </dd>
                        <dt>Correio:</dt>
                        <dd>
                            <input class="money" type="text" name="financeiro_sedex" id="financeiro_sedex" value="<?= $financeiro_sedex ?>" placeholder="Correio">
                        </dd>
                        <dt>Honorários:</dt>
                        <dd>
                            <input class="money" type="text" name="financeiro_rateio" id="financeiro_rateio" value="<?= $financeiro_rateio ?>" placeholder="Honorários">
                        </dd>
                        <?php $permissao = verifica_permissao('Financeiro Pedido Edit',$controle_id_departamento_p,$controle_id_departamento_s);
                        if($permissao == 'TRUE'){ ?>
                            <dt>Desembolsado <span>*</span>:</dt>
                            <dd>
                                <input class="money" type="text" name="financeiro_desembolsado" id="financeiro_desembolsado" <?php
                                $permissao = verifica_permissao('Financeiro Desembolsado',$controle_id_departamento_p,$controle_id_departamento_s);
                                if($permissao == 'FALSE'){
                                    echo ' readonly="readonly" ';
                                    } ?> value="<?= $financeiro_desembolsado ?>" placeholder="Desembolsado">
                            </dd>
                            <dt>Troco:</dt>
                            <dd>
                                <input class="money" type="text" name="financeiro_troco" id="financeiro_troco" value="<?= $financeiro_troco ?>" placeholder="Troco">
                            </dd>
                            <dt>Autorização</dt>
                            <dd>
                                <select name="financeiro_autorizacao" id="financeiro_autorizacao" class="chzn-select">
                                        <option value="Pendente"<?php if($financeiro_autorizacao=='Pendente') echo ' selected="select"'; ?>>Pendente</option>
                                        <option value="Aprovado"<?php if($financeiro_autorizacao=='Aprovado') echo ' selected="select"'; ?>>Aprovado</option>
                                        <option value="Reprovado"<?php if($financeiro_autorizacao=='Reprovado') echo ' selected="select"'; ?>>Reprovado</option>
                                </select>
                            </dd>
                            <dt>Data da Autorização:</dt>
                            <dd>
                                <input type="text" class="data" name="financeiro_autorizacao_data" id="financeiro_autorizacao_data" readonly="readonly" value="<?= $financeiro_autorizacao_data ?>" placeholder="Data da Autorização">
                            </dd>
                        <?php } else { ?>
                            <dt><b>Desembolsado:</dt>
                            <dd>
                                <input type="text" class="money" id="financeiro_desembolsado" name="financeiro_desembolsado" value="<?= $financeiro_desembolsado ?>" placeholder="Desembolsado">
                            </dd>
                            <dt>Troco:</dt>
                            <dd>
                                <input type="text" class="money" id="financeiro_troco" name="financeiro_troco" value="<?= $financeiro_troco ?>" placeholder="Troco">
                            </dd>
                            <dt>Autorização</dt>
                            <dd>
                                <input type="text" name="financeiro_autorizacao" readonly="readonly" value="<?= $financeiro_autorizacao ?>">
                            </dd>
                            <dt>Data da Autorização:</dt>
                            <dd>
                                <input type="text" name="financeiro_autorizacao_data" readonly="readonly" value="<?= $financeiro_autorizacao_data ?>">
                            </dd>
                        <?php } ?>
                        <div class="buttons">
                            <input type="hidden" name="financeiro_old_autorizacao" id="financeiro_old_autorizacao" value="<?= $financeiro_autorizacao ?>"> 
                            <input type="hidden" name="id_financeiro" id="id_financeiro" value="<?= $financeiro ?>"> 
                            <input type="hidden" name="id_pedido_item" id="id_pedido_item" value="<?= $item ?>">
                            <input type="hidden" id="acao_desembolso" name="acao_desembolso" value="solicitar">
                            <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
                        </div>
                    </dl>
                </form>
                <script>
                    aplicarClass();
                    preencheCampo();
                </script>
            </div>
    
    
<?php }
          break;
    
          
        case 'conta':
            $contaDAO = new ContaDAO(); ?>
             <div class="content-forms">
                <?php CamposObrigatorios(); ?> 
                <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'desembolso-listar.php'));">
                    <h3>alterar conta</h3>
                    <dl>
                        <dt>Conta <span>*</span>:</dt>
                        <dd class="line1">
                            <select name="financeiro_nossa_conta" id="financeiro_nossa_conta" class="chzn-select required line1">
                                <?php $contaDAO = new ContaDAO();
                                $contas = $contaDAO->listarConta($controle_id_empresa);
                                foreach($contas as $conta){
                                    $p_valor .= '<option value="'.utf8_encode($conta->sigla).'">'.utf8_encode($conta->sigla).'</option>';
                                }
                                echo $p_valor; ?>
                            </select>
                        </dd>
                        <dt>Pedidos:</dt>
                        <dd class="line1 txta-h"><?php
                            if(isset($_SESSION['desembolso']) AND count($_SESSION['desembolso']) > 0){ 
                                for($i = 0; $i < count($_SESSION['desembolso']); $i++){
                                    $items = explode(';', $_SESSION['desembolso'][$i]);
                                    echo '#'.$items[2].'/'.$items[3];
                                    echo ($i < count($_SESSION['desembolso'])-1) ? ', ' : '';
                                }
                            } else { echo '&nbsp;'; }
                        ?></dd>
                        <div class="buttons">
                            <input type="hidden" id="acao_desembolso" name="acao_desembolso" value="alterar_conta">
                            <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
                        </div>
                    </dl>
                </form>
                <script>
                    aplicarClass();
                    preencheCampo();
                </script>
        <?php    break;
    } ?>