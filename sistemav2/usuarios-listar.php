<?php include('header.php'); 
$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$usuario = new UsuarioDAO();
$empresaDAO = new EmpresaDAO();
$departamentoDAO = new DepartamentoDAO();

$c = Post_StdClass($_GET);

$c->id_empresa = ($controle_id_empresa == 1) ? (isset($c->id_empresa) ? $c->id_empresa : '') : $controle_id_empresa;

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$link .= (isset($c->status) AND strlen($c->status) > 0) ? '&status='.$c->status : '';
$link .= (isset($c->id_empresa) AND strlen($c->id_empresa) > 0) ? '&id_empresa='.$c->id_empresa : '';
$link .= (isset($c->id_departamento) AND strlen($c->id_departamento) > 0) ? '&id_departamento='.$c->id_departamento : '';

$c = UTF_Encodes($c, 2);
$show_msgbox = 0;
?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; colaboradores');
    $('#sub-09').css({'font-weight':'bold'});
</script>
<div class="content-list-forms">
    <form method="get" action="<?=$link?>">
        
        <dl>
            <legend>Buscar Usuário</legend>
            <dt>Pesquisar:</dt>
            <dd><input type="text" name="busca" id="busca" value="<?=(isset($c->busca)) ? utf8_encode($c->busca) : ''?>" placeholder="Pesquisar"></dd>
            <?php  if($controle_id_empresa==1){ ?>
                <dt>Unidade:</dt>
                <dd>
                    <select name="id_empresa" id="id_empresa" class="chzn-select">
                            <option value="" <?php if($c->id_empresa=='') echo 'selected="selected"'; ?>>Unidade</option>
                            <?php 
                            $empresas = $empresaDAO->listarTodasFranquias();
                            $p_valor = '';
                            foreach($empresas as $emp){
                                $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                                if(isset($c->id_empresa)){
                                    $p_valor .= ($c->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                                }
                                $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                            }
                            echo $p_valor; ?>
                    </select>
                </dd>
                <dt>Departamento:</dt>
                <dd>
                    <select name="id_departamento" id="id_departamento" class="chzn-select">
                            <option value="">Departamento</option>
                            <?php $departamentos = $departamentoDAO->listar();
                            $p_valor = '';
                            foreach($departamentos as $dep){
                                $p_valor .= '<option value="'.$dep->id_departamento.'" ';
                                if(isset($c->id_departamento)){
                                    $p_valor .= ($c->id_departamento==$dep->id_departamento)?' selected="selected"':'';
                                }
                                $p_valor .= '>'.utf8_encode($dep->departamento).'</option>';
                            }
                            echo $p_valor;
                            ?>
                    </select>
                </dd>
            <?php } ?>
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
if($controle_id_usuario == 1){
    AddRegistro('usuarios-editar.php'.$link.'&id=0');
}
if($_GET){ 
    $listar = $usuarioDAO->busca($c->id_empresa,(isset($c->busca) ? $c->busca : ''),(isset($c->pagina) ? $c->pagina : 1),
            (isset($c->id_departamento) ? $c->id_departamento : ''),($controle_id_empresa==1)); ?>
    <?php if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $usuarioDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th class="buttons size100">status</th>
                    <th>nome - email</th>
                    <th>unidade</th>
                    <th class="buttons">depart.</th>
                    <th class="buttons">senha</th>
                    <th class="buttons">editar</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons"><?=$f->id_usuario?></td>
                    <td class="buttons size100"><?=$f->status?></td>
                    <td><?= utf8_encode(ucwords(strtolower((strlen($f->nome) > 0 ? $f->nome.' - ' : '')))).strtolower($f->email)?></td>                  
                    <td><?= utf8_encode(str_replace('Cartório Postal - ', '', ucwords(strtolower($f->fantasia)))) ?></td>
                    <td class="buttons"><a href="usuarios-departamento.php<?=$link.'&id_usuario='.$f->id_usuario ?>"><img src="images/bt-deps.png"></a></td>
                    <td class="buttons"><a href="usuarios-senha.php<?=$link.'&id_usuario='.$f->id_usuario ?>"><img src="images/bt-pass.png"></a></td>
                    <td class="buttons"><a href="usuarios-editar.php<?=$link.'&id_usuario='.$f->id_usuario ?>"><img src="images/bt-edit.png"></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $usuarioDAO->QTDPagina(); ?>
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