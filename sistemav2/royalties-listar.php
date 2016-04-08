<?php include('header.php'); 


$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!=1){
    header('location:pagina-erro.php');
    exit;
}

$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();


$show_msgbox = 0;


$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca_situacao = isset($c->busca_situacao) ? $c->busca_situacao : '';
$c->busca_id_empresa = isset($c->busca_id_empresa) ? $c->busca_id_empresa : '';
$c->busca_mes = isset($c->busca_mes) ? $c->busca_mes : '';
$c->busca_ano = isset($c->busca_ano) ? $c->busca_ano : date('Y');

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= strlen($c->busca_situacao) > 0 ? '&busca_situacao='.$c->busca_situacao : '';
$link .= strlen($c->busca_id_empresa) > 0 ? '&busca_id_empresa='.$c->busca_id_empresa : '';
$link .= strlen($c->busca_mes) > 0 ? '&busca_mes='.$c->busca_mes : '';
$link .= strlen($c->busca_ano) > 0 ? '&busca_ano='.$c->busca_ano : '';

$busca = new stdClass();
$busca->id_empresa=$c->busca_id_empresa;
$busca->ano=$c->busca_ano;
$busca->mes=$c->busca_mes;
$busca->situacao=$c->busca_situacao;
$busca->id_empresa=$c->busca_id_empresa;


$acao_direcionamento = '';
$big_msg_box_color = '';
if($_GET OR $_POST){
    if($_POST){
        $p = UTF_Encodes(Post_StdClass($_POST), 2);
        $acao_direcionamento = isset($_POST['acao_direcionamento']) ? $p->acao_direcionamento : '';
    }
    if($acao_direcionamento == ''){
        $acao_direcionamento = isset($_GET['acao_direcionamento']) ? $c->acao_direcionamento : '';        
    }
    if($acao_direcionamento != ''){
        switch($acao_direcionamento){
            case 'aprovar': include('royalties-listar-aprovar.php'); break;
        }  
    }
}
?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; royalties');
    $('#sub-30').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" id="form1" name="form1">       
        <dl>
            <legend>Buscar Royalties</legend>
            <dt>Situação:</dt>
            <dd>
                <select name="busca_situacao" id="busca_situacao" class="chzn-select">		
                    <option value="" <?=$c->busca_situacao=='' ? 'selected="select"' : ''; ?>>À Receber</option>		
                    <option value="1" <?=$c->busca_situacao=='1' ? 'selected="select"' : ''; ?>>Recebido</option>
                    <option value="2" <?=$c->busca_situacao=='2' ? 'selected="select"' : ''; ?>>Ambos</option>		
                </select>
            </dd>
            <dt>Unidades:</dt>
            <dd>
                <select name="busca_id_empresa" id="busca_id_empresa" class="chzn-select">		
                    <option value="" <?=($c->busca_id_empresa=='') ? ' selected="selected" ' : ''; ?>>Todos</option>		
                    <?php $p_valor = '';			
                    $var = $empresaDAO->listarTodasRoy();
                    foreach($var as $s){
                        $p_valor .= '<option value="'.$s->id_empresa.'"'.(($c->busca_id_empresa==$s->id_empresa) ? ' selected="selected" ' : '').'>'.utf8_encode(str_replace('Cartório Postal - ','',$s->fantasia)).'</option>';			
                    }			
                    echo $p_valor;		 
                    ?>        	
                </select>
            </dd>
            <dt>Mês:</dt>
            <dd>
                <select id="busca_mes" name="busca_mes" class="chzn-select">
                    <option value="">Todos</option>
                    <?php foreach(DataAno() AS $p => $f){ ?>
                    <option value="<?=$p?>"<?=$p==$c->busca_mes ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Ano:</dt>
            <dd>
                <select id="busca_ano" name="busca_ano" class="chzn-select">
                    <option value="">Todos</option>
                    <?php foreach(DataAno(2) AS $p => $f){ ?>
                    <option value="<?=$p?>"<?=$p==$c->busca_ano ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select>
            </dd>
            <div class="buttons">
                <input type="hidden" id="NoStatusCheck" value="royalties-listar.php<?=$link?>">
                <input type="hidden" id="acao_direcionamento" name="acao_direcionamento">
                <input type="hidden" id="hash" name="hash" value="<?=date('s')?>">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
        <?php if(($_GET OR $_POST) AND $c->busca_situacao==''){?>
        <dl>
            <div class="buttons">
                <input type="button" value="aprovar &rsaquo;&rsaquo;" onclick="RoyaltiesConfirm(1,'aprovar',1)">
            </div>
        </dl>
         <?php } ?>
    </form>
</div>

<div class="content-list-table">   
<?php
if($_GET){ 
    $buscapedido = $financeiroDAO->buscaRecebimentoRoy($busca,$controle_id_empresa,$c->pagina);
    if(count($buscapedido) > 0){  ?>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr style="background: transparent">
                    <th colspan="9" style="background: transparent">
                        <?php
                        echo '  <strong>Valor Royalties:</strong> R$ '.$buscapedido[0]->valor_roy_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|
                        <strong>Valor FPP: </strong> '.$buscapedido[0]->valor_fpp_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|
                        <strong>Valor Total: </strong> '.$buscapedido[0]->valor_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|
                        <strong>Valor Recebido:</strong> '.$buscapedido[0]->valor_rec_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|
                        <strong>Valor Juros: </strong> '.$buscapedido[0]->valor_juros_roy_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|';
                        $saldo = $buscapedido[0]->valor_t-$buscapedido[0]->valor_rec_t;
                        echo ($saldo>0) ? '<strong>À Receber: </strong> '.$saldo : '';  ?>
                    </th>
                </tr>
                <tr>
                    <th class="buttons"><input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check1','royalties')"></th>
                    <th class="buttons">#</th>
                    <th>unidade</th>	
                    <th class="buttons">data ref.</th>	
                    <th class="buttons size100">royalties dev.</th>	
                    <th class="buttons size100">royalties rec.</th>	
                    <th class="buttons size100">fpp devedor</th>	
                    <th class="buttons size100">fpp recebido</th>	
                    <th class="buttons">visualizar</th>
                </tr>
            </thead>
            <tbody>
                 <?php $color = '#FFFEEE';
                foreach($buscapedido as $p){ 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';   ?>
                     <tr <?=TRColor($color)?>>
                        <td class="buttons"><input <?=((isset($_SESSION['royalties']) AND count($_SESSION['royalties']) > 0 AND in_array($p->id_rel_royalties, $_SESSION['royalties'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_royalties[]" id="id_royalties<?=$p->id_rel_royalties?>" value="<?=$p->id_rel_royalties?>" class="check1" onclick="CkechSession(1,this.id,'royalties')"></td>
                        <td class="buttons"><?=$p->id_rel_royalties?></td>
                        <td><?=utf8_encode(ucwords(strtolower($p->fantasia)))?></td>
                        <td class="buttons"><?=$p->ref?></td>
                        <td class="buttons size100"><?=$p->roy?></td>
                        <td class="buttons size100"><?=$p->roy_rec?></td>
                        <td class="buttons size100"><?=$p->fpp?></td>
                        <td class="buttons size100"><?=$p->fpp_rec?></td>
                        <td class="buttons">
                            <input type="hidden" id="bt_ref<?=$p->id_rel_royalties?>" name="bt_ref<?=$p->id_rel_royalties?>" value="<?=$p->ref?>">
                            <input type="hidden" id="bt_emp<?=$p->id_rel_royalties?>" name="bt_emp<?=$p->id_rel_royalties?>" value="<?=$p->id_empresa?>">
                            <a href="#" onclick="RoyaltiesConfirm(0,'listar',<?=$p->id_rel_royalties?>)"><img src="images/bt-view.png"></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>   
        </table>
        <div class="paginacao">
            <?php $financeiroDAO->QTDPagina(); ?>
        </div>
    <?php 
    } else { 
        RetornaVazio();
        $zera_sessao = 1;
    }    
} else {
    RetornaVazio(2);
    $zera_sessao = 1;
} 
if(isset($zera_sessao)){ 
    echo "<script>CkechSession(3,'.check3','zera_sessao')</script>";
} ?>
</div>
<?php include('footer.php'); ?>