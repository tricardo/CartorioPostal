<form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>&opcoes_form=2" <?=$travar?>>
    <h3>informações empresariais</h3>
    <dl>
        
        <dt>Deseja ser?</dt>
        <dd>
            <select name="franqueado" id="franqueado" class="chzn-select">
                <option value="Franqueado" <?=($c->franqueado=='Franqueado')?'selected':'';?>>Franqueado</option>
                <option value="Sócio" <?=($c->franqueado=='Sócio')?'selected':'';?>>Sócio</option>
                <option value="Fiador" <?=($c->franqueado=='Fiador')?'selected':'';?>>Fiador</option>
            </select>
        </dd>
        <dt>Experiência com Franq.?</dt>
        <dd>
            <select name="experiencia" id="experiencia" class="chzn-select">
                <option value="2" <?=($c->experiencia==2)?'selected':'';?>>Não</option>
                <option value="1" <?=($c->experiencia==1)?'selected':'';?>>Sim</option>
            </select>
        </dd>
        <dt>Número de Funcionários:</dt>
        <dd>
            <input name="funcionarios2" type="text" id="funcionarios2" value="<?=$c->funcionarios2?>" maxlength="50" placeholder="Número de Funcionários" class="numero">
        </dd>
        <dt>Faturamento:</dt>
        <dd>
            <input name="faturamento2" type="text" id="faturamento2" value="<?=$c->faturamento2?>" maxlength="50" placeholder="Faturamento" class="money">
        </dd>
        <dt>Qual Franquia?</dt>
        <dd class="line1">
            <input name="qual_franquia" type="text" id="qual_franquia" value="<?=$c->qual_franquia?>" maxlength="50" placeholder="Qual Franquia?" class="line1">
        </dd>
        <div class="dt">Se Não, Qual o Motivo de Não Possuir o Negócio?</div>
        <dt>&nbsp;</dt>
        <dd class="line1">
            <input name="motivo" type="text" id="motivo" value="<?=$c->motivo?>" maxlength="50" placeholder="Se Não, Qual o Motivo de Não Possuir o Negócio?">
        </dd>
        <div class="dt">Na sua Opinião Quais os Fatores Determinantes para o Sucesso de um Negócio?</div>
        <dt>&nbsp;</dt>
        <dd class="line1">
            <input name="opiniao" type="text" id="opiniao" value="<?=$c->opiniao?>" maxlength="50" placeholder="Na sua Opinião Quais os Fatores Determinantes para o Sucesso de um Negócio?" class="line1">
        </dd>
    </dl>
    <h3>Histórico Profissional</h3>
    <dl>
        <dt>Empresa: </dt><dd class="line1">
            <input class="line1" name="empresa_t" type="text" id="empresa_t"  value="<?=$c->empresa_t?>" maxlength="25" placeholder="Empresa">

        </dd><dt>Cargo Atual: </dt><dd>
        <input name="cargo" type="text" id="cargo"value="<?=$c->cargo?>" maxlength="25" placeholder="Cargo Atual">


        </dd>
        <dt>Período: </dt><dd>
            <select name="periodo" id="periodo" class="chzn-select">
                <option value="">Período</option>
                <option value="6 meses a 1 ano"  <?php if($c->periodo=='6 meses a 1 ano') echo 'selected'; ?>>6 meses a 1 ano</option>
                <option value="1 ano a 5 anos"  <?php if($c->periodo=='1 ano a 5 anos') echo 'selected'; ?>>1 ano a 5 anos</option>
                <option value="5 anos a 10 anos"  <?php if($c->periodo=='5 anos a 10 anos') echo 'selected'; ?>>5 anos a 10 anos</option>
                <option value="acima de 10 anos"  <?php if($c->periodo=='acima de 10 anos') echo 'selected'; ?>>acima de 10 anos</option>
        </select>

        </dd><dt>Funcionários:</dt><dd>
        <select name="funcionarios" id="funcionarios" class="chzn-select">
                <option value="">Funcionários</option>
                <option value="1 a 5" <?php if($c->funcionarios=='1 a 5') echo 'selected'; ?>>1 a 5</option>
                <option value="de 5 a 10" <?php if($c->funcionarios=='de 5 a 10') echo 'selected'; ?>>de 5 a 10</option>
                <option value="de 10 a 50" <?php if($c->funcionarios=='de 10 a 50') echo 'selected'; ?>>de 10 a 50</option>
                <option value="de 50 a 100" <?php if($c->funcionarios=='de 50 a 100') echo 'selected'; ?>>de 50 a 100</option>
                <option value="acima de 100" <?php if($c->funcionarios=='acima de 100') echo 'selected'; ?>>acima de 100</option>
        </select>

        </dd><dt>Faturamento:</dt><dd>
        <select name="faturamento" id="faturamento" class="chzn-select">
                <option value="">Faturamento</option>
                <option value="Até R$ 50 mil" <?php if($c->faturamento=='Até R$ 50 mil') echo 'selected'; ?>>Até R$ 50 mil</option>
                <option value="R$ 50 a R$ 100 mil" <?php if($c->faturamento=='R$ 50 a R$ 100 mil') echo 'selected'; ?>>R$ 50 a R$ 100 mil</option>
                <option value="R$ 100 a R$ 300 mil" <?php if($c->faturamento=='R$ 100 a R$ 300 mil') echo 'selected'; ?>>R$ 100 a R$ 300 mil</option>
                <option value="R$ 300 a R$ 500 mil" <?php if($c->faturamento=='R$ 300 a R$ 500 mil') echo 'selected'; ?>>R$ 300 a R$ 500 mil</option>
                <option value="Acima de R$ 500 mil" <?php if($c->faturamento=='Acima de R$ 500 mil') echo 'selected'; ?>>Acima de R$ 500 mil</option>
        </select>

        </dd><dt>Contato: </dt><dd>
        <input name="contato" type="text" id="contato" value="<?=$c->contato?>" maxlength="50" placeholder="Contato">

        </dd><dt>Ramo de Atuação:</dt><dd>
        <input id="ramo_at" maxlength="40" name="ramo_at" value="<?=$c->ramo_at?>" type="text" placeholder="Ramo de Atuação">

        </dd><dt>Nome da Empresa:</dt><dd class="line1">
        <input name="empresa_p" type="text" id="empresa_p" class="line1" value="<?=$c->empresa_p?>" maxlength="50" placeholder="Nome da Empresa">

        </dd><dt>Cursos: </dt><dd>
        <input type="text" maxlength="50" id="cursos" name="cursos" value="<?=$c->cursos?>" placeholder="Cursos">

        </dd><dt>Grau de Escolaridade:</dt><dd>
        <select id="escolaridade" name="escolaridade" class="chzn-select">
                <option value="">Grau de Escolaridade</option>
                <option value="Ensino fundamental: Incompleto" <?php if($c->escolaridade=='Ensino fundamental: Incompleto') echo 'selected'; ?>>Ensino fundamental: Incompleto</option>
                <option value="Ensino fundamental: Completo" <?php if($c->escolaridade=='Ensino fundamental: Completo') echo 'selected'; ?>>Ensino fundamental: Completo</option>

                <option value="Ensino médio: Incompleto" <?php if($c->escolaridade=='Ensino médio: Incompleto') echo 'selected'; ?>>Ensino médio: Incompleto</option>
                <option value="Ensino médio: Completo" <?php if($c->escolaridade=='Ensino médio: Completo') echo 'selected'; ?>>Ensino médio: Completo</option>

                <option value="Ensino superior: Incompleto" <?php if($c->escolaridade=='Ensino superior: Incompleto') echo 'selected'; ?>>Ensino superior: Incompleto</option>
                <option value="Ensino superior: Completo" <?php if($c->escolaridade=='Ensino superior: Completo') echo 'selected'; ?>>Ensino superior: Completo</option>

                <option value="Pós graduação" <?php if($c->escolaridade=='Pós graduação') echo 'selected'; ?>>Pós graduação</option>
                <option value="Mestrado" <?php if($c->escolaridade=='Mestrado') echo 'selected'; ?>>Mestrado</option>
                <option value="Doutorado" <?php if($c->escolaridade=='Doutorado') echo 'selected'; ?>>Doutorado</option>
                <option value="MBA" <?php if($c->escolaridade=='MBA') echo 'selected'; ?>>MBA</option>
        </select>

        </dd><dt>Qual Faculdade:</dt><dd>
        <input name="faculdade" type="text" id="faculdade" value="<?=$c->faculdade?>" maxlength="45" placeholder="Qual Faculdade">

        </dd><dt>Ano de Conclusão:</dt><dd>
        <input name="conclusao" type="text" id="conclusao" value="<?=$c->conclusao?>" maxlength="7" placeholder="Ano de Conclusão">

        </dd>
        <dt style="width: auto">Tem/Teve Negócio Próprio?</dt>
        <dd class="checks">
            <input id="negocios1" name="negocios" type="radio" value="Sim" <?=($c->negocios=='Sim')?'checked':'';?>>
            <span>Sim</span>
            <input id="negocios2" name="negocios" type="radio" value="Não" <?=($c->negocios=='Não')?'checked':'';?>>
            <span>Não</span>
        </dd>
        <div class="dt">Faça um Breve Relato Sobre seu Histórico:</div>
        <dt>&nbsp;</dt>
        <dd class="line1 txta-h">
            <textarea name="historico" id="historico" placeholder="Faça um Breve Relato Sobre seu Histórico"><?= str_replace('<br />', "\n", ($c->historico)); ?></textarea>
        </dd>
    </dl>
    <h3>Sobre a Franquia Cartório Postal</h3>
    <dl>
        <dt>Cidade de Interesse:</dt>
        <dd>
            <input type="text" id="cidade_interesse" name="cidade_interesse" value="<?=$c->cidade_interesse?>" maxlength="120" placeholder="Cidade de Interesse">
        </dd>
        
        <dt>Estado de Interesse:</dt>
        <dd>
            <select name="estado_interesse" id="estado_interesse" class="chzn-select">
            <?php $estado = UFs();
                for($i = 0; $i < count($estado); $i++){ ?>
                        <option value="<?=$estado[$i]?>" <?=($estado[$i] == $c->estado_interesse) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                <?php } ?>?>
            </select>
        </dd>
        <dt style="width: auto">Deseja Receber Comunicados de Outras Empresas da Rede?</dt>
        <dd class="checks" style="width: auto">
             <input id="comunicados1" name="comunicados" type="radio" value="Sim" <?=($c->comunicados=='Sim')?'checked':'';?>>
             <span>Sim</span>
             <input id="comunicados2" name="comunicados" type="radio" value="Não" <?=($c->comunicados=='Não')?'checked':'';?>>
             <span>Não</span>
        </dd>
        <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>
        <dt style="width: auto">Já Esteve em uma de Nossas Unidades?</dt>
        <dd class="checks">
            <input id="unidades1" name="unidades" type="radio" value="Sim" <?=($c->unidades=='Sim')?'checked':'';?>>
            <span>Sim</span>
            <input id="unidades2" name="unidades" type="radio" value="Não" <?=($c->unidades=='Não')?'checked':'';?>>
            <span>Não</span>
        </dd>
        
        <dt style="width:87px">Qual?</dt>
        <dd>
            <input type="text" id="unidades_valor" name="unidades_valor" maxlength="25" value="<?=$c->unidades_valor?>" placeholder="Qual?">
        </dd>
      
       <?php /* <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>       
        <div class="dt">Enumere o que você considera importante na franquia Cartório Postal, sendo que o número 1 é o mais importante:</div>
            <dd>
                <?php $dt = $expansaoDAO->EnumPergunta(); $i = 0; $valor = array();
                foreach($dt as $j => $ep){
                        $id_pergunta[$i] = $ep->id_enum_perg;
                        $pergunta[$i]    = $ep->pergunta;
                        $ret = $expansaoDAO->relFichaLazer2($id_ficha, $ep->id_enum_perg);
                        $valor[$i] = $ret[0]->valor;
                        $i++;
                } 
                for($i = 0; $i < count($id_pergunta); $i++){ ?>
                    <input type="hidden" value="<?=$id_pergunta[$i]?>" name="id_pergunta[]" id="id_pergunta<?=$i?>" placeholder="">
                    <input onKeyUp="masc_numeros(this,'#');" name="perguntas[]" id="pergunta<?=$i?>" value="<?=$valor[$i]?>" type="text"  maxlength="1" style="text-align:center; width:50px; margin-left:10px;" placeholder="">
                    <dt><?=$pergunta[$i]?></dt><dd>		
                <?php } 
                <input type="hidden" value="<?=$i?>" name="id_pergunta_total" id="id_pergunta_total">
            </dd>
        <div style="height: 1px; line-height: 1px; margin: 0" class="dt"></div>*/?>
        <div class="dt">Como Conheceu as Franquias Cartório Postal:</div>
        <dt>&nbsp;</dt>
        <dd class="line1 txta-h">
            <textarea name="conheceu_cp" id="conheceu_cp" placeholder="Como Conheceu as Franquias Cartório Postal"><?= str_replace('<br />', "\n", ($c->conheceu_cp)); ?></textarea>
        </dd>
        
        <div class="dt">Porque o Interesse em ser um Franqueado?</div>
        <dt>&nbsp;</dt>
        <dd class="line1 txta-h">
            <textarea name="interesse" id="interesse" placeholder="Porque o Interesse em ser um Franqueado?"><?= str_replace('<br />', "\n", ($c->interesse)); ?></textarea>
        </dd>
    
        <div class="dt">Seu Espaço Para Observações:</div>
        <dt>&nbsp;</dt>
        <dd class="line1 txta-h">
            <textarea name="observacao" id="observacao" placeholder="Seu Espaço Para Observações"><?= str_replace('<br />', "\n", ($c->observacao)); ?></textarea>
        </dd>
        
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_ficha > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_empresarial">
        </div>
    </dl>        
</form>
