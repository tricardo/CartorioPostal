<?php include('includes.php'); 

$expansaoDAO = new ExpansaoDAO();

$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao2 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);


if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
} ?>



<!DOCTYPE html>
<html>
<head>
<title>SISTEMA CARTÓRIO POSTAL</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link href="images/cartoriopostal-ico.gif" type="image/png" rel="shortcut icon">
    <link href="css/print.css" type="text/css" rel="stylesheet">
</head>
<body>
<?php pt_register('GET','id_ficha'); 
$expansao = new ExpansaoDAO();
$c        = new stdClass();
$c->c_id_usuario = $controle_id_usuario;
$c->c_nome     = $controle_nome;
$c->id_ficha   = $id_ficha; 

$dti = $expansao->imprimir_ficha($c); 
$dt = UTF_Encodes($dti[0][0]); 
$dt1 = count($dti[1]) > 0 ? UTF_Encodes($dti[1][0]) : array(); 
$dt2 = count($dti[2]) > 0 ? UTF_Encodes($dti[2][0]) : array(); 
$dt3 = count($dti[3]) > 0 ? UTF_Encodes($dti[3][0]) : array(); 
$dt5 = count($dti[5]) > 0 ? UTF_Encodes($dti[5]) : array(); 
$dt6 = count($dti[6]) > 0 ? UTF_Encodes($dti[6][0]) : array(); 
$dt7 = count($dti[7]) > 0 ? UTF_Encodes($dti[7][0]) : array(); 
$dt8 = count($dti[8]) > 0 ? UTF_Encodes($dti[8][0]) : array(); 
$dt9 = count($dti[9]) > 0 ? UTF_Encodes($dti[9][0]) : array(); 
?> 
<table>
    <tr>
        <td colspan="2" class="titulo">INFORMAÇÕES DO CANDIDATO</td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* INFORMAÇÕES DO CANDIDATO</td>
    </tr>
    <tr>
        <td><label>Status: </label><?php echo $dt->status?></td>
        <td><label>data de cadastro: </label><?php echo $dt->data?></td>
    </tr>
    <tr>
        <td><label>Nome: </label><?php echo $dt->nome?></td>
        <td><label>E-MAIL: </label><span style="text-transform:lowercase"><?php echo ($dt->email)?></span></td>
    </tr>
    <tr>
        <td><label>RG: </label><?php echo $dt->rg?></td>
        <td><label>CPF: </label>
            <?php echo (isset($dt1->orgao_emissor) ? $expansao->orgao_emissor($dt1->orgao_emissor).' - ' : '').$dt->cpf?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><label>Data de Nascimento: </label><?php echo $dt->nascimento?></td>
    </tr>
    <tr>		
        <td><label>Residencial: </label><?php echo $dt->tel_res?></td>
        <td><label>Recado: </label><?php echo $dt->tel_rec?></td>
    </tr>
    <tr>
        <td colspan="2"><label>Celular: </label><?php echo $dt->tel_cel?></td>
    </tr>
    <tr>
        <td><label>Nacionalidade: </label><?php echo isset($dt->nacionalidade) ? $dt->nacionalidade : ''?></td>              
        <td><label>Local de Nascimento: </label><?php echo isset($dt1->local_nascimento) ? $dt1->local_nascimento : ''?></td>
    </tr>
    <tr>
        <td colspan="2"><label>Estado Civil: </label><?php echo $dt->estado_civil?></td>
    </tr>
    <tr>
        <td><label>Possui Filhos? </label><?php echo ($dt->filhos == 1) ? 'Sim':'Não'?></td>
        <td><label>Quantos? </label><?php echo $dt->filhos_quant?></td>
    </tr>
    <tr>
        <td><label>Data do Casamento: </label><?php echo isset($dt1->data_casamento) ? $dt1->data_casamento : ''?></td>
        <td><label>Regime de Casamento: </label><?php echo isset($dt1->regime) ? $dt1->regime : ''?></td>
    </tr>
    <tr>		
        <td><label>Nome do Pai: </label><?php echo isset($dt1->nome_pai) ? $dt1->nome_pai : ''?></td>
        <td><label>Nome da Mãe: </label><?php echo isset($dt1->nome_mae) ? $dt1->nome_mae :''?></td>
    </tr>
    <tr>		
        <td><label>Nome do Sócio: </label><?php echo isset($dt1->nome_socio) ? $dt1->nome_socio : ''?></td>
        <td><label>Profissão: </label><?php echo isset($dt1->profissao) ? $dt1->profissao : ''?></td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Endereço</td>
    </tr>
    <tr>		
        <td colspan="2">
            <label>Endereço: </label><?php echo $dt->endereco?> 
            <label>Nº.: </label><?php echo $dt->numero?>
        </td>
    </tr>
    <tr>		
        <td><label>Complemento: </label><?php echo $dt->complemento?></td>
        <td><label>Bairro: </label><?php echo $dt->bairro?></td>
    </tr>
    <tr>		
        <td><label>CEP: </label><?php echo $dt->cep?></td>
        <td><label>UF: </label><?php echo $dt->estado?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Cidade: </label><?php echo $dt->cidade?></td>
    </tr>
    <tr>		
        <td>
            <label>Tipo do Imóvel: </label><?php if(isset($dt1->tip_imovel)){switch($dt1->tip_imovel){
                case 1: echo 'Própria'; break;
                case 2: echo 'Alugada'; break;
            case 3: echo 'Familiares'; break; }} ?>
        </td>
        <td><label>Reside na Praça Desde: </label><?php echo isset($dt1->reside_praca) ? $dt1->reside_praca : ''?></td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Último Endereço</td>
    </tr>
    <tr>		
        <td colspan="2">
            <label>Endereço: </label><?php echo isset($dt2->endereco) ? $dt2->endereco : ''?> 
            <label>Nº.: </label><?php echo isset($dt2->numero) ? $dt2->numero : ''?>
        </td>
    </tr>
    <tr>		
        <td><label>Complemento: </label><?php echo isset($dt2->complemento) ? $dt2->complemento : ''?></td>
        <td><label>Bairro: </label><?php echo isset($dt2->bairro) ? $dt2->bairro : ''?></td>
    </tr>
    <tr>		
        <td><label>CEP: </label><?php echo isset($dt2->cep) ? $dt2->cep : ''?></td>
        <td><label>UF: </label><?php echo isset($dt2->estado) ? $dt2->estado : ''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Cidade: </label><?php echo isset($dt2->cidade) ? $dt2->cidade: ''?></td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Dados Pessoais do Cônjuge</td>
    </tr>
    <tr>		
        <td><label>Nome: </label><?php echo isset($dt3->nome) ? $dt3->nome : ''?></td>
        <td><label>E-MAIL: </label><span><?php echo isset($dt3->email) ? $dt3->email :''?></span></td>
    </tr>
    <tr>		
        <td><label>rg: </label><?php echo isset($dt3->rg) ? $dt3->rg : ''?></td>
        <td><label>cpf: </label><?php echo isset($dt3->cpf) ? $dt3->cpf : ''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>data de nascimento: </label><?php echo isset($dt3->nascimento) ? $dt3->nascimento : ''?></td>		
    </tr>
    <tr>		
        <td><label>Nome do pai: </label><?php echo isset($dt3->nome_pai) ? $dt3->nome_pai : ''?></td>
        <td><label>Nome da mãe: </label><?php echo isset($dt3->nome_mae) ? $dt3->nome_mae : ''?></td>
    </tr>
    <tr>		
        <td><label>profissao: </label><?php echo isset($dt3->profissao) ? $dt3->profissao : ''?></td>
        <td><label>cargo: </label><?php echo isset($dt3->cargo) ? $dt3->cargo : ''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>empresa: </label><?php echo isset($dt3->empresa) ? $dt3->empresa : ''?></td>		
    </tr>
    <tr>		
        <td><label>telefone: </label><?php echo isset($dt3->telefone) ? $dt3->telefone : ''?></td>
        <td><label>admissão: </label><?php echo isset($dt3->admissao) ? $dt3->admissao : ''?></td>
    </tr>
    <tr>		
        <td colspan="2">
            <label>Endereço da empresa: </label><?php echo isset($dt3->end_empresa) ? $dt3->end_empresa : ''?> 
            <label style="width:40px">Nº.: </label><?php echo isset($dt3->numero) ? $dt3->numero: ''?>
        </td>
    </tr>
    <tr>		
        <td><label>complemento: </label><?php echo isset($dt3->complemento) ? $dt3->complemento : ''?></td>
        <td><label>bairro: </label><?php echo isset($dt3->bairro) ? $dt3->bairro : ''?></td>
    </tr>
    <tr>		
        <td><label>cep: </label><?php echo isset($dt3->cep) ? $dt3->cep : ''?></td>
        <td><label>uf: </label><?php echo isset($dt3->estado) ? $dt3->estado : ''?></td>
    </tr>
</table>
<table>
    <tr>
        <td colspan="2" class="titulo">INFORMAÇÕES EMPRESARIAIS</td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* INFORMAÇÕES EMPRESARIAIS</td>
    </tr>
    <tr>		
        <td><label>Deseja ser? </label><?php echo isset($dt1->franqueado) ? $dt1->franqueado : ''?></td>
        <td><label>Experiência com Franq.? </label><?php echo isset($dt1->experiencia) ? (($dt1->experiencia == 1) ? 'Sim':'Não'):''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Se Não, Qual o Motivo de Não Possuir o Negócio?</label><?php echo isset($dt1->motivo) ? $dt1->motivo : ''?></td>		
    </tr>
    <tr>		
        <td><label>Número de Funcionários: </label><?php echo isset($dt1->funcionarios2) ? $dt1->funcionarios2 :''?></td>
        <td><label>Faturamento: </label><?php echo isset($dt->faturamento) ? $dt->faturamento : ''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Qual Franquia?</label><?php echo isset($dt1->qual_franquia) ? $dt1->qual_franquia : ''?></td>		
    </tr>
    <tr>		
        <td colspan="2"><label>Na sua Opinião Quais os Fatores Determinantes para o Sucesso de um Negócio?</label><?php echo isset($dt1->opiniao) ? $dt1->opiniao : ''?></td>		
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Histórico Profissional</td>
    </tr>
    <tr>		
        <td><label>Empresa: </label><?php echo $dt->empresa_t?></td>
        <td><label>Cargo Atual: </label><?php echo $dt->cargo?></td>
    </tr>
    <tr>		
        <td colspan="2">
                    <label>Faça um Breve Relato Sobre seu Histórico:</label><?php echo $dt->historico?>
        </td>
    </tr>
    <tr>		
        <td><label>Período: </label><?php echo $dt->periodo?></td>
        <td><label>Funcionários: </label><?php echo $dt->funcionarios?></td>
    </tr>
    <tr>		
        <td><label>Faturamento: </label><?php echo $dt->faturamento?></td>
        <td><label>contato: </label><?php echo isset($dt1->contato) ? $dt1->contato : ''?></td>
    </tr>
    <tr>		
        <td><label>Ramo de Atuação: </label><?php echo $dt->ramo_at?></td>
        <td><label>Nome da Empresa: </label><?php echo $dt->empresa_p?></td>
    </tr>
    <tr>		
        <td><label>Grau de Escolaridade: </label><?php echo $dt->cursos?></td>
        <td><label>Nome da Empresa: </label><?php echo $dt->escolaridade?></td>
    </tr>
    <tr>		
        <td><label>Qual Faculdade: </label><?php echo isset($dt1->faculdade) ? $dt1->faculdade : ''?></td>
        <td><label>Ano de Conclusão: </label><?php echo isset($dt1->conclusao) ? $dt1->conclusao : ''?></td>
    </tr>
    <tr>		
        <td colspan="2">
                    <label>Tem ou Teve Negócio Próprio? </label><?php echo ($dt->negocios == 1) ? 'Sim':'Não'?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Sobre a Franquia Cartório Postal</td>
    </tr>
    <tr>		
        <td colspan="2">
            <label  style="font-weight:bold">Enumere o que você considera importante na franquia Cartório Postal, sendo que o número 1 é o mais importante:</label>
            <?php if(isset($dt5)){ foreach($dt5 as $b => $res){
            echo $res->valor . ' - '. $res->pergunta.''; }}  ?>
        </td>
    </tr>
    <tr>		
        <td colspan="2"><label>Como Conheceu as Franquias Cartório Postal:</label><?php echo $dt->conheceu_cp?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Já Esteve em uma de Nossas Unidades? </label><?php echo ($dt->unidades == 1) ? 'Sim':'Não'?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Qual? </label><?php echo $dt->unidades_valor?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Deseja Receber Comunicados de Outras Empresas da Rede?  </label><?php echo ($dt->comunicados == 1) ? 'Sim':'Não'?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Porque o Interesse em ser um Franqueado? </label><?php echo $dt->interesse?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Selecione o Estado e a Cidade de Interesse: </label><?php echo $dt->estado_interesse.' / '.$dt->cidade_interesse?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Seu Espaço Para Observações: </label><?php echo $dt->observacao?></td>
    </tr>
</table>
<table>
    <tr>
        <td colspan="2" class="titulo">INFORMAÇÕES BANCÁRIAS</td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Referências Bancárias</td>
    </tr>
    <tr>		
        <td><label>Banco: </label><?php echo isset($dt6->banco) ? $dt6->banco : ''?></td>
        <td><label>Cartão de Crédito: </label><?php echo isset($dt6->cartao_credito) ? $dt6->cartao_credito : ''?></td>
    </tr>
    <tr>		
        <td><label>Vencimento: </label><?php echo isset($dt6->vencimento) ? $dt6->vencimento : ''?></td>
        <td><label>Limite: </label><?php echo isset($dt6->limite) ? $dt6->limite : ''?></td>
    </tr>
    <tr>		
        <td><label>Nome do Gerente: </label><?php echo isset($dt6->nome_gerente) ? $dt6->nome_gerente : ''?></td>
        <td><label>Agência e Conta: </label><?php echo isset($dt6->agencia_conta) ? $dt6->agencia_conta : ''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Telefone: </label><?php echo isset($dt6->telefone_banco) ? $dt6->telefone_banco : ''?></td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Demonstrativo de Rendimento</td>
    </tr>
    <tr>		
        <td><label>Honorários: </label><?php echo isset($dt7->honorarios) ? $dt7->honorarios : ''?></td>
        <td><label>Salários: </label><?php echo isset($dt7->salarios) ? $dt7->salarios : ''?></td>
    </tr>
    <tr>		
        <td><label>Comissões: </label><?php echo isset($dt7->comissoes) ? $dt7->comissoes : ''?></td>
        <td><label>Salário do Conjuge: </label><?php echo isset($dt7->salario_conjuge) ? $dt7->salario_conjuge : ''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Renda de Aluguéis: </label><?php echo isset($dt7->renda_alugueis) ? $dt7->renda_alugueis: ''?></td>		
    </tr>
    <tr>		
        <td colspan="2"><label>Possui Empréstimos Financeiros: </label><?php echo isset($dt7->emprestimo_financeiro) ? $dt7->emprestimo_financeiro : ''?></td>
    </tr>
    <tr>
        <td colspan="2">* Bens de Consumo</td>
    </tr>
    <tr>		
        <td><label>Modelo do Veículo: </label><?php echo isset($dt8->modelo_veiculo) ? $dt8->modelo_veiculo:''?></td>
        <td><label>Marca do Veículo: </label><?php echo isset($dt8->marca_veiculo) ? $dt8->marca_veiculo : ''?></td>
    </tr>
    <tr>		
            <td><label>Ano do Veículo: </label><?php echo isset($dt8->ano_veiculo) ? $dt8->ano_veiculo : ''?></td>
            <td><label>Placa do Veículo: </label><?php echo isset($dt8->placa_veiculo) ? $dt8->placa_veiculo:''?></td>
    </tr>
    <tr>		
        <td><label>Valor do Veículo: </label><?php echo isset($dt8->valor_veiculo) ? $dt8->valor_veiculo:''?></td>		
        <td><label>Financiado? </label><?php echo isset($dt8->financiado)?$dt8->financiado:''?></td>
    </tr>
    <tr>		
        <td><label>Imóvel: </label><?php echo isset($dt8->imovel)?$dt8->imovel:''?></td>		
        <td><label>Valor Venal: </label><?php echo isset($dt8->valor_venal)?$dt8->valor_venal:''?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Somatória do Valor Financiado: </label><?php echo isset($dt8->somatoria) ? $dt8->somatoria:''?></td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* Informações Adicionais</td>
    </tr>
    <tr>		
        <td colspan="2"><label>Tem Capital Imediato Disponível para Investir? </label><?php echo $dt->capital?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Valor Disponível: </label><?php echo $dt->valor_disp?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Informe se Depende de Empréstimo ou Venda de Bens para Investir em sua Franquia Cartório Postal: </label><?php echo $dt->emprestimo?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Informe se o Capital Citado for de Terceiros: </label><?php echo $dt->capital_terc?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Quando Pretende dar Início ao Negócio? </label><?php echo $dt->inicio_neg?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Qual o seu Tempo Dedicado a Franquia? </label><?php echo $dt->dedicado_franq?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>A Franquia Será a Principal Fonte de Renda? </label><?php echo $dt->fonte_renda?></td>
    </tr>
    <tr>		
        <td colspan="2"><label>Pretende Ter Sócios? Especifique. </label><?php echo $dt->socios?></td>
    </tr>
</table>
<table>
    <tr>
        <td colspan="2" class="titulo">INFORMAÇÕES JURÍDICAS</td>
    </tr>
    <tr>
        <td colspan="2" class="subtitulo">* INFORMAÇÕES JURÍDICAS</td>
    </tr>
    <tr>		
        <td><label>Tipo da Franquia: </label><?php if(isset($dt9->tipo_franquia)){switch($dt9->tipo_franquia){
                case 1: echo 'Master'; break;
                case 2: echo 'Unitária'; break;
                case 3: echo 'Subfranquia'; break;
                case 4: echo 'Internacional'; break; }} ?>
        </td>		
        <td><label>N.º COF: </label><?php echo isset($dt9->num_cof) ? $dt9->num_cof:''?></td>
    </tr>
    <tr>		
        <td><label>Valor da COF: </label><?php echo isset($dt9->valor_cof)?$dt9->valor_cof:''?></td>		
        <td><label>Forma de Pagto.: </label><?php echo isset($dt9->forma_pagto)?$dt9->forma_pagto:''?></td>
    </tr>
    <tr>		
        <td><label>Origem: </label><?php if(isset($dt9->origem)){switch($dt9->origem){
                case 1: echo 'ABF'; break;
                case 2: echo 'E-mail'; break;
        case 3: echo 'Site'; break;  }} ?></td>		
        <td><label>Valor Efetivo: </label><?php echo isset($dt9->valor_efetivo)?$dt9->valor_efetivo:''?></td>
    </tr>
    <tr>		
        <td><label>Valor do Royaltie: </label><?php echo isset($dt9->valor_royaltie)? $dt9->valor_royaltie:''?></td>		
        <td><label>N.º COF Emitido: </label><?php echo isset($dt9->num_cof_emitida)?(($dt9->num_cof_emitida == 1) ?'Sim':'Não'):'';?></td>
    </tr>
</table>
<table>
    <tr>
        <td colspan="5" class="titulo">Histórico</td>
    </tr>
    <tr>
        <td class="list">Status</td>
        <td class="list">Consultor</td>
        <td class="list">Forma de Contato</td>
        <td class="list">Reunião</td>
        <td class="list">Data</td>
    </tr>
    <?php $historico = $expansao->listaHistoricoPrint($c->id_ficha); 
    for($i = 0; $i < count($historico); $i++){ ?>
    <tr>
        <td><?php
                $st = $expansao->PegaStatus($historico[$i]->id_status);
                echo $st[0]->status;
        ?></td>
        
        
        <td><?php $us = $expansao->pega_usuario($historico[$i]->id_user_alt);
                echo (isset($us[0]->nome) AND strlen($us[0]->nome) > 0) ? utf8_encode($us[0]->nome) : 'Cadastrado pelo Sistema'; ?>
        </td>
        <td><?=$expansaoDAO->forma_pagto2(2, $historico[$i]->forma_pagto);?></td>
        <td><?php
        #print_r($historico);exit;
        if($historico[$i]->data_reuniao != '0000-00-00'){
                switch($dt->id_status){
                    case 5: case 10: case 12: case 19:
                        echo verifica_invert_data($historico[$i]->data_reuniao, 1, '/', '', $hora = '');
                        break;
                    default: echo '-';
                }
            }
        ?></td>
        <td><?php 
                $data = explode(' ',$historico[$i]->data_inclusao);
                $hora = $data[1];
                $data = explode('-', $data[0]);
                echo $data[2].'/'.$data[1].'/'.$data[0].' '.$hora;
        ?></td>
    </tr>
    <?php if(strlen($historico[$i]->observacao) > 0){?>
    <tr>
        <td colspan="5" class="obs"><?php echo $historico[$i]->observacao?></td>
    </tr>
    <?php }} ?>
</table>
<table class="assinatura">
    <tr>
        <td>Cartório Postal - <?php echo date('d/m/Y H:i:s')?>&nbsp;&nbsp;</td>
    </tr>
</table>
<script>window.print();</script>
</body>
</html>
     