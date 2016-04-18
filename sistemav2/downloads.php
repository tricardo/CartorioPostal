<?php include('header.php'); 

$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
$safDAO = new SafDAO();
$empresaDAO = new EmpresaDAO();


$c = Post_StdClass($_GET);
$c->titulo = isset($c->titulo) ? $c->titulo : '';
$c->id_empresa = isset($c->id_empresa) ? $c->id_empresa : '';
$c->id_categoria= isset($c->id_categoria) ? $c->id_categoria : '';
$c->pagina = isset($c->pagina) ? $c->pagina : 1;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->titulo) > 0 ? '&titulo='.$c->titulo : '';
$link .= strlen($c->id_categoria) > 0 ? '&id_categoria='.$c->id_categoria : '';
$link .= strlen($c->id_empresa) > 0 ? '&id_empresa='.$c->id_empresa : '';

$c = UTF_Encodes($c, 2);

if(isset($c->excluir) AND is_numeric($c->excluir) AND $c->excluir == 1){
    if(isset($c->id_download) AND is_numeric($c->id_download) AND $c->id_download > 0){
        $listar = $safDAO->selectDownload($c);
        if($listar){
            $val = ($controle_id_empresa != 1 AND $listar->id_empresa != $controle_id_empresa) ? 0 : 1;
            if($val == 1){
                if (file_exists('ftp_upload/'.$listar->arquivo)){ unlink('ftp_upload/'.$listar->arquivo); }
                $safDAO->excluirDownload($c);
                $msgbox .= MsgBox(3);
                $show_msgbox = 1;
                define('MSGBOX', 1);
            }
        }
    }
} ?>
<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; downloads');
    $('#sub-06').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get">
        
        <dl>
            <legend>Buscar Downloads</legend>
            <dt>Título:</dt>
            <dd>
                <input type="text" name="titulo" id="titulo" placeholder="Título" value="<?=utf8_encode($c->titulo)?>">
            </dd>
            <dt>Unidade:</dt>
                <dd>
                    <select name="id_empresa" id="id_empresa" class="chzn-select">
                            <option value="" <?php if($c->id_empresa=='') echo 'selected="selected"'; ?>>Unidade</option>
                            <?php 
                            $empresas = $empresaDAO->listarTodas();
                            $p_valor = '';
                            foreach($empresas as $emp){
                                $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                                $p_valor .= ($c->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                                $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                            }
                            echo $p_valor; ?>
                    </select>
                </dd>
                <dt>Categoria:</dt>
                <dd>
                    <select name="id_categoria" id="id_categoria" class="chzn-select">
                            <option value="">Categoria</option>
                            <?php $departamentos = $safDAO->CategoriaFTP();
                            $p_valor = '';
                            foreach($departamentos as $dep){
                                $p_valor .= '<option value="'.$dep->id_ftp_categoria.'" ';
                                $p_valor .= ($c->id_categoria==$dep->id_ftp_categoria)?' selected="selected"':'';
                                $p_valor .= '>'.utf8_encode($dep->ftp_categoria).'</option>';
                            }
                            echo $p_valor;
                            ?>
                    </select>
                </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname">
                <input type="submit" value="buscar &rsaquo;&rsaquo;">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table">   
<?php
if($controle_id_usuario == 1 OR ($permissao != 'FALSE')){ 
    AddRegistro('downloads-editar.php'.$link.'&id_download=0');
}

if($_GET){ 
    $safDAO = new SafDAO();
    $listar = $safDAO->Downloads($c); 
    ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $safDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th>título</th>
                    <th class="buttons size150">departamento</th>
                    <th class="buttons">data</th>
                    <th class="buttons">download</th>
                    <?php if($controle_id_usuario == 1 OR ($controle_id_empresa == $f->id_empresa AND $permissao != 'FALSE')){ ?>
                        <th class="buttons">excluir</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; 
                    if(file_exists('ftp_upload/'.$f->arquivo)){
                        $f->arquivo = 'ftp_upload/'.$f->arquivo;
                    } else {
                        $f->arquivo = '../saf/ftp_upload/'.$f->arquivo;
                    } ?>
                <tr <?=TRColor($color)?>>
                    <td><?=utf8_encode($f->titulo)?></td>
                    <td class="buttons size150"><?=utf8_encode($f->ftp_categoria)?></td>
                    <td class="buttons"><?=utf8_encode($f->data)?></td>
                    <td class="buttons">
                        <a href="<?=$f->arquivo?>" target="_blank"><img src="images/bt-download.png"></a>
                    </td>
                    <?php if($controle_id_usuario == 1 OR ($controle_id_empresa == $f->id_empresa AND $permissao != 'FALSE')){ ?>
                        <td class="buttons">
                            <a href="<?=$link.'&excluir=1&id_download='.$f->id_upload?>"><img src="images/bt-del.png"></a>
                        </td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $safDAO->QTDPagina(); ?>
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