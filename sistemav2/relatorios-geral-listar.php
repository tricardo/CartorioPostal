<?php
switch($pagina){
    case 'atendimento':
        $titulo = 'Atendimento';
        $sub = 33;
        
        $arr = array(); 
        if (verifica_permissao('Rel_comercial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE') {
            $arr[] = array('relatorios-pedidos-faturamento-por-cliente-corporativo.php','Faturamento por Cliente Corporativo','');
        }
        if ((verifica_permissao('Supervisor Atendimento', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
            or (verifica_permissao('Supervisor Financeiro', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
        ){
            $arr[] = array('relatorios-geral.php','Aguardando Identificação de Depósito (Conciliação)','conciliacao');
            $arr[] = array('relatorios-geral.php','Pedidos Cancelados','cancelados');
            $arr[] = array('relatorios-pedidos-cadastrados-no-periodo.php','Pedidos Cadastrados no Período','');
            $arr[] = array('relatorios-geral.php','Pedidos Em Aberto por Período','em-aberto');
            $arr[] = array('relatorios-geral.php','Orçamentos Enviados','orcamento');
            $arr[] = array('relatorios-pedidos-fechados-no-dia.php','Pedidos Fechados no dia','');
            $arr[] = array('relatorios-vendas-por-atendente.php','Vendas por Atendente / Origem','');
        }
        

        break;
    
    case 'diretoria':
        $titulo = 'Diretoria';
        $sub = 34;
        $arr = array();
        if(verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){
            $arr[] = array('relatorios-despesa-por-servico.php','Despesa por Serviço','');
            $arr[] = array('relatorios-geral.php','Gerencial Completo','geral');
        }
        break;
    
    case 'expansao':
        $titulo = 'Expansão';
        $sub = 35;
        $arr = array();
        if(verifica_permissao('EXPANSAO_S', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' AND $controle_id_empresa == 1){
            $arr[] = array('relatorios-pipeline.php','Pipeline',''); 
        }
        break;
    
    case 'financeiro':
        $titulo = 'Financeiro';
        $sub = 36;
        $arr = array(); 
        if(verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){
            $arr[] = array('relatorios-royalties-e-faturamento-de-franquia.php','Royalties e Faturamento de Franquia','');
            $arr[] = array('relatorios-geral.php','Conciliação Franquia','conciliacao_franquia');
            $arr[] = array('relatorios-pedidos-recebidos-de-outras-franquias.php','Pedidos Recebidos de outras Franquias','');
        }
        if(verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){
            $arr[] = array('relatorios-separado-por-banco.php','Depósito separado por Banco','');
            $arr[] = array('relatorios-fluxo-de-caixa.php','Fluxo de Caixa','');
            $arr[] = array('relatorios-pedidos-a-faturar.php','Pedidos à faturar','');
        }
        if (verifica_permissao('Rel_comercial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Financeiro_rel', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE' or verifica_permissao('Rel_gerencial', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE') {
            $arr[] = array('relatorios-pedidos-faturamento-por-cliente-corporativo.php','Faturamento por Cliente Corporativo','');
        }
        if ((verifica_permissao('Supervisor Atendimento', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
            or (verifica_permissao('Supervisor Financeiro', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE')
        ){
            $arr[] = array('relatorios-geral.php','Aguardando Identificação de Depósito (Conciliação)','conciliacao');
            $arr[] = array('relatorios-geral.php','Pedidos Cancelados','cancelados');
            $arr[] = array('relatorios-pedidos-cadastrados-no-periodo.php','Pedidos Cadastrados no Período','');
            $arr[] = array('relatorios-geral.php','Pedidos Em Aberto por Período','em-aberto');
            $arr[] = array('relatorios-geral.php','Orçamentos Enviados','orcamento');
            $arr[] = array('relatorios-pedidos-fechados-no-dia.php','Pedidos Fechados no dia','');
            $arr[] = array('relatorios-vendas-por-atendente.php','Vendas por Atendente / Origem','');
        }
        break;
    
    case 'franquia':
        $titulo = 'Franquia';
        $sub = 37;
        $arr = array();
        $id_departamento_s = explode(',', $controle_id_departamento_s);
        if ($controle_id_empresa == 1 and in_array(17, $id_departamento_s) == 1) {
            $arr[] = array('relatorios-planejamento-economico-financeiro.php','Planejamento Econômico Financeiro','');
            $arr[] = array('relatorios-mensal-consolidado.php','Mensal Consolidado','');
            $arr[] = array('relatorios-anual-consolidado.php','Anual Consolidado','');
        }
        break;
    
    case 'operacional':
        $titulo = 'Operacional';
        $sub = 38;
        $arr = array();
        if(verifica_permissao('Rel_supervisores', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){
            $arr[] = array('relatorios-por-departamento.php','Por Departamento','');
        }
        if(verifica_permissao('Rel_n_supervisores', $controle_id_departamento_p, $controle_id_departamento_s) == 'TRUE'){
            $arr[] = array('relatorios-concluido-operacional.php','Concluído Operacional','');
        }
        if ($controle_id_empresa == 1 and isset($controle_depto_p['27']) AND $controle_depto_p['27'] == '1'){
            $arr[] = array('relatorios-adendo.php','Adendo','');
        }
        break;
}
if(count($arr) == 0){
    header('location:pagina-erro.php');
    exit;
}
sort($arr); ?>
<script>
    menu(3,'bt-05');
    $('#titulo').html('relatórios &rsaquo;&rsaquo; <?=$titulo?>');
    $('#sub-<?=$sub?>').css({'font-weight':'bold'});
</script>

<div class="content-list-forms"></div>
<div class="content-list-table"> 
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th>relatório</th>
                    <th class="buttons">visualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                $i = 1;
                if(count($arr) > 0){
                foreach($arr AS $f){  
                    $color = $color == '#FFFEEE' ? '#FFF' : '#FFFEEE'?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons"><?=$i?></td>
                        <td><?=$f[1]?></td>
                        <td class="buttons"><a href="<?=$f[0].'?'.(strlen($pagina) > 0 ? 'pg='.$pagina : '').(strlen($f[2]) > 0 ? '&rel='.$f[2]:'')?>"><img src="images/bt-message.png"></a></td>
                    </tr>
                <?php $i++; }} ?>
            </tbody>
        </table>
        <script>PaginacaoWidth()</script>
</div>
<?php include('footer.php'); ?>