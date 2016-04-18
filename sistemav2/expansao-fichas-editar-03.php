<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=3" <?=$travar?>>
    <h3>informações bancárias</h3>
    <dl>
        <dt>Banco:</dt>
        <dd>
            <input type="text" maxlength="60" id="banco" name="banco" value="<?=$c->banco?>" placeholder="Banco">
        </dd>

        <dt>Cartão de Crédito:</dt>
        <dd>
            <input type="text" maxlength="40" id="cartao_credito" name="cartao_credito" value="<?=$c->cartao_credito?>" placeholder="Cartão de Crédito">
        </dd>

        <dt>Vencimento:</dt>
        <dd>
            <input type="text" maxlength="7" id="vencimento" name="vencimento" value="<?=$c->vencimento?>" placeholder="Vencimento">
        </dd>
            
        <dt>Limite:</dt>
        <dd>
            <input type="text" id="limite" name="limite" value="<?=$c->limite?>" maxlength="14" placeholder="Limite">
        </dd>
            
        <dt>Nome do Gerente:</dt>
        <dd class="line1">
            <input type="text" id="nome_gerente" name="nome_gerente" value="<?=$c->nome_gerente?>" maxlength="50" placeholder="Nome do Gerente" class="line1">
        </dd>

        <dt>Agência e Conta:</dt>
        <dd>
            <input type="text" maxlength="25" id="agencia_conta" name="agencia_conta" value="<?=$c->agencia_conta?>" placeholder="Agência e Conta">
        </dd>
            
        <dt>Telefone:</dt>
        <dd>
            <input type="text" maxlength="14" id="telefone_banco" name="telefone_banco" value="<?=$c->telefone_banco?>" placeholder="Telefone" class="fone">
        </dd>
        
    </dl>
    <h3>demonstrativo de rendimentos</h3>
    <dl>
        <dt>Honorários:</dt><dd>
        <input type="text"dt id="honorarios" name="honorarios" value="<?=$c->honorarios?>" placeholder="Honorários">

        </dd><dt>Salários:</dt><dd>
        <input type="text"dt id="salarios" name="salarios" value="<?=$c->salarios?>" placeholder="Salários">

        </dd><dt>Comissões:</dt><dd>
        <input type="text"dt id="comissoes" name="comissoes" value="<?=$c->comissoes?>" placeholder="Comissões">

        </dd><dt>Salário do Conjuge:</dt><dd>
        <input type="text"dt id="salario_conjuge" name="salario_conjuge" value="<?=$c->salario_conjuge?>" placeholder="Salário do Conjuge">

        </dd><dt>Renda de Aluguéis:</dt><dd>
        <input type="text"dt id="renda_alugueis" name="renda_alugueis" value="<?=$c->renda_alugueis?>" placeholder="Renda de Aluguéis">

        <dt>Possui Empréstimos?</dt><dd>
        <input type="text"dt id="emprestimo_financeiro" name="emprestimo_financeiro" value="<?=$c->emprestimo_financeiro?>" placeholder="Possui Empréstimos Financeiros?">
    </dl>
    <h3>bens de consumo</h3>
    <dl>
        <dt>Modelo do Veículo:</dt><dd>
        <input type="text" maxlength="50" name="modelo_veiculo" id="modelo_veiculo" value="<?=$c->modelo_veiculo?>" placeholder="Modelo do Veículo">

        </dd><dt>Marca do Veículo:</dt><dd>
        <input type="text" maxlength="50" name="marca_veiculo" id="marca_veiculo" value="<?=$c->marca_veiculo?>" placeholder="Marca do Veículo">

        </dd><dt>Ano do Veículo:</dt><dd>
            <input type="text" maxlength="10" name="ano_veiculo" id="ano_veiculo" value="<?=$c->ano_veiculo?>" placeholder="Ano do Veículo" class="numero">

        </dd><dt>Placa do Veículo:</dt><dd>
            <input type="text" maxlength="10" name="placa_veiculo" id="placa_veiculo" value="<?=$c->placa_veiculo?>" placeholder="Placa do Veículo" class="placa">

        </dd><dt>Valor do Veículo:</dt><dd>
        <input type="text" maxlength="25" name="valor_veiculo" id="valor_veiculo" value="<?=$c->valor_veiculo?>" placeholder="Valor do Veículo" class="money">

        </dd><dt>Financiado?</dt><dd>
        <input type="text" maxlength="50" name="financiado" id="financiado" value="<?=$c->financiado?>" placeholder="Financiado">

        </dd><dt>Imóvel:</dt><dd>
            <select name="imovel" id="imovel" class="chzn-select">
                <option value="">Selecione</option>
                <option value="Própria" <?=($c->imovel=='Própria')?'selected="selected"':'';?>>Próprio</option>
                <option value="Alugada" <?=($c->imovel=='Alugada')?'selected="selected"':'';?>>Alugado</option>
        </select>

        </dd><dt>Valor Venal:</dt><dd>
            <input type="text" maxlength="25" name="valor_venal" id="valor_venal" value="<?=$c->valor_venal?>" placeholder="Valor Venal" class="money">

        <dt>Somatória do Valor Financiado:</dt><dd>
            <input type="text" maxlength="25" name="somatoria" id="somatoria" value="<?=$c->somatoria?>" placeholder="Somatória do Valor Financiado" class="money">
    </dl>
    
    <h3>informações adicionais</h3>
    <dl>
        <div class="dt">Quando Pretende dar Início ao Negócio?</div>
        <dt>&nbsp;</dt>
        <dd class="line1">
            <select id="inicio_neg" name="inicio_neg" class="chzn-select line1">
                <option value="">Selecione</option>
                <option value="Imediato" <?php  if($c->inicio_neg=='Imediato') echo 'selected'; ?>>Imediato</option>
                <option value="2 meses" <?php  if($c->inicio_neg=='2 meses') echo 'selected'; ?>>2 meses</option>
                <option value="4 meses" <?php  if($c->inicio_neg=='4 meses') echo 'selected'; ?>>4 meses</option>
                <option value="6 meses" <?php  if($c->inicio_neg=='6 meses') echo 'selected'; ?>>6 meses</option>
                <option value="8 meses" <?php  if($c->inicio_neg=='8 meses') echo 'selected'; ?>>8 meses</option>
                <option value="acima de 8 meses" <?php  if($c->inicio_neg=='acima de 8 meses') echo 'selected'; ?>>acima de 8 meses</option>
            </select>
        </dd>
        
        <dt>Valor Disponível:</dt>
        <dd>
            <input type="text" id="valor_disp" name="valor_disp"  maxlength="14" value="<?=$c->valor_disp?>" placeholder="Valor Disponível" class="money">
        </dd>
        <dt>Pretende Ter Sócios?</dt>
        <dd>
           <input type="text" id="socios" name="socios" value="<?=$c->socios?>" maxlength="50" placeholder="Pretende Ter Sócios?">
        </dd>
        
        <dt style="width: auto;">Tem Capital Imediato Disponível para Investir?</dt>
        <dd class="checks">
            <input id="capital1" name="capital" type="radio" value="Sim" <?=($c->capital=='Sim')?'checked':'';?>>
            <span>Sim</span>
            <input  id="capital2" name="capital" type="radio" value="Não" <?=($c->capital=='Não')?'checked':'';?>>
            <span>Não</span>
        </dd>
        <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>
        
        <dt style="width: auto">Qual o seu Tempo Dedicado a Franquia?</dt>
        <dd class="checks" style="width: auto">
            <input id="dedicado_franq1" name="dedicado_franq" type="radio" value="Integral" <?=($c->dedicado_franq=='Integral')?'checked':'';?>>
            <span>Integral</span>
            <input id="dedicado_franq2" name="dedicado_franq" type="radio" value="Parcial" <?=($c->dedicado_franq=='Parcial')?'checked':'';?>>
            <span>Parcial</span>
            <input id="dedicado_franq3" name="dedicado_franq" type="radio" value="Como Investidor" <?=($c->dedicado_franq=='Como Investidor')?'checked':'';?>>
            <span>Como Investidor</span>
        </dd>
        <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>
        
        <dt style="width: auto">A Franquia Será a Principal Fonte de Renda?</dt>
        <dd class="checks" style="width: auto">
            <input id="fonte_renda1" name="fonte_renda" type="radio" value="Sim" <?=($c->fonte_renda=='Sim')?'checked':'';?>>
            <span>Sim</span>
            <input id="fonte_renda2" name="fonte_renda" type="radio" value="Não" <?=($c->fonte_renda=='Não')?'checked':'';?>>
            <span>Não</span>
            <input id="fonte_renda3" name="fonte_renda" type="radio" value="Temporariamente" <?=($c->fonte_renda=='Temporariamente')?'checked':'';?>>
            <span>Temporariamente</span>
        </dd>
        <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>
        
        
        <div class="dt">Informe se Depende de Empréstimo ou Venda de Bens para Investir em sua Franquia Cartório Postal:</div>
        <dt>&nbsp;</dt>
        <dd class="line1 txta-h">
            <textarea name="emprestimo" id="emprestimo" placeholder="Informe se Depende de Empréstimo ou Venda de Bens para Investir em sua Franquia Cartório Postal"><?= str_replace('<br />', "\n", ($c->emprestimo)); ?></textarea>
        </dd>
        <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>
        
        <div class="dt">Informe se o Capital Citado for de Terceiros:</div>
        <dt>&nbsp;</dt>
        <dd class="line1 txta-h">
            <textarea name="capital_terc" id="capital_terc" placeholder="Informe se o Capital Citado for de Terceiros"><?= str_replace('<br />', "\n", ($c->capital_terc)); ?></textarea>
        </dd>

        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_ficha > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_bancaria">
        </div>
    </dl>        
</form>
