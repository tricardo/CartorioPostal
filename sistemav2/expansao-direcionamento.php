<?php include('header.php'); 

$expansaoDAO = new ExpansaoDAO();

$permissao = verifica_permissao('EXPANSAO_S',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$exp_item = $expansaoDAO->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);

if(isset($_GET['acao'])){
    pt_register('GET','acao');
    pt_register('GET','id_consultor');
    
    $big_msg_box = 'Você deve marcar algum registro para prosseguir com a ação!';
    
    if(isset($_SESSION['expansao']) AND count($_SESSION['expansao']) > 0){
        switch($acao){
            case 'direcionar':
                $big_msg_box .='<br><br>Você deve selecionar um consultor na caixa de seleção "Direcionar Para"!';
                if(isset($id_consultor) AND is_numeric($id_consultor)){
                   $big_msg_box = 'Registros direcionados com sucesso!';
                   $c->id_ficha = $_SESSION['expansao'];
                   $c->consultor2 = $id_consultor;
                   $expansaoDAO->direcionar($c);
                   define('CHK_NULL',1);
                } 
                break;
                
                case 'duplicidade':
                    $big_msg_box = 'Registros excluídos com sucesso!';
                    $expansaoDAO->excluir_duplicidade($controle_id_usuario,$_SESSION['expansao']);
                    define('CHK_NULL',1);
                break;
        }
        
        if(defined('CHK_NULL')){
            $_SESSION['expansao'] = array();
        }
    }
}




$arr = array('consultor','id_status','cidade','mes','nome','uf','ano','id_ficha','id_ficha2','c_id_usuario');
$c = Post_StdClass($_GET);
for($i = 0; $i < count($arr); $i++){
    $c->$arr[$i] = isset($c->$arr[$i]) ? $c->$arr[$i] : '';
}
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->sem_consultor = 0;

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
?>
<script>
    menu(3,'bt-03');
    $('#titulo').html('expansão &rsaquo;&rsaquo; direcionamento');
    $('#sub-20').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Ficha</legend>
            <dt>Consultor: </dt>
            <dd>
                <?php $expansaoDAO->carregar_consultor($exp_item, $c); ?>
            </dd>
            <dt>Direcionar Para:</dt>
            <dd><?php $exp_item->consultor2 = 1; $expansaoDAO->carregar_consultor2($exp_item, $c); ?></dd>
            <dt>Status: </dt>
            <dd>
                <?php $expansaoDAO->carregar_status($exp_item, $c); ?>
            </dd>
            <dt></dt>
            <dd></dd>
            <dt>Nº Ficha: </dt>
            <dd>
                <input value="<?=$c->id_ficha?>" type="text" name="id_ficha" id="id_ficha">
            </dd>
            <dt>Nome: </dt>
            <dd>
                <input value="<?=$c->nome?>" type="text" name="nome" id="nome" placeholder="Nome">
            </dd>
            <dt>Estado:</dt>
            <dd>
                <select class="chzn-select required" name="uf" id="uf">
                    <option value="">Estado</option>
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $c->uf) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Cidade:</dt>
            <dd>
                <input value="<?=$c->cidade?>" type="text" name="cidade" id="cidade" placeholder="Cidade">
            </dd>
            </dd>
            
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="button" value="direcionar &rsaquo;&rsaquo;" onclick="location.href=window.location.pathname+'?acao=direcionar&id_consultor='+$('#consultor2').val()">
                <input type="button" value="duplicidade &rsaquo;&rsaquo;" onclick="location.href=window.location.pathname+'?acao=duplicidade'">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
            
            <div class="instrictions">
                    <p>
                        <strong class="active">Observações:</strong><br>
                        * Para usar a função 'Direcionamento', você deve selecionar
                        um consultor na caixa de seleção 'Direcionar Para' e marcar
                        qual registro deverá sofrer alteração na listagem abaixo;<br>
                        * Para usar a função 'Duplicidade', você deve marcar 
                        qual registro deverá sofrer alteração na listagem abaixo,
                        com isso o registro será excluído;
                    </p>
                </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
if($_GET){ 
    $listar = $expansaoDAO->direcionamento($c); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $expansaoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons chk"><input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id);CkechSession(2,'.check1','expansao')"></th>
                    <th class="buttons">#</th>
                    <th class="buttons size100">cadastro</th>
                    <th class="buttons size150">status</th>
                    <th>nome</th>
                    <th>cidade/estado</th>
                    <th>consultor</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $res) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons chk"><input <?=((isset($_SESSION['expansao']) AND count($_SESSION['expansao']) > 0 AND in_array($res->id_ficha, $_SESSION['expansao'])) ? 'checked="checked"' : '')?> type="checkbox" name="id_ficha[]" id="ficha<?=$res->id_ficha?>" value="<?=$res->id_ficha?>" class="check1" onclick="CkechSession(1,this.id,'expansao')"></td>
                    <td class="buttons"><?=$res->id_ficha?></td>
                    <td class="buttons size100"><?=$res->data?></td>
                    <td class="buttons size150"><?=utf8_encode(ucwords($res->status))?></td>
                    <td><?=utf8_encode(ucwords($res->nome))?></td>
                    <td><?=utf8_encode(ucwords(substr($res->cidade,0,100)).' / '.$res->uf)?></td>
                    <td><?=utf8_encode($res->consultor)?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $expansaoDAO->QTDPagina(); ?>
        </div>
        <script>PaginacaoWidth()</script>
    <?php } else { 
        RetornaVazio();
    } 
} else {
    RetornaVazio(2);
} ?>
</div>
<?php include('footer.php'); ?>