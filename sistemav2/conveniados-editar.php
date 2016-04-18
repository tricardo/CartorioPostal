<?php include('header.php'); 

$permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$clienteDAO = new ClienteDAO();
$usuarioDAO = new UsuarioDAO();
$conveniadoDAO = new ConveniadoDAO();

pt_register('GET','id_cliente');
pt_register('GET','opcoes_form');
$id_cliente = isset($id_cliente) ? $id_cliente : 0;
$opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
$show_msgbox = 1;

#
$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
#
$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$link .= (isset($c->id_cliente) AND strlen($c->id_cliente) > 0) ? '&id_cliente='.$c->id_cliente : '';
$id_conveniado = isset($c->id_conveniado) ? $c->id_conveniado : 0;

if($id_cliente == 0){
    header('location:pagina-erro.php');
    exit;
}


$arr = array('id_usuario_com','id_cliente','status','nome',
    'contato','email','cpf','rg','tel','ramal','telcel','fax','outros','endereco','numero',
    'complemento','bairro','cep','cidade','estado','faturamento');
if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    $arr1 = array('nome','contato','email','tel','cep','endereco','numero','cidade','bairro','estado');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if (!validaTel($tel) AND $errors == 0) {
        $errors++;
        $campos.='tel;';
        $msgbox.= "O telefone é inválido!;";
    }
    
    if($errors == 0){
        if(strlen($cpf) == 14) {
            $valida = validaCPF($cpf);
            if ($valida == 'false') {
               $errors++;
               $campos.='cpf;';
               $msgbox.="CPF Inválido, digite corretamente!;";
            }
        } else {
            $valida = validaCNPJ($cpf);
            if ($valida == 'false') {
               $errors++;
               $campos.='cpf;';
               $msgbox.="CNPJ Inválido, digite corretamente!;";
            }
        }
    }
    
    if($errors == 0){
        $ci->tipo = strlen($cpf) == 14 ? 'cpf' : 'cnpj';
        $ci->faturamento = isset($faturamento) ? 'on' : '';
        $ci->id_cliente = $id_cliente;
        $ci->id_conveniado = $id_conveniado;
        $ci = UTF_Encodes($ci, 2);
        if($id_conveniado > 0){
            $conveniadoDAO->atualizar($ci);
            $msgbox .= MsgBox();
        } else {
            $conveniadoDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
    }
 
}

if($errors == 0){   
    if($id_cliente > 0){
        if($id_conveniado > 0){
            $ci = UTF_Encodes($conveniadoDAO->selectPorId($id_conveniado, $controle_id_empresa));
        } else {
            $ci = CriarVar($arr); 
            $ci->conveniado = '';
        }
}}?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; clientes &rsaquo;&rsaquo; conveniados  &rsaquo;&rsaquo; <a href="conveniados-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-10').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    if($id_cliente > 0){
        AddRegistro('conveniados-editar.php'.$link.'&id_conveniado=0');
    }
    $link .= '&id_conveniado='.$c->id_conveniado;  
    CamposObrigatorios(); ?>  

   <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
    <h3>informações do conveniado</h3>
    <dl>
        <dt>Comissionado:</dt>
        <dd class="line1">
            <select name="id_usuario_com" id="id_usuario_com" class="chzn-select line1">
                <option value="">Colaboradores</option>
                <?php
                $funcionarios = $usuarioDAO->listarPorDepartamentoEmpresa($controle_id_empresa, 14);
                $p_valor = '';
                foreach ($funcionarios as $f) {
                    $p_valor.='<option value="' . $f->id_usuario . '"';
                    if ($ci->id_usuario_com == $f->id_usuario)
                        $p_valor.=' selected="select" ';
                    $p_valor.='>' . utf8_encode($f->nome) . '</option>';
                }
                echo $p_valor;
                ?>
            </select>
        </dd>
        
        <?php if ($ci->conveniado=="" or $ci->conveniado=="Não"){ ?>
            <dt>Cliente:</dt>
            <dd class="line1">
                <select name="id_cliente" id="id_cliente" class="chzn-select line1">
                    <?php $clientes = $clienteDAO->listarPorEmpresa($controle_id_empresa);
                    foreach($clientes as $cliente){
                        echo '<option value="'.$cliente->id_cliente.'" '.(($id_cliente==$cliente->id_cliente) ? ' selected="selected"' : '').'>'.
                        utf8_encode($cliente->nome).'</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="conveniado" id="conveniado" value="">
            </dd>
        <?php } else { ?>
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$id_cliente?>">
        <?php } ?>
        <dt>Status:</dt>
        <dd class="line1">
            <select name="status" id="status" class="chzn-select line1">
                <?php $stt = TiposDeStatus(5);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($u->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
         <dt>Nome <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="nome" id="nome" class="required" value="<?= ($ci->nome) ?>" required placeholder="Nome">
        </dd>
        <dt>Contato <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="contato" id="contato" class="required" value="<?= ($ci->contato) ?>" required placeholder="Contato">
        </dd>
        <dt>E-mail <span>*</span>:</dt>
        <dd class="line1"> 
            <input type="text" name="email" id="email" class="email required" value="<?= utf8_decode($ci->email) ?>" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> required placeholder="E-mail">
        </dd>
        <dt>CPF/CNPJ <span>*</span>:</dt>
        <dd>
            <input type="text" name="cpf" id="cpf" class="cpf required" value="<?= $ci->cpf ?>" required placeholder="CPF/CNPJ">
        </dd>
        <dt>RG/IE:</dt>
        <dd>
            <input type="text" name="rg" id="rg" value="<?= $ci->rg ?>" placeholder="RG/IE">
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel" id="tel" class="fone required" value="<?= $ci->tel ?>" placeholder="Telefone" required>
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal" id="ramal" value="<?= $ci->ramal ?>" placeholder="Ramal">
        </dd>
        <dt>Tel./Cel.:</dt>
        <dd>
            <input type="text" name="telcel" id="telcel" class="fone" value="<?= $ci->telcel ?>" placeholder="Tel./Cel.">
        </dd>
        <dt>Fax:</dt>
        <dd>
            <input type="text" name="fax" id="fax" class="fone" class="telefone" value="<?= $ci->fax ?>" placeholder="Fax"> 
        </dd>
        <dt>Outros:</dt>
        <dd>
            <input type="text" name="outros" id="outros" class="fone" class="telefone" value="<?= $ci->outros ?>" placeholder="Outros"> 
        </dd>
    </dl>
    <h3>endereço do conveniado</h3>
    <dl>
        <dt>Endereço <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="endereco" id="endereco" class="required" value="<?= ($ci->endereco) ?>" placeholder="Endereço" required>
        </dd>
        <dt>Número <span>*</span>:</dt>
        <dd>
            <input type="text" name="numero" id="numero" class="required" value="<?= ($ci->numero) ?>" placeholder="Número" required>
        </dd>
        <dt>Complemento:</dt>
        <dd>
            <input type="text" name="complemento" id="complemento" value="<?= ($ci->complemento) ?>" placeholder="Complemento">
        </dd>
        <dt>Bairro <span>*</span>:</dt>
        <dd>
            <input type="text" name="bairro" id="bairro" class="required" value="<?= ($ci->bairro) ?>" placeholder="Bairro" required>
        </dd>
        <dt>CEP <span>*</span>:</dt>
        <dd>
            <input type="text" name="cep" id="cep" class="cep required" value="<?= ($ci->cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')" required>
        </dd>
        <dt>Cidade <span>*</span>:</dt>    
        <dd>
            <input type="text" name="cidade" id="cidade" value="<?= ($ci->cidade) ?>" placeholder="Cidade" class="required" required>
        </dd>
        <dt>Estado <span>*</span>:</dt>
        <dd>
            <select class="chzn-select required" name="estado" id="estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $ci->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
            </select>
        </dd>
        <dt>Faturar:</dt>
        <dd class="checks">
            <input type="checkbox" name="faturamento" id="faturamento" value="Sim" <?=$ci->faturamento == 'on' ? 'checked="checked"' : '' ?>>
            <span>Mesmo Endereço</span>
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_conveniado > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
   </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>
