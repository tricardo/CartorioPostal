<?php include('header.php'); 

    $permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao == 'FALSE'){
        header('location:pagina-erro.php');
        exit;
    }
    
    $usuarioDAO      = new UsuarioDAO();
    $departamentoDAO = new DepartamentoDAO();
    
    pt_register('GET','id_usuario');
    $id_usuario = isset($id_usuario) ? $id_usuario : 0;
    
    $u = $usuarioDAO->selectPorId($id_usuario);
    if(($u->id_empresa != $controle_id_empresa && $controle_id_empresa!=1) || ($u->nome=='Monitoramento' && $controle_id_empresa!=1)){
        header('location:pagina-erro.php');
        exit;
    }
    
    #vars
    if($_GET){ $c = Post_StdClass($_GET); } 
    $c->id_usuario = isset($id_usuario) ? $id_usuario : 0;
    
    #
    $link = '';
    $link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
    $link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
    $link .= (isset($c->status) AND strlen($c->status) > 0) ? '&status='.$c->status : '';
    $link .= (isset($c->id_empresa) AND strlen($c->id_empresa) > 0) ? '&id_empresa='.$c->id_empresa : '';
    $link .= (isset($c->id_departamento) AND strlen($c->id_departamento) > 0) ? '&id_departamento='.$c->id_departamento : '';
    $link .= '&id_usuario='.$c->id_usuario;
    

    if($_POST){
        $show_msgbox = 1;
	$u->departamento_p = isset($_POST['pertence']) ? implode(',', $_POST['pertence']) : '';
        $u->departamento_s = isset($_POST['supervisor']) ? implode(',', $_POST['supervisor']) : '';        
        $usuarioDAO->atualiza_depto($u->departamento_p, $u->departamento_s, $id_usuario);
        $msgbox .= MsgBox();
    }   ?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; colaboradores &rsaquo;&rsaquo; <a href="usuarios-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-09').css({'font-weight':'bold'});
</script>
<div class="content-forms"> 
    <?php CamposObrigatorios(); ?>
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>Permissões de <?=NomeH1(2,array('nome'=>$u->nome))?></h3>
        <dl>
            <table class="table1">
                <thead>
                    <tr>
                        <th class="size100">Pertence</th>
                        <th class="size100">Supervisor</th>
                        <th rowspan="2">departamento</th>
                    </tr>
                    <tr>
                        <th class="size100">
                            <input type="checkbox" name="check1" id="check1" value="1" onclick="CheckAll(this.id)">
                        </th>
                        <th class="size100">
                            <input type="checkbox" name="check2" id="check2" value="1" onclick="CheckAll(this.id)">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $departamento_p = explode(',',$u->departamento_p);
                    $departamento_s = explode(',',$u->departamento_s);
                    $lista = UTF_Encodes($departamentoDAO->listarDptoUser($u->id_empresa));
                    foreach($lista AS $f){ ?>
                    <tr>
                        <td>
                            <input<?=(in_array($f->id_departamento, $departamento_p) ? ' checked="checked"' : '')?> class="check1" type="checkbox" name="pertence[]" id="pertence<?=$f->id_departamento?>" value="<?=$f->id_departamento?>">
                        </td>
                        <td>
                            <input<?=(in_array($f->id_departamento, $departamento_s) ? ' checked="checked"' : '')?> class="check2" type="checkbox" name="supervisor[]" id="supervisor<?=$f->id_departamento?>" value="<?=$f->id_departamento?>">
                        </td>
                        <td><?=$f->departamento?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="editar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<?php include('footer.php'); ?>