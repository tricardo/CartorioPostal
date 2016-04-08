<?php include('header.php'); 

$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$sDepartamentoDAO = new ServicoDepartamentoDAO();
$servicoDAO = new ServicoDAO();

$c = Post_StdClass($_GET);
$c->busca_id_departamento = isset($c->busca_id_departamento) ? $c->busca_id_departamento : 0;
$c->busca_id_servico = isset($c->busca_id_servico) ? $c->busca_id_servico : 0;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
        
$show_msgbox = 0;
$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca_id_departamento) AND $c->busca_id_departamento > 0) ? '&busca_id_departamento='.$c->busca_id_departamento : '';
$link .= (isset($c->busca_id_servico) AND $c->busca_id_servico > 0) ? '&busca_id_servico='.$c->busca_id_servico : '';
?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; serviços');
    $('#sub-24').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Serviços</legend>
            <dt>Departamento:</lab</dt>
            <dd>
                <select name="busca_id_departamento" id="busca_id_departamento"	onchange="CarregaServico(this.value,0)" class="chzn-select">
                    <option value="0"<?=($c->busca_id_departamento=='') ? ' selected="selected" ' : '' ?>>Todos</option>
                        <?php
                        $p_valor='';
                        foreach($departamentos = $sDepartamentoDAO->listar() as $departamento){
                            $p_valor.='<option value="'.$departamento->id_servico_departamento.'"';
                            $p_valor.=($c->busca_id_departamento==$departamento->id_servico_departamento)?' selected="selected" ':'';
                            $p_valor.='>'.utf8_encode($departamento->departamento).'</option>';
                        }
                        echo $p_valor; ?>
                </select>
            </dd>
            <dt>Serviço:</dt>
            <dd>
                <div id="ajax_busca_id_servico"></div>
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
                <script>CarregaServico(<?=$c->busca_id_departamento?>,<?=$c->busca_id_servico?>)</script>
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
if($_GET){ 
    $listar =  $servicoDAO->busca($controle_id_empresa,$c->busca_id_departamento,$c->busca,
            $c->busca_id_servico,isset($c->pagina) ? $c->pagina : 1); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $servicoDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>departamento</th>
                    <th>descrição</th>
                    <th>variação</th>
                    <th class="buttons size100">valor</th>
                    <th class="buttons size100">dias</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';
                    ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_servico_var?></td>
                    <td class="buttons"><?=$f->status;?></td>
                    <td><?=utf8_encode($f->departamento)?></td>
                    <td><?=utf8_encode($f->descricao)?></td>
                    <td><?=utf8_encode($f->variacao)?></td>
                    <td class="buttons"><input type="text" class="money" id="valor<?=$f->id_servico_var?>" name="valor<?=$f->id_servico_var?>" value="<?=$f->valor?>"></td>
                    <td class="buttons"><input type="text" class="numero" id="dias<?=$f->id_servico_var?>" name="dias<?=$f->id_servico_var?>" value="<?=$f->dias?>"></td>
                    <td class="buttons"><a href="#" onclick="ServicoEdit(<?=$f->id_servico_var?>)"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $servicoDAO->QTDPagina(); ?>
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