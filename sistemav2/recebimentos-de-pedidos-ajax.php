<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

pt_register('POST','acao');
pt_register('POST','id');

$validacaoCLASS = new ValidacaoCLASS();
$contaDAO = new ContaDAO();
$financeiroDAO = new FinanceiroDAO();

?>

<div class="show-box-close" onclick="$('#dv_rec_pedido').remove()">Fechar X</div>
<?php
    switch($acao){
        case 'boleto': 
            $permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
            if($permissao == 'FALSE'){
                RetornaVazio(3,'Você não tem permissão para acessar essa página"');
                exit;
            } 
            $p = new stdClass();
            $p->id_fatura=$id;
            $p->tipo='1';
            $p->ocorrencia='1';
            $p->emissao_papeleta='2';
            $p->especie='12';
            $p->aceite='N';
            
            
            ?>
            <div class="content-forms">
                <?php CamposObrigatorios(); ?> 
                <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'recebimentos-de-pedidos.php'));">
                    <h3>novo boleto</h3>   
                    <dl>
                        <dt>Banco <span>*</span>:</dt>
                        <dd>
                            <select name="id_conta" id="id_conta" class="chzn-select required">
				<?php
				$p_valor = '';
				foreach($contaDAO->listarContaBoleto($controle_id_empresa) as $l){
                                    $p_valor .= '<option value="'.$l->id_conta.'">'.$l->sigla.'</option>';
				}
				echo $p_valor; ?>
                            </select>
                        </dd>
                        <dt>Fatura:</dt>
                        <dd>
                            <input type="text" readonly="readonly" id="id_fatura" name="id_fatura" value="<?= $id ?>" placeholder="Fatura">
                        </dd>
                        <dt>Nota:</dt>
                        <dd>
                            <input type="text" id="id_nota" name="id_nota" class="numero" placeholder="Nota">
                        </dd>
                        <dt>Tipo</dt>
                        <dd>
                            <select name="tipo" id="tipo" class="chzn-select">
                                <option value="1">CPF</option>
                                <option value="2">CNPJ</option>
                                <option value="98">Não Tem</option>
                                <option value="99">Outros</option>
                            </select>
                        </dd>
                        <dt>CPF/CNPJ <span>*</span>:</dt>
                        <dd>
                            <input type="text" id="cpf" name="cpf" class="cpf required" required="required" placeholder="CPF/CNPJ">
                        </dd>
                        <dt>Sacado <span>*</span>:</dt>
                        <dd>
                            <input type="text" id="sacado" name="sacado" required="required" class="required" placeholder="Sacado">
                        </dd>
                        
                        <dt>Endereço:</dt>
                        <dd>
                            <input type="text" id="endereco" name="endereco" class="required"required="required" placeholder="Endereço">
                        </dd>	
                        <dt>Bairro:</dt>
                        <dd>
                            <input type="text" id="bairro" name="bairro" class="required" required="required" placeholder="Bairro">
                        </dd>
                        <dt>CEP <span>*</span>:</dt>
                        <dd>
                            <input type="text" name="cep" id="cep" class="cep required" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')" required>
                        </dd>
                        <dt>Cidade: </dt>
                        <dd>
                            <input type="text" id="cidade" name="cidade" class="required" required="required" placeholder="Cidade">
                        </dd>
                        <dt>Estado <span>*</span>:</dt>
                        <dd>
                            <select class="chzn-select required" name="estados" id="estados">
                                <?php $estado = UFs();
                                for($i = 0; $i < count($estado); $i++){ ?>
                                        <option value="<?=$estado[$i]?>" <?=($estado[$i] == $emp->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                                <?php } ?>
                            </select>
                        </dd>	
                        <dt>&nbsp;</dt>
                        <dd>&nbsp;</dd>
                        <dt>Vencimento <span>*</span>:</dt>
                        <dd>
                            <input type="text" id="vencimento" name="vencimento" class="data required" required="required" placeholder="Vencimento">
                        </dd>
                        <dt>Valor <span>*</span>:</dt>
                        <dd>
                            <input type="text" id="valor" name="valor" class="money required" required="required" placeholder="Valor">
                        </dd>
                        <dt>Mora Diária:</dt>
                        <dd>
                            <input type="text" id="juros_mora" name="juros_mora" class="money" placeholder="Mora Diária">
                        </dd>
                        <dt>Ocorrência:</dt>
                        <dd>
                            <select name="ocorrencia" id="ocorrencia" class="chzn-select">
				<option value="1" selected="select">Remessa</option>
                            </select>
                        </dd>
                        <dt>Instrução 1:</dt>
                        <dd>
                            <select name="instrucao1" id="instrucao1" class="chzn-select" onchange="$('#instrucao2').val(this.value != 6 ? '' : 5);">
				<option value="" >Instrução 1</option>
				<option value="6">Protestar</option>
				<option value="8">Não cobrar juros de mora</option>
				<option value="9">Não receber após o vencimento</option>
				<option value="11">Não receber após o 8º dia do vencimento</option>
				<option value="12">Cobrar encargos após o 5º dia do vencimento</option>
				<option value="13">Cobrar encargos após o 10º dia do vencimento</option>
				<option value="14">Cobrar encargos após o 15º dia do vencimento</option>
                            </select>
                        </dd>
                        <dt>Mensagem 1:</dt>
                        <dd>
                            <input type="text" id="mensagem1" name="mensagem1" placeholder="Mensagem 1">
                        </dd>
                        <dt>Instrução 2:</dt>
                        <dd>
                            <input type="text" id="instrucao2" name="instrucao2" class="numero" placeholder="Instrução 2">
                        </dd>
                        <dt>Mensagem 2:</dt>
                        <dd>
                            <input type="text" id="mensagem2" name="mensagem2" placeholder="Mensagem 2">
                        </dd>
                        <dt>Emitir Papeleta <span>*</span>:</dt>
                        <dd>
                            <select name="emissao_papeleta" id="emissao_papeleta" class="chzn-select required">
				<option value="1">Pelo Banco</option>
				<option value="2">Pela Empresa</option>                            
                            </select>
                        </dd>
                        <dt>Espécie <span>*</span>:</dt>
                        <dd>
                            <select name="especie" id="especie" class="chzn-select required">
				<option value="1">Duplicata</option>
				<option value="2">Nota Promissória</option>
				<option value="3">Nota de Seguro</option>
				<option value="4">Cobrança Seriada</option>
				<option value="5">Recibo</option>
				<option value="10">Letras de Câmbio</option>
				<option value="11">Nota de Débito</option>
				<option value="12">Duplicata de Serv.</option>
				<option value="99">Outros</option>
                            </select>
                        </dd>
                        <dt>Aceite <span>*</span>:</dt>
                        <dd>
                            <select name="aceite" id="aceite" class="chzn-select required">
				<option value="A">A</option>
				<option value="N">N</option>
                            </select>
                        </dd>
                        <div class="buttons">
                            <input type="hidden" id="acao_rec_pedido" name="acao_rec_pedido" value="boleto">
                            <input type="hidden" name="id_fatura" id="id_fatura" value="<?= isset($id) ? $id : 0 ?>"> 
                            <input type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
                        </div>
                    </dl>
                </form>
                <script>
                    aplicarClass();
                    preencheCampo();
                </script>
            </div>

         <?php break;
        case 'faturar':
            if(count($_SESSION['rec_pedido']) == 0){
                RetornaVazio(3,'Você deve selecionar pelo menos um Pedido para Faturar!');
                exit;
            }
            sort($_SESSION['rec_pedido']);
            $fat_fatura = $financeiroDAO->buscaRecebimentoItem($_SESSION['rec_pedido'][0]);
            $fat_fatura = count($fat_fatura) > 0 ? UTF_Encodes($fat_fatura[0]) : '';
            
            if($fat_fatura == ''){
                RetornaVazio(3,'Você deve selecionar pelo menos um Pedido para Faturar!');
                exit;
            }
            
            
            $arr = array($_SESSION['rec_pedido'][0]);
            $ordem = array('#'.$fat_fatura->id_pedido.'/'.$fat_fatura->ordem);
            for($i = 0; $i < count($_SESSION['rec_pedido']); $i++){
                if($i > 0){
                    $teste = $financeiroDAO->buscaRecebimentoItem($_SESSION['rec_pedido'][$i]);
                    if(count($teste) > 0 AND $teste[0]->cpf == $fat_fatura->cpf){
                        $arr[] = $_SESSION['rec_pedido'][$i];
                        $ordem[] = '#'.$teste[0]->id_pedido.'/'.$teste[0]->ordem;
                    }        
                }
            }
            $_SESSION['rec_pedido'] = $arr;
            #print_r($fat_fatura);
            
            ?>
            <div class="content-forms">
                <?php CamposObrigatorios(); ?> 
                <form enctype="multipart/form-data" method="post" id="form2" onsubmit="$('#form2').attr('action',($('#NoStatusCheck').length > 0 ? $('#NoStatusCheck').val() : 'recebimentos-de-pedidos.php'));">
                    <h3>faturar</h3>   
                    <dl>
                        <dt>Ordem:</dt>
                        <dd class="line1 txta-h" style="height: auto">
                            <?=implode(',',$ordem)?>.
                        </dd>
                        <dt>Banco <span>*</span>:</dt>
                        <dd>
                            <select name="id_conta" id="id_conta" class="chzn-select required">
				<?php
				$p_valor = '';
				foreach($contaDAO->listarContaBoleto($controle_id_empresa) as $l){
                                    $p_valor .= '<option value="'.$l->id_conta.'">'.$l->sigla.'</option>';
				}
				echo $p_valor; ?>
                            </select>
                        </dd>
                        <dt>Sacado <span>*</span>:</dt>
                        <dd>
                            <input value="<?= $fat_fatura->sacado ?>" type="text" id="sacado" name="sacado" required="required" class="required" placeholder="Sacado">
                        </dd>
                        
                        <dt>Endereço:</dt>
                        <dd>
                            <input value="<?= $fat_fatura->endereco ?>" type="text" id="endereco" name="endereco" class="required"required="required" placeholder="Endereço">
                        </dd>	
                        <dt>Bairro:</dt>
                        <dd>
                            <input value="<?= $fat_fatura->bairro ?>" type="text" id="bairro" name="bairro" class="required" required="required" placeholder="Bairro">
                        </dd>
                        <dt>CEP <span>*</span>:</dt>
                        <dd>
                            <input value="<?= $fat_fatura->cep ?>" type="text" name="cep" id="cep" class="cep required" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')" required>
                        </dd>
                        <dt>Cidade: </dt>
                        <dd>
                            <input value="<?= $fat_fatura->cidade ?>" type="text" id="cidade" name="cidade" class="required" required="required" placeholder="Cidade">
                        </dd>
                        <dt>Estado <span>*</span>:</dt>
                        <dd>
                            <select class="chzn-select required" name="estados" id="estados">
                                <?php $estado = UFs();
                                for($i = 0; $i < count($estado); $i++){ ?>
                                        <option value="<?=$estado[$i]?>" <?=($estado[$i] == $fat_fatura->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                                <?php } ?>
                            </select>
                        </dd>	
                        <dt>&nbsp;</dt>
                        <dd>&nbsp;</dd>
                        <dt>Vencimento <span>*</span>:</dt>
                        <dd>
                            <input value="<?= $fat_fatura->vencimento ?>" type="text" id="vencimento" name="vencimento" class="data required" required="required" placeholder="Vencimento">
                        </dd>
                        <dt>Mora Diária:</dt>
                        <dd>
                            <input value="<?= $fat_fatura->juros_mora ?>" type="text" id="juros_mora" name="juros_mora" class="money" placeholder="Mora Diária">
                        </dd>
                         <dt>Instrução 1:</dt>
                        <dd>
                            <select name="instrucao1" id="instrucao1" class="chzn-select" onchange="$('#instrucao2').val(this.value != 6 ? '' : 5);">
				<option value="" >Instrução 1</option>
				<option value="6">Protestar</option>
				<option value="8">Não cobrar juros de mora</option>
				<option value="9">Não receber após o vencimento</option>
				<option value="11">Não receber após o 8º dia do vencimento</option>
				<option value="12">Cobrar encargos após o 5º dia do vencimento</option>
				<option value="13">Cobrar encargos após o 10º dia do vencimento</option>
				<option value="14">Cobrar encargos após o 15º dia do vencimento</option>
                            </select>
                        </dd>
                        <dt>Mensagem 1:</dt>
                        <dd>
                            <input type="text" id="mensagem1" name="mensagem1" placeholder="Mensagem 1">
                        </dd>
                        <dt>Instrução 2:</dt>
                        <dd>
                            <input type="text" id="instrucao2" name="instrucao2" class="numero" placeholder="Instrução 2">
                        </dd>
                        <dt>Mensagem 2:</dt>
                        <dd>
                            <input type="text" id="mensagem2" name="mensagem2" placeholder="Mensagem 2">
                        </dd>
                        <dt>Emitir Papeleta <span>*</span>:</dt>
                        <dd>
                            <select name="emissao_papeleta" id="emissao_papeleta" class="chzn-select required">
				<option value="1">Pelo Banco</option>
				<option value="2">Pela Empresa</option>                            
                            </select>
                        </dd>
                        <dt>Espécie <span>*</span>:</dt>
                        <dd>
                            <select name="especie" id="especie" class="chzn-select required">
				<option value="1">Duplicata</option>
				<option value="2">Nota Promissória</option>
				<option value="3">Nota de Seguro</option>
				<option value="4">Cobrança Seriada</option>
				<option value="5">Recibo</option>
				<option value="10">Letras de Câmbio</option>
				<option value="11">Nota de Débito</option>
				<option value="12">Duplicata de Serv.</option>
				<option value="99">Outros</option>
                            </select>
                        </dd>
                        <dt>Aceite <span>*</span>:</dt>
                        <dd>
                            <select name="aceite" id="aceite" class="chzn-select required">
				<option value="A">A</option>
				<option value="N">N</option>
                            </select>
                        </dd>
                        <dt>&nbsp;</dt>
                        <dd>&nbsp;</dd>
                        <?php foreach($financeiroDAO->listaPedidoIn2(implode(',',$_SESSION['rec_pedido']),$controle_id_empresa) AS $l){ 
                            $custa_l = $financeiroDAO->somaPedidoItemDesembolso($l->id_pedido_item,$controle_id_empresa); ?>
                            <dt>Pedido:</dt>
                            <dd><?='#'.$l->id_pedido.'/'.$l->ordem?></dd>
                            <dt>Honorário:</dt>
                            <dd>
                                <input type="text" name="fin_valor<?=$l->id_pedido_item?>" value="<?=$l->valor?>" id="fin_valor<?=$l->id_pedido_item?>" class="money" placeholder="Honorário">
                            </dd>
                            <dt>Custas:</dt>
                            <dd>
                                <input type="text" name="fin_custa<?=$l->id_pedido_item?>" value="<?=$custa_l->total?>" id="fin_custa<?=$l->id_pedido_item?>" class="money" placeholder="Custas">
                            </dd>
                            <dt>Recebido:</dt>
                            <dd>
                                <input type="text" name="fin_rec<?=$l->id_pedido_item?>" value="<?=$l->valor_rec?>" id="fin_rec<?=$l->id_pedido_item?>" class="money" placeholder="Honorário">
                            </dd>
                            <dt>&nbsp;</dt>
                            <dd>&nbsp;</dd>
                            <dt>&nbsp;</dt>
                            <dd>&nbsp;</dd>
                        <?php } ?>
                        <div class="buttons">
                            <input type="hidden" id="acao_rec_pedido" name="acao_rec_pedido" value="faturar">
                            <input type="submit" value="guardar valores &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro" style="width: auto">
                        </div>
                    </dl>
                </form>
                <script>
                    aplicarClass();
                    preencheCampo();
                </script>
            </div>
<?php break;
    }
