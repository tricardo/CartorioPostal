<?php include('header.php'); 

    pt_register('GET','id_usuario');
    $id_usuario = isset($id_usuario) ? $id_usuario : 0;
    
    if($id_usuario == 0 AND $controle_id_usuario != 1){
        header('location:pagina-erro.php');
        exit;
    }
        
    $permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao == 'FALSE'){
        header('location:pagina-erro.php');
        exit;
    }
    
    $empresaDAO = new EmpresaDAO();
    $usuarioDAO = new UsuarioDAO();
    
    #vars
    if($_GET){ $c = Post_StdClass($_GET); } 
    $c->id_usuario = isset($id_usuario) ? $id_usuario : 0;
    
    if($id_usuario > 0 AND $controle_id_empresa != 1){
        if(count($usuarioDAO->buscaPorId($id_usuario, $controle_id_empresa)) == 0){
            header('location:pagina-erro.php');
            exit;
        }
    }
    
    #
    $link = '';
    $link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
    $link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
    $link .= (isset($c->status) AND strlen($c->status) > 0) ? '&status='.$c->status : '';
    $link .= (isset($c->id_empresa) AND strlen($c->id_empresa) > 0) ? '&id_empresa='.$c->id_empresa : '';
    $link .= (isset($c->id_departamento) AND strlen($c->id_departamento) > 0) ? '&id_departamento='.$c->id_departamento : '';
    
    
    
    
    $arr  = array('nome','email','cpf','rg','senha','id_empresa',
            'tel','ramal','cel','status','cep','endereco','numero',
            'complemento','bairro','cidade','estado','id_uuario');
    if($_POST){
        $show_msgbox = 1;
        for($i = 0; $i < count($arr); $i++){
            pt_register('POST', $arr[$i]);
        }
        
        if($cpf=="" || $nome=="" || $email=="" || $cep==""){
            $errors++;
            $campos.='nome;email;cpf;cep;';
            $msgbox.= "campos marcados com (*) são obrigatórios!;";
	}
	$valida = validaEMAIL($email);
	if($valida=='false' AND $errors == 0){
            $errors++;
            $campos.='email;';
            $msgbox.="E-mail Inválido, digite corretamente!;";
	}
        if($errors == 0){
            if(strlen($cpf) == 14){
                $valida = validaCPF($cpf);
                if($valida=='false'){
                    $errors++;
                    $campos.='cpf;';
                    $msgbox.="CPF Inválido, digite corretamente!;";
                }
            } else {
                $valida = validaCNPJ($cpf);
                if($valida=='false'){
                    $errors++;
                    $campos.='cpf;';
                    $msgbox.="CNPJ Inválido, digite corretamente!;";
                }
            }
        }
        if($errors == 0){
            if($usuarioDAO->verificaEmailExiste($id_usuario,$email) != 0){
                $errors++;
                $campos.='email;';
                $msgbox.="Este e-mail já esta cadastrado no sistema!;";
            }
        }
        if($errors == 0){
            $u = Post_StdClass($_POST);
            $u = UTF_Encodes($u, 2);
            $u->id_usuario = $c->id_usuario;
            $u->tipo = strlen($cpf) == 14 ? 'cpf' : 'cnpj';
            if($c->id_usuario > 0){
                $usuarioDAO->atualizar($u);
                $msgbox .= MsgBox(1);
            } else {
                $usuarioDAO->inserir($u);
                $msgbox .= MsgBox(2);
            }
        } 
        if($errors == 0 AND PRODUCAO == 0 AND $id_usuario > 0 AND
                isset($senha) AND strlen($senha) > 0){
            #atualiza no ead
            require_once('model/DatabaseEAD.php');
            $usuario = $usuarioDAO->selectPorId($id_usuario);
            $eadDAO = new EadDAO();
            $eadDAO->atualizaEad($usuario, $senha);   
            $msgbox .= MsgBox();
        }
    }
    if($errors == 0){
    if($id_usuario > 0){
        $u = UTF_Encodes($usuarioDAO->selectPorId($id_usuario));   
    } else {
        $u = CriarVar($arr);
        $u->fantasia = '';
    }} ?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; colaboradores &rsaquo;&rsaquo; <a href="usuarios-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-09').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php if($controle_id_usuario == 1){
        AddRegistro('usuarios-editar.php'.$link.'&id_usuario=0'); 
    } 
    $link .= '&id_usuario='.$c->id_usuario; ?>  
    <?php CamposObrigatorios(); ?>
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>Dados do Usuário</h3>
        <dl>
            <dt>Empresa:</dt>
            <dd class="line1">
                <?php if($id_usuario > 0 OR $controle_id_usuario != 1){ ?>
                    <input type="hidden" id="id_empresa" name="id_empresa" value="<?=$u->id_empresa?>">
                    <input type="text" value="<?=$u->fantasia ?>" readonly="readonly" class="required" placeholder="Empresa">
                <?php } else { ?>
                    <select name="id_empresa" id="id_empresa" class="chzn-select required line1">
                        <option value="" <?php if(isset($u->id_empresa) AND $u->id_empresa=='') echo 'selected="selected"'; ?>>Unidade</option>
                        <?php 
                        $empresas = $empresaDAO->listarTodas();
                        $p_valor = '';
                        foreach($empresas as $emp){
                            $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                            if(isset($u->id_empresa)){
                                $p_valor .= ($u->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                            }
                            $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                        }
                        echo $p_valor; ?>
                    </select>
                <?php } ?>
            </dd>
            <dt>Nome <span>*</span>:</dt>
            <dd class="line1">
                <input type="text" name="nome" id="nome" class="required" value="<?=$u->nome ?>" placeholder="Nome" required>
            </dd>
            <dt>E-mail <span>*</span>:</dt>
            <dd class="line1">
                <input type="text" name="email" id="email" class="email required" placeholder="E-mail" value="<?=$u->email ?>" <?=$controle_id_usuario != 1 ? 'readonly="readonly"' : ''?> required>
            </dd>
            <?php if($controle_id_usuario == 1){ ?>
                <dt>Senha:</dt>
                <dd class="line1">
                    <input type="password" name="senha" id="senha" placeholder="Senha" value="" <?=$controle_id_usuario != 1 ? 'readonly="readonly"' : ''?>>
                </dd>
            <?php } ?>
            <dt>CPF <span>*</span>:</dt>
            <dd>
                <input type="text" name="cpf" id="cpf" class="cpf required" value="<?=$u->cpf ?>" placeholder="CPF" required>
            </dd>
            <dt>RG:</dt>
            <dd>
                <input type="text" name="rg" id="rg" value="<?=$u->rg ?>" placeholder="RG">
            </dd>
            <dt>Telefone:</dt>
            <dd>
                <input type="text" name="tel" id="tel" class="fone" value="<?=$u->tel ?>" placeholder="Telefone"> 
            </dd>
            <dt>Ramal:</dt>
            <dd>
                <input type="text" name="ramal" id="ramal" value="<?=$u->ramal ?>" placeholder="Ramal">
            </dd>
            <dt>Celular:</dt>
            <dd>
                <input type="text" name="cel" id="cel" class="fone" value="<?=$u->cel ?>" placeholder="Celular">
            </dd>
            <dt>Skype:</dt>
            <dd>
                <input type="text" name="skype" id="skype" value="<?=$u->skype ?>" placeholder="Skype">
            </dd>
            <dt>Status:</dt>
            <dd>
                <select name="status" id="status" class="chzn-select">
                    <?php $stt = TiposDeStatus(5);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($u->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
                </select>
            </dd>
        </dl>
        <h3>Endereço do Usuário</h3>
        <dl>
            <dt>CEP:</dt>
            <dd>
                <input type="text" name="cep" id="cep" class="cep required" required placeholder="CEP" value="<?=$u->cep ?>" onkeyup="BuscaCep(this.id, 1, '')">                                        
            </dd>    
            <dt>Endereço:</dt>
            <dd>
                <input type="text" name="endereco" id="endereco" placeholder="Endereço" value="<?=$u->endereco ?>">
            </dd>    
            <dt>Número:</dt>
            <dd>
                <input type="text" name="numero" id="numero" placeholder="Número" class="numero" value="<?=$u->numero ?>">
            </dd>    
            <dt>Complemento:</dt>
            <dd>
                <input type="text" name="complemento" id="complemento" placeholder="Complemento" value="<?=$u->complemento ?>">
            </dd>    
            <dt>Bairro:</dt>
            <dd>
                <input type="text" name="bairro" id="bairro" placeholder="Bairro" value="<?=$u->bairro ?>">
            </dd>    
            <dt>Cidade:</dt>
            <dd>
                <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="<?=$u->cidade ?>"> 
            </dd>    
            <dt>Estado:</dt>
            <dd>
                <select class="chzn-select" name="estado" id="estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                        <option value="<?=$estado[$i]?>" <?=($estado[$i] == $u->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
                </select>
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_usuario > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<?php include('footer.php'); ?>