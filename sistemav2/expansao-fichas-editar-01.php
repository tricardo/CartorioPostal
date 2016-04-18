<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=1" <?=$travar?>>
    <h3>informações do candidato</h3>
    <dl>
        <dt>Status:</dt>
        <dd class="line1">
            <strong><?php
            $status = $expansaoDAO->list_forms_historico_status($c->id_status);
            echo utf8_encode($status[0]->status);
            ?>&nbsp;</strong></dd>
        <dt >Nome <span>*</span>:</dt>
        <dd class="line1"><input name="nome" type="text" id="nome" value="<?=$c->nome?>" class="required line1" required placeholder="Nome"></dd>

        <dt>E-mail <span>*</span>:</dt>
        <dd class="line1"><input name="email" type="text" id="email" value="<?=$c->email?>" class="required email line1" required placeholder="E-mail"></dd>

        <dt>RG <span>*</span>:</dt>
        <dd><input name="rg" type="text" id="rg" value="<?=$c->rg?>" class="required" required placeholder="RG"></dd>

        <dt>CPF <span>*</span>:</dt>
        <dd><input name="cpf" type="text" id="cpf" value="<?=$c->cpf?>"  class="required cpf" required placeholder="CPF"></dd>
        
        <dt>Orgão Emissor <span>*</span>:</dt>
        <dd><select name="orgao_emissor" id="orgao_emissor" class="required chzn-select" required>
            <option value="1" <?=($c->orgao_emissor==1)?'selected':'';?>>SSP-AC</option>
            <option value="2" <?=($c->orgao_emissor==2)?'selected':'';?>>SSP-AL</option>
            <option value="3" <?=($c->orgao_emissor==3)?'selected':'';?>>SSP-AM</option>
            <option value="4" <?=($c->orgao_emissor==4)?'selected':'';?>>SSP-AP</option>
            <option value="5" <?=($c->orgao_emissor==5)?'selected':'';?>>SSP-BA</option>
            <option value="6" <?=($c->orgao_emissor==6)?'selected':'';?>>SSP-CE</option>
            <option value="7" <?=($c->orgao_emissor==7)?'selected':'';?>>SSP-DF</option>
            <option value="8" <?=($c->orgao_emissor==8)?'selected':'';?>>SSP-ES</option>
            <option value="9" <?=($c->orgao_emissor==9)?'selected':'';?>>SSP-GO</option>
            <option value="10" <?=($c->orgao_emissor==10)?'selected':'';?>>SSP-MA</option>
            <option value="11" <?=($c->orgao_emissor==11)?'selected':'';?>>SSP-MG</option>
            <option value="12" <?=($c->orgao_emissor==12)?'selected':'';?>>SSP-MS</option>
            <option value="13" <?=($c->orgao_emissor==13)?'selected':'';?>>SSP-MT</option>
            <option value="14" <?=($c->orgao_emissor==14)?'selected':'';?>>SSP-PA</option>
            <option value="15" <?=($c->orgao_emissor==15)?'selected':'';?>>SSP-PB</option>
            <option value="16" <?=($c->orgao_emissor==16)?'selected':'';?>>SSP-PE</option>
            <option value="17" <?=($c->orgao_emissor==17)?'selected':'';?>>SSP-PI</option>
            <option value="18" <?=($c->orgao_emissor==18)?'selected':'';?>>SSP-PR</option>
            <option value="19" <?=($c->orgao_emissor==19)?'selected':'';?>>SSP-RJ</option>
            <option value="20" <?=($c->orgao_emissor==20)?'selected':'';?>>SSP-RN</option>
            <option value="21" <?=($c->orgao_emissor==21)?'selected':'';?>>SSP-RO</option>
            <option value="22" <?=($c->orgao_emissor==22)?'selected':'';?>>SSP-RR</option>
            <option value="23" <?=($c->orgao_emissor==23)?'selected':'';?>>SSP-RS</option>
            <option value="24" <?=($c->orgao_emissor==24)?'selected':'';?>>SSP-SC</option>
            <option value="25" <?=($c->orgao_emissor==25)?'selected':'';?>>SSP-SE</option>
            <option value="26" <?=($c->orgao_emissor==26)?'selected':'';?>>SSP-SP</option>
            <option value="27" <?=($c->orgao_emissor==27)?'selected':'';?>>SSP-TO</option>
        </select></dd>
        

        <dt>Data de Nascimento <span>*</span>:</dt>
        <dd><input name="nascimento" type="text" id="nascimento" value="<?=$c->nascimento?>"  class="required data" required placeholder="Data de Nascimento"></dd>

        <dt>Tel. Residencial <span>*</span>:</dt>
        <dd><input name="tel_res" type="text" id="tel_res" value="<?=$c->tel_res?>"  class="required fone" required placeholder="Tel. Residencial"></dd>

        <dt>Tel. Recado:</dt>
        <dd><input name="tel_rec" type="text" id="tel_rec" value="<?=$c->tel_rec?>"  class="fone" placeholder="Tel. Recado"></dd>

        <dt>Tel. Celular:</dt>
        <dd><input name="tel_cel" type="text" id="tel_cel" value="<?=$c->tel_cel?>"  class="fone" required placeholder="Tel. Celular"></dd>

        <dt>Nacionalidade <span>*</span>:</dt>
        <dd><input name="nacionalidade" type="text" id="nacionalidade" value="<?=$c->nacionalidade?>"  class="required" required placeholder="Nacionalidade"></dd>

        <dt>Local de Nascimento:</dt>
        <dd><input name="local_nascimento" type="text" id="local_nascimento" value="<?=$c->local_nascimento?>" placeholder="Local de Nascimento"></dd>

        <dt>Estado Civil <span>*</span>:</dt>
        <dd><select name="estado_civil" id="estado_civil"  class="chzn-select required">
                <option value="">--</option>
                <option value="Casado(a)" <?=($c->estado_civil=='Casado(a)')?'selected':'';?>>Casado(a)</option>
                <option value="Solteiro(a)" <?=($c->estado_civil=='Solteiro(a)')?'selected':'';?>>Solteiro(a)</option>
                <option value="Viuvo(a)" <?=($c->estado_civil=='Viuvo(a)')?'selected':'';?>>Viuvo(a)</option>
                <option value="Separado(a)" <?=($c->estado_civil=='Separado(a)')?'selected':'';?>>Separado(a)</option>
                <option value="Divorciado(a)" <?=($c->estado_civil=='Divorciado(a)')?'selected':'';?>>Divorciado(a)</option>
                <option value="Amasiado(a)" <?=($c->estado_civil=='Amasiado(a)')?'selected':'';?>>Amasiado(a)</option>
        </select></dd>
        
        <dt>Possui Filhos?</dt>
        <dd><select name="filhos" id="filhos" class="chzn-select">
                <?$c->filhos = ($c->filhos == 'Sim') ? 1 : 0;?>
                <option value="0" <?=($c->filhos==0)?'selected':'';?>>Não</option>
                <option value="1" <?=($c->filhos==1)?'selected':'';?>>Sim</option>
        </select></dd>

        <dt>Quantos?</dt>
        <dd><input name="filhos_quant" type="text" id="filhos_quant" value="<?=$c->filhos_quant?>" class="numero" placeholder="Quantos?"></dd>

        <dt>Regime de Casamento:</dt>
        <dd><input name="regime" type="text" id="regime" value="<?=$c->regime?>"  placeholder="Regime de Casamento"></dd>

        <dt>Data do Casamento:</dt>
        <dd><input name="data_casamento" type="text" id="data_casamento" value="<?=$c->data_casamento?>" class="data" placeholder="Data do Casamento"></dd>

        <dt>Nome do Pai:</dt>
        <dd><input name="nome_pai" type="text" id="nome_pai" value="<?=$c->nome_pai?>" placeholder="Nome do Pai"></dd>

        <dt>Nome da Mãe:</dt>
        <dd><input name="nome_mae" type="text" id="nome_mae" value="<?=$c->nome_mae?>"  placeholder="Nome da Mãe"></dd>

        <dt>Nome do Sócio:</dt>
        <dd><input name="nome_socio" type="text" id="nome_socio" value="<?=$c->nome_socio?>"  placeholder="Nome do Sócio"></dd>

        <dt>Profissão <span>*</span>:</dt>
        <dd><input name="profissao" type="text" id="profissao" value="<?=$c->profissao?>" class="required" required  placeholder="Profissão"></dd>
    
    </dl>
    <h3>Endereço</h3>
    <dl>
        <dt>Endereço <span>*</span>:</dt>
        <dd class="line1">
            <input class="required line1" required name="endereco" type="text" id="endereco" value="<?=$c->endereco?>" placeholder="Endereço">
        </dd>    
        <dt><label>Número <span>*</span>:</dt>
        <dd>
            <input class="required" required name="numero" type="text" id="numero" value="<?=$c->numero?>" placeholder="Numero">
        </dd>
        <dt>Complemento:</dt>
        <dd>
            <input name="complemento" type="text" id="complemento" value="<?=$c->complemento?>" placeholder="Complemento">
        </dd>
        <dt>Bairro <span>*</span>:</dt>
        <dd>
            <input type="text" name="bairro" id="bairro" value="<?= ($c->bairro) ?>" placeholder="Bairro" required class="required">
        </dd>
        <dt>CEP <span>*</span>:</dt>
        <dd>
            <input type="text" name="cep" id="cep" class="cep required" value="<?= ($c->cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')" required>
        </dd>
        <dt>Cidade <span>*</span>:</dt>    
        <dd>
            <input type="text" name="cidade" id="cidade" value="<?= ($c->cidade) ?>" placeholder="Cidade" required class="required">
        </dd>
        <dt>Estado <span>*</span>:</dt>
        <dd>
            <select class="chzn-select required" name="estado" id="estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $c->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
        <dt>Tipo do Imóvel:</dt><dd>
            <select name="tip_imovel" id="tip_imovel" class="chzn-select">
                    <option value="0">--</option>
                    <option value="1" <?php if($c->tip_imovel == 1){ ?> selected="selected" <?php } ?>>Própria</option>
                    <option value="2" <?php if($c->tip_imovel == 2){ ?> selected="selected" <?php } ?>>Alugada</option>
                    <option value="3" <?php if($c->tip_imovel == 3){ ?> selected="selected" <?php } ?>>Familiares</option>
            </select>
        </dd>
        <dt>Reside na Praça Desde:</dt>
        <dd>
            <input name="reside_praca" type="text" id="reside_praca" value="<?=$c->reside_praca?>" maxlength="25">
        </dd>
    </dl>
    <h3>Último Endereço</h3>
    <dl>
        <dt>Endereço: </dt>
        <dd class="line1">
            <input class="line1" name="anterior_endereco" type="text" id="anterior_endereco" value="<?=$c->anterior_endereco?>" placeholder="Endereço">
        </dd>    
        <dt><label>Número: </dt>
        <dd>
            <input  name="anterior_numero" type="text" id="anterior_numero" value="<?=$c->anterior_numero?>" placeholder="Numero">
        </dd>
        <dt>Complemento:</dt>
        <dd>
            <input name="anterior_complemento" type="text" id="anterior_complemento" value="<?=$c->anterior_complemento?>" placeholder="Complemento">
        </dd>
        <dt>Bairro :</dt>
        <dd>
            <input type="text" name="anterior_bairro" id="anterior_bairro" value="<?= ($c->anterior_bairro) ?>" placeholder="Bairro" >
        </dd>
        <dt>CEP :</dt>
        <dd>
            <input type="text" name="anterior_cep" id="anterior_cep" class="cep" value="<?= ($c->anterior_cep) ?>" placeholder="CEP">
        </dd>
        <dt>Cidade :</dt>    
        <dd>
            <input type="text" name="anterior_cidade" id="anterior_cidade" value="<?= ($c->anterior_cidade) ?>" placeholder="Cidade" >
        </dd>
        <dt>Estado :</dt>
        <dd>
            <select class="chzn-select" name="anterior_estado" id="anterior_estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $c->anterior_estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
    </dl>
    <h3>Dados do Cônjuge</h3>
    <dl>
        <dt>Nome:</dt>
        <dd class="line1">
            <input name="conjuge_nome" type="text" id="conjuge_nome" value="<?=$c->conjuge_nome?>" placeholder="Nome" class="line1">

        </dd>
        <dt>E-mail:</dt>
        <dd>
            <input name="conjuge_email" type="text" id="conjuge_email" value="<?=$c->conjuge_email?>" placeholder="E-mail" class="email">

        </dd><dt>RG:</dt><dd>
            <input name="conjuge_rg" type="text" id="conjuge_rg" value="<?=$c->conjuge_rg?>" placeholder="RG">

        </dd><dt>CPF:</dt><dd>
            <input class="cpf" name="conjuge_cpf" type="text" id="conjuge_cpf" value="<?=$c->conjuge_cpf?>" placeholder="CPF">

        </dd><dt>Data de Nascimento:</dt><dd>
            <input class="data" name="conjuge_nascimento" type="text" id="conjuge_nascimeto" value="<?=$c->conjuge_nascimento?>" placeholder="Data de Nascimento">

        </dd><dt>Nome do Pai:</dt><dd>
            <input name="conjuge_nome_pai" type="text" id="conjuge_nome_pai" value="<?=$c->conjuge_nome_pai?>" placeholder="Nome do Pai">

        </dd><dt>Nome da Mãe:</dt><dd>
            <input name="conjuge_nome_mae" type="text" id="conjuge_nome_mae" value="<?=$c->conjuge_nome_mae?>"placeholder="Nome da Mãe">

        </dd>
        <dt>Empresa:</dt>
        <dd class="line1">
            <input name="conjuge_empresa" type="text" id="conjuge_empresa" value="<?=$c->conjuge_empresa?>" placeholder="Empresa" class="line1">

        </dd>
        <dt>Profissão:</dt><dd>
            <input name="conjuge_profissao" type="text" id="conjuge_profissao" value="<?=$c->conjuge_profissao?>" placeholder="Profissão">

        </dd><dt>Cargo:</dt><dd>
            <input name="conjuge_cargo" type="text" id="conjuge_cargo" value="<?=$c->conjuge_cargo?>" placeholder="Cargo">
        </dd>
        <dt>Telefone:</dt><dd>
            <input name="conjuge_telefone" type="text" id="conjuge_telefone" value="<?=$c->conjuge_telefone?>" placeholder="Telefone" class="fone">

        </dd><dt>Data de Admissao:</dt><dd>
            <input name="conjuge_admissao" type="text" id="conjuge_admissao" value="<?=$c->conjuge_admissao?>" placeholder="Data de Admissão" class="data">

        </dd><dt>Endereço da Empresa:</dt><dd class="line1">
            <input name="conjuge_end_empresa" type="text" id="conjuge_end_empresa" value="<?=$c->conjuge_end_empresa?>" placeholder="Endereço da Empresa" class="line1">

        <dt>Número:</dt><dd>
            <input name="conjuge_numero" type="text" id="conjuge_numero" value="<?=$c->conjuge_numero?>" placeholder="Número">

        </dd><dt>Complemento:</dt><dd>
            <input name="conjuge_complemento" type="text" id="conjuge_complemento" value="<?=$c->conjuge_complemento?>" placeholder="Complemento">

        </dd><dt>Bairro:</dt><dd>
            <input name="conjuge_bairro" type="text" id="conjuge_bairro" value="<?=$c->conjuge_bairro?>" placeholder="Bairro">

        </dd><dt>CEP:</dt><dd>
            <input name="conjuge_cep" type="text" id="conjuge_cep" value="<?=$c->conjuge_cep?>" placeholder="CEP" class="cep">

        </dd><dt>UF:</dt><dd>
        <select id="conjuge_estado" name="conjuge_estado" class="chzn-select">
            <?php $estado = UFs();
            for($i = 0; $i < count($estado); $i++){ ?>
                    <option value="<?=$estado[$i]?>" <?=($estado[$i] == $c->conjuge_estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
            <?php } ?>
        </select>

        </dd><dt>Cidade:</dt><dd>
            <input name="conjuge_cidade" type="text" id="conjuge_cidade" value="<?=$c->conjuge_cidade?>" placeholder="Cidade">
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_ficha > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>        
</form>
