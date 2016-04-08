<?php include('header.php'); 

if(verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
    && verifica_permissao('Supervisor Atendimento',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'
    && verifica_permissao('Supervisor Financeiro',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE'){
        if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE'){
            header('location:pagina-erro.php');
            exit;
        }
}
$show_msgbox=0;
$empresaDAO = new EmpresaDAO();
$pedidoDAO = new PedidoDAO();

if($_POST){
    pt_register('POST','mes');
    pt_register('POST','ano');
    pt_register('POST','id_empresa');
    pt_register('POST','cnpj_cliente');
}
$mes = isset($mes) ? $mes : date('m');
$ano = isset($ano) ? $ano : date('Y');
$id_empresa   = isset($id_empresa) ? $id_empresa : 0;
$cnpj_cliente = isset($cnpj_cliente) ? $cnpj_cliente : (isset($_GET['cnpj_cliente']) ? $_GET['cnpj_cliente'] : '');

$g = Post_StdClass($_GET);
$p = Post_StdClass($_POST);


$link = '';
$link .= (isset($g->pagina)) ? '?pagina='.$g->pagina : '?pagina=1';
$link .= (isset($g->busca) AND strlen($g->busca) > 0) ? '&busca='.$g->busca : '';

?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; clientes &rsaquo;&rsaquo; <a href="clientes-listar.php<?=$link?>">listar</a>');
    $('#sub-10').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="post">
        <dl>
            <legend>Relatório Mensal Consolidado - Clientes</legend>
            <dt>Mês:</dt>
            <dd>
                <select name="mes" id="mes" class="chzn-select">
                    <option value="01" <?=$mes=='01' ? 'selected="select"' : ''; ?>>Janeiro</option>
                    <option value="02" <?=$mes=='02' ? 'selected="select"' : ''; ?>>Fevereiro</option>
                    <option value="03" <?=$mes=='03' ? 'selected="select"' : ''; ?>>Março</option>
                    <option value="04" <?=$mes=='04' ? 'selected="select"' : ''; ?>>Abril</option>
                    <option value="05" <?=$mes=='05' ? 'selected="select"' : ''; ?>>Maio</option>
                    <option value="06" <?=$mes=='06' ? 'selected="select"' : ''; ?>>Junho</option>
                    <option value="07" <?=$mes=='07' ? 'selected="select"' : ''; ?>>Julho</option>
                    <option value="08" <?=$mes=='08' ? 'selected="select"' : ''; ?>>Agosto</option>
                    <option value="09" <?=$mes=='09' ? 'selected="select"' : ''; ?>>Setembro</option>
                    <option value="10" <?=$mes=='10' ? 'selected="select"' : ''; ?>>Outubro</option>
                    <option value="11" <?=$mes=='11' ? 'selected="select"' : ''; ?>>Novembro</option>
                    <option value="12" <?=$mes=='12' ? 'selected="select"' : ''; ?>>Dezembro</option>
                </select> 
            </dd>
            <dt>Ano:</dt>
            <dd>
                <select name="ano" id="ano" class="chzn-select">
                    <?php for($i = 2008; $i <= date('Y'); $i++){ ?>
                        <option value="<?=$i?>" <?=$ano==$i ? 'selected="select"' : ''; ?>><?=$i?></option>
                    <?php } ?>
                </select>
            </dd>
            <?php if($controle_id_empresa=='1'){?>
            <dt>Unidade:</dt>
            <dd>
                <select name="id_empresa" id="id_empresa" class="chzn-select">
                    <?php $empresas = $empresaDAO->listarTodas();
                    foreach($empresas as $e){?>
                        <option value="<?php echo $e->id_empresa ?>" <?=$id_empresa==$e->id_empresa ? 'selected="select"' : ''; ?>><?= utf8_encode($e->fantasia) ?></option>
                    <?php }?>
                </select>
            </dd>
            <?php }?>
            <dt>Download:</dt>
            <dd class="checks">
                <input type="checkbox" <?=isset($_POST['download']) ? 'checked="checked"':''?> name="download" id="download">
                <span>Sim</span>
            </dd>
            <input type="hidden" name="cnpj_cliente" id="cnpj_cliente" value="<?= $cnpj_cliente?>">
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'<?=$link?>&cnpj_cliente=<?=$cnpj_cliente?>&listar=1'">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
if($_POST OR isset($_GET['listar'])){
    $ref = $mes.'/'.$ano;
	
    $data_i = $ano.'-'.$mes.'-01 00:00:00';
    $data_f = $ano.'-'.$mes.'-31 23:59:59';
    $id_empresa = ($controle_id_empresa=='1')?$id_empresa:$controle_id_empresa;
    
    $pedidos = $pedidoDAO->listaPedidosClientePJ($id_empresa,$data_i,$data_f,$cnpj_cliente);
    if(count($pedidos) > 0){
        if(isset($_POST['download'])){

            $nomeArquivo = "cliente_".$ano."_".$mes.".csv";
            $arquivoDiretorio = "./exporta/".$nomeArquivo;
            $arquivoConteudo = 'Referência;'.$ref.';'.$pedidos[0]->cpf.';PEDIDO;VALOR';	
            $valores=0;
            foreach($pedidos as $i=>$p){
                $arquivoConteudo .= '#'.$p->id_pedido;
                $arquivoConteudo .= '/'.$p->ordem;
                $arquivoConteudo .= ';'.number_format($p->valor,2,',','');
                $arquivoConteudo .= ';'.$p->contato;
                $arquivoConteudo .= ';'.$p->tel.' - '.$p->ramal;
                $arquivoConteudo .= ';'.$p->tel2.' - '.$p->ramal2;
                $arquivoConteudo .= ';'.$p->nome;
                $arquivoConteudo .="\n";
                $valores += $p->valor;
            }
            $arquivoConteudo.=($i+1).';'.number_format($valores,2,',','');
            if(is_file($arquivoDiretorio)) {
                unlink($arquivoDiretorio);
            }	
            $err = 0;
            if(fopen($arquivoDiretorio,"w+")) {
                    if (!$handle = fopen($arquivoDiretorio, 'w+')) {
                        RetornaErro('Falha ao criar o arquivo: '.$nomeArquivo);
                        $err++;
                    }
                    if(!fwrite($handle, $arquivoConteudo) AND $err == 0) {
                        RetornaErro('Falha ao escrever o arquivo: '.$nomeArquivo);
                        $err++;
                    }
                    if($err == 0){
                        header ("Content-type: octet/stream");
                        header ("Content-disposition: attachment; filename=exporta/".$nomeArquivo.";");
                        header("Content-Length: ".filesize($arquivoDiretorio));
                        readfile($arquivoDiretorio);
                        die();
                    }
            } else {
                RetornaErro('Falha ao criar o arquivo: '.$nomeArquivo);
            }        
        } else {
            if(count($pedidos) > 0){ ?>
                <div class="paginacao">
                    <?php $clienteDAO->QTDPagina(); ?>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="buttons size100">#</th>
                            <th class="buttons size100">valor (R$)</th>
                            <th>contato</th>
                            <th>telefones</th>
                            <th>nome</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $color = '#FFFEEE';
                        foreach ($pedidos as $f) { 
                            $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  ?>
                        <tr <?=TRColor($color)?>>
                            <td class="buttons"><?=$f->id_cliente?></td>
                            <td class="buttons"><?= invert($f->data,'/','PHP')?></td>
                            <td class="buttons"><?= utf8_encode($f->status) ?></td>
                            <td><?= utf8_encode($f->nome) ?></td>
                            <td class="buttons">
                                <a href="<?=$link_conveniado?>"><img src="images/bt-users.png"></a>
                                (<?= $conveniados ?>)
                            </td>
                            <td class="buttons"><?= utf8_encode($f->conveniado) ?></td>
                            <td class="buttons"><?=$f->tipo == 'cnpj' ? '<a href="rel-clientes-cnpj.php'.$link.'&cnpj_cliente='.$f->cpf.'&listar=1"><img src="images/bt-relat.png"></a>' : '-'?></td>
                            <td class="buttons"><a href="clientes-editar.php<?=$link.'&id_cliente='.$f->id_cliente ?>"><img src="images/bt-edit.png"></a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="paginacao">
                    <?php $clienteDAO->QTDPagina(); ?>
                </div>
                <script>PaginacaoWidth()</script>
            <?php }
        }
    } else { 
                RetornaVazio();
            } 
} else {
    RetornaVazio(2);
} ?>
</div>
<?php include('footer.php'); ?>