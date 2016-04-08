<?php

#cadastros
$arr14 = array(1);
$permissao08 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao09 = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao10 = verifica_permissao('Cliente', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao121=verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao122= verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao13 = verifica_permissao('Cartorio', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao14 = in_array($controle_id_usuario, $arr14) ? 'TRUE' : 'FALSE';
$permissao15 = verifica_permissao('Protesto', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao16 = verifica_permissao('Direcionamento', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao17 = verifica_permissao('Direcionamento_site', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao18 = verifica_permissao('Pedido', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao50 = verifica_permissao('Conta', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao_cadastro = ($permissao08 == 'TRUE' OR $permissao09 == 'TRUE' OR $permissao10 == 'TRUE' OR 
        $permissao121 == 'TRUE' OR $permissao122 == 'TRUE' OR $permissao13 == 'TRUE' OR 
        $permissao14 == 'TRUE' OR $permissao15 == 'TRUE' OR $permissao16 == 'TRUE' OR 
        $permissao17 == 'TRUE' OR $permissao18 == 'TRUE' OR $permissao50 == 'TRUE') ? 'TRUE' : 'FALSE';



#expansao
$fichas1 = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
$fichas2 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao19 = ($fichas1 == 'TRUE' OR $fichas2 == 'TRUE') ? 'TRUE' : 'FALSE';
$permissao21 = $permissao19;
$permissao20 = verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao51 = $permissao20;
$permissao_expansao = ($permissao19 == 'TRUE' OR $permissao20 == 'TRUE' OR $permissao21 == 'TRUE' OR 
        $permissao51 == 'TRUE') ? 'TRUE' : 'FALSE';


#financeiro
$permissao24 = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao26 = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao27 = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao52 = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao_financeiro = ($permissao24 == 'TRUE' OR $permissao26 == 'TRUE' OR $permissao27 == 'TRUE' OR 
        $permissao52 == 'TRUE' OR (verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s)) == 'TRUE') ? 'TRUE' : 'FALSE';


#relatorios
$permissao33 = ((verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'TRUE' OR
                verifica_permissao('Rel_comercial',$controle_id_departamento_p,$controle_id_departamento_s) == 'TRUE' OR
                verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'TRUE' OR
                verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'TRUE' OR
                verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s) == 'TRUE')) ? 'TRUE' : 'FALSE';
$permissao34 = $permissao33;
$permissao35 = $permissao_expansao;
$permissao36 = $permissao_financeiro;
$permissao37 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao38 = $permissao33;
$permissao_relatorio = ($permissao34 == 'TRUE' OR $permissao35 == 'TRUE' OR $permissao36 == 'TRUE' OR 
        $permissao37 == 'TRUE' OR $permissao38 == 'TRUE') ? 'TRUE' : 'FALSE';

#arquivos
$arr_arq = array(1,6,192);
$permissao_arquivo = verifica_permissao('Remessa_Retorno', $controle_id_departamento_p, $controle_id_departamento_s);
       


#sub relatorio
$id_departamento_s = explode(',', $controle_id_departamento_s);
#atendimento
$cont1 = 0; 
if (verifica_permissao('Rel_comercial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE') { $cont1++; }
if ((verifica_permissao('Supervisor Atendimento', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
    or (verifica_permissao('Supervisor Financeiro', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
){ $cont1++; }

#diretoria
$cont2 = 0;
if(verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){ $cont2++; }

#expansao
$cont3 = 0;
if(verifica_permissao('EXPANSAO_S', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' AND $controle_id_empresa == 1){ $cont3++; }

#financeiro
$cont4 = 0;
if(verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){ $cont4++; }
if(verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){ $cont4++; }
if(verifica_permissao('Rel_comercial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE') { $cont4++; }
if ((verifica_permissao('Supervisor Atendimento', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
    or (verifica_permissao('Supervisor Financeiro', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
){
    $cont4++;
}

#franquia
$cont5 = 0;
 if ($controle_id_empresa == 1 and in_array(17, $id_departamento_s) == 1) { $cont5++; }

#operacional
$cont6 = 0;
if(verifica_permissao('Rel_supervisores', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){ $cont6++; }
if(verifica_permissao('Rel_n_supervisores', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){ $cont6++; }
if($controle_id_empresa == 1 and isset($controle_depto_p['27']) AND $controle_depto_p['27'] == '1'){ $cont6++; }

#exibir relatorio
$cont_total = $cont1 + $cont2 + $cont3 + $cont4 + $cont5 + $cont6;
?>


<div class="header">
    <div class="menu">
        <ul>
            <li id="bt-01" onclick="menu(3,'bt-01')" onmouseover="menu(1,'bt-01')" onmouseout="menu(2,'bt-01')" title="INICIAR" ><img src="images/bt-01.png"><label>iniciar</label></li>
            <li class="divisor">&nbsp;</li>
            <?php if($permissao_cadastro == 'TRUE'){ ?>
                <li id="bt-02" onclick="menu(3,'bt-02')" onmouseover="menu(1,'bt-02')" onmouseout="menu(2,'bt-02')" title="CADASTROS"><img src="images/bt-02.png"><label>cadastros</label></li>
                <li class="divisor">&nbsp;</li>
            <?php } 
            if($permissao_expansao == 'TRUE' AND $controle_id_empresa == 1){ ?>
                <li id="bt-03" onclick="menu(3,'bt-03')" onmouseover="menu(1,'bt-03')" onmouseout="menu(2,'bt-03')" title="EXPANSÃO"><img src="images/bt-03.png"><label>expansão</label></li>
                <li class="divisor">&nbsp;</li>
            <?php } 
            if($permissao_financeiro == 'TRUE'){ ?>
                <li id="bt-04" onclick="menu(3,'bt-04')" onmouseover="menu(1,'bt-04')" onmouseout="menu(2,'bt-04')" title="FINANCEIRO"><img src="images/bt-04.png"><label>financeiro</label></li>
                <li class="divisor">&nbsp;</li>
            <?php } 
            if($permissao_relatorio == 'TRUE' AND $cont_total > 0){ ?>
                <li id="bt-05" onclick="menu(3,'bt-05')" onmouseover="menu(1,'bt-05')" onmouseout="menu(2,'bt-05')" title="RELATÓRIOS"><img src="images/bt-05.png"><label>relatórios</label></li>
                <li class="divisor">&nbsp;</li>
            <?php } 
            if($permissao_arquivo == 'TRUE' AND in_array($controle_id_empresa, $arr_arq)){ ?>
                <li id="bt-06" onclick="menu(3,'bt-06')" onmouseover="menu(1,'bt-06')" onmouseout="menu(2,'bt-06')" title="ARQUIVOS"><img src="images/bt-06.png"><label>arquivos</label></li>
                <li class="divisor">&nbsp;</li>
            <?php } ?>
            <li id="bt-08" onclick="location.href='sair.php'" onmouseover="menu(1,'bt-08')" onmouseout="menu(2,'bt-08')" title="SAIR"><img src="images/bt-08.png"><label>sair</label></li>
            <li class="divisor">&nbsp;</li>
        </ul>
    </div>
    <div class="perfil">
        <img src="images/cartoriopostal-logo.png">
        <br><?=utf8_encode($VARS->fantasia)?>
    </div>
    <div class="submenu">
        <div class="items" id="sub-bt-01">
            <ul>
                <li><a href="principal.php" id="sub-01" title="HOME">Home</a></li>
                <li>|</li>
                <li><a href="alterar-senha.php" id="sub-02" title="ALTERAR SENHA">Alterar Senha</a></li>
                <li>|</li>
                <li><a href="rede-de-franqueados.php" id="sub-03" title="REDE DE FRANQUEADOS">Rede de Franqueados</a></li>
                <li>|</li>
                <li><a href="skype.php" id="sub-04" title="SKYPE">Skype</a></li>
                <li>|</li>
                <li><a href="comunicados.php" id="sub-05" title="COMUNICADOS">Comunicados</a></li>
                <li>|</li>
                <li><a href="downloads.php" id="sub-06" title="DOWNLOADS">Downloads</a></li>
                <li>|</li>
                <li><a href="convencoes.php" id="sub-49" title="Convenções">Convenções</a></li>
                <li>|</li>
            </ul>
        </div>
        <?php if($permissao_cadastro == 'TRUE'){ ?>
            <div class="items" id="sub-bt-02">
                <ul>
                    <?php 
                    if ($permissao08 == 'TRUE' and $controle_id_empresa == '1') { ?>
                        <li><a href="franquias-listar.php" id="sub-08" title="FRANQUIAS">franquias</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao09 == 'TRUE') { ?>
                        <li><a href="usuarios-listar.php" id="sub-09" title="COLABORADORES">colaboradores</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao10 == 'TRUE') { ?>
                        <li><a href="clientes-listar.php" id="sub-10" title="CLIENTES">clientes</a></li>
                        <li>|</li>
                    <?php } 
                    if ($controle_id_empresa == 1 and $controle_id_usuario == 1){ ?> 
                        <li><a href="parceiros-listar.php" id="sub-11" title="PARCEIROS">parceiros</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao121 == 'TRUE' OR $permissao122 == 'TRUE') { ?>
                        <li><a href="fornecedores-listar.php" id="sub-12"  title="FORNECEDORES">fornecedores</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao13 == 'TRUE' AND $controle_id_empresa == 1) { ?>
                        <li><a href="cartorios-listar.php" id="sub-13" title="CARTÓRIOS">cartórios</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao14 == 'TRUE') { ?>
                        <li><a href="correios-listar.php"id="sub-14"  title="CORREIOS">correios</a></li>
                        <li>|</li>
                    <?php }
                    if ($permissao15 == 'TRUE') { ?>
                        <li><a href="protestos-listar.php" id="sub-15" title="PROTESTOS">protestos</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao50 == 'TRUE') { ?>
                        <li><a href="contas-listar.php" id="sub-50" title="CONTAS">contas</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao16 == 'TRUE') {?>
                        <li><a href="direcionamento-listar.php" id="sub-16" title="DIRECIONAMENTO">direcionamento</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao17 == 'TRUE') { ?>
                        <li><a href="direcionamento-site-listar.php" id="sub-17" title="DIRECIONAMENTO DO SITE">direcionamento do site</a></li>
                        <li>|</li>
                    <?php } 
                    if ($permissao18 == 'TRUE') { ?>
                        <li><a href="pedido-listar.php" id="sub-18" title="PEDIDOS">pedidos</a></li>
                        <li>|</li>
                    <?php } ?>
                </ul>
            </div>
        <?php } 
        if($permissao_expansao == 'TRUE' AND $controle_id_empresa == 1){ ?>
            <div class="items" id="sub-bt-03">
                <ul>
                    <?php if ($permissao21 == 'TRUE') { ?>
                        <li><a href="expansao-fichas-listar.php" id="sub-21" title="FICHAS">fichas</a></li>
                        <li>|</li>
                    <?php }
                    if ($permissao19 == 'TRUE') { ?>
                        <li><a href="expansao-agenda.php" id="sub-19" title="AGENDA">agenda</a></li>
                        <li>|</li>
                    <?php }
                    if ($permissao20 == 'TRUE') { ?>
                        <li><a href="expansao-direcionamento.php" id="sub-20" title="DIRECIONAMENTO">direcionamento</a></li>
                        <li>|</li>
                    <?php }
                    if ($permissao51 == 'TRUE') { ?>
                        <li><a href="expansao-relatorio.php" id="sub-51" title="Relatório">relatório</a></li>
                        <li>|</li>
                    <?php } ?>
                </ul>
            </div>
        <?php } 
        if($permissao_financeiro == 'TRUE'){ ?>
            <div class="items" id="sub-bt-04">
                <ul>
                    <?php if ($permissao26 == 'TRUE') { ?>
                        <li><a href="contas-a-pagar-listar.php" id="sub-26" title="CONTAS À PAGAR">contas à pagar</a></li>
                        <li>|</li>
                    <?php }
                    if ($permissao52 == 'TRUE') { ?>
                        <li><a href="cobranca-listar.php" id="sub-52" title="COBRANÇA">cobrança</a></li>
                        <li>|</li>
                    <?php }
                    if ($permissao24 == 'TRUE') { ?>
                        <li><a href="servicos-listar.php" id="sub-24" title="SERVIÇOS">serviços</a></li>
                        <li>|</li>
                    <?php }                  
                    if ($permissao27 == 'TRUE') { ?>
                        <li><a href="desembolso-listar.php" id="sub-27" title="DESEMBOLSO">desembolso</a></li>
                        <li>|</li>
                        <li><a href="recebimentos-de-pedidos.php" id="sub-28" title="PEDIDOS">pedidos</a></li>
                        <li>|</li>
                        <li><a href="recebimentos-de-franquias-listar.php" id="sub-29" title="FRANQUIAS">franquias</a></li>
                        <li>|</li>
                    <?php } 
                    if ($controle_id_empresa == 1 AND $permissao27 == 'TRUE') { ?>
                        <li><a href="royalties-listar.php" id="sub-30" title="ROYALTIES">royalties</a></li>
                        <li>|</li>
                        <li><a href="boletos-listar.php" id="sub-32" title="BOLETOS">boletos</a></li>
                        <li>|</li>
                    <?php } ?>
                </ul>
            </div>
        <?php } 
        if($permissao_relatorio == 'TRUE' AND $cont_total > 0){ ?>
         <div class="items" id="sub-bt-05">
                <ul>
                    <?php if ($permissao33 == 'TRUE' AND $cont1 > 0) { ?>
                        <li><a href="relatorios-atendimento.php" id="sub-33" title="ATENDIMENTO">atendimento</a></li>
                        <li id="div-33">|</li>
                    <?php }
                    if ($permissao34 == 'TRUE' AND $cont2 > 0) { ?>
                        <li><a href="relatorios-diretoria.php" id="sub-34" title="DIRETORIA">diretoria</a></li>
                        <li id="div-34">|</li>
                    <?php }
                    if ($permissao35 == 'TRUE' AND $cont3 > 0) { ?>
                        <li><a href="relatorios-expansao.php" id="sub-35" title="EXPANSÃO">expansão</a></li>
                        <li id="div-35">|</li>
                    <?php }
                    if ($permissao36 == 'TRUE' AND $cont4 > 0) { ?>
                        <li><a href="relatorios-financeiro.php" id="sub-36" title="FINANCEIRO">financeiro</a></li>
                        <li id="div-36">|</li>
                    <?php }
                    if ($permissao37 == 'TRUE' AND $cont5 > 0) { ?>
                        <li><a href="relatorios-franquia.php" id="sub-37" title="FRANQUIA">franquia</a></li>
                        <li id="div-37">|</li>
                    <?php }
                    if ($permissao38 == 'TRUE' AND $cont6 > 0) { ?>
                        <li><a href="relatorios-operacional.php" id="sub-38" title=" OPERACIONAL">operacional</a></li>
                        <li id="div-38">|</li>
                    <?php } ?>
                </ul>
            </div>
        <?php } 
        if($permissao_arquivo == 'TRUE' AND in_array($controle_id_empresa, $arr_arq)){ ?>
            <div class="items" id="sub-bt-06">
                <ul>
                    <?php if($controle_id_empresa == '1'){ ?>
                        <li><a href="retorno-do-cliente-editar.php" id="sub-39" title="RETORNO DO CLIENTE">retorno do cliente</a></li>
                        <li>|</li>
                    <?php } ?>
                    <li><a href="retorno-do-cartorio-editar.php" id="sub-40" title="RETORNO DO CARTÓRIO">retorno do cartório</a></li>
                    <li>|</li>
                    <?php if(in_array($controle_id_empresa, $arr_arq)){ ?>
                        <li><a href="remessa-do-cartorio-editar.php" id="sub-41" title="REMESSA DO CARTÓRIO">remessa do cartório</a></li>
                        <li>|</li>
                    <?php } ?>
                    <li><a href="log-de-importados.php" id="sub-42" title="LOG DE IMPORTADOS">log de importados</a></li>
                    <li>|</li>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div class="titulo">
        <h1 id="titulo"></h1>
        <h2>Login: <?=NomeH1()?></h2>
    </div>
</div>