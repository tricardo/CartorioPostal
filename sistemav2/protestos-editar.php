<?php include('header.php'); 

$permissao = verifica_permissao('Protesto',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$protestoDAO = new ProtestoDAO();


pt_register('GET','id_protesto');

if($id_protesto > 0){
    #$protesto = $protestoDAO->selectPorIdEmpresa($id_protesto, $controle_id_empresa);
}

#
$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_protesto = $id_protesto;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) > 0 ? '&busca='.$c->busca : '';

$arr = array('pagina','id_protesto','portador_nome','portador','data_movimento','cedente_agencia',
    'cedente_nome','sacado_documento','sacado_nome','sacado_endereco','sacado_cep','sacado_cidade',
    'sacado_estado','nosso_numero','tipo_moeda','agencia_centralizadora','ibge_cidade');


if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    if($errors == 0){
        $ci = UTF_Encodes($ci, 2);
        if($id_protesto > 0){
            $ci->id_protesto = $id_protesto;
            $protestoDAO->atualizar($ci, $controle_id_empresa);
            $msgbox .= MsgBox();
        } else {
            $ci->id_usuario = $controle_id_usuario;
            $protestoDAO->inserir($ci, $controle_id_empresa);
            $msgbox .= MsgBox(2);
        }
    }
    
}

if($errors == 0){   
    if($id_protesto > 0){     
        $ci = UTF_Encodes($protestoDAO->buscaPorId($id_protesto, $controle_id_empresa));
    } else {
        $ci = CriarVar($arr); 
    }
}?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; protestos  &rsaquo;&rsaquo; <a href="protestos-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-15').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('protestos-editar.php'.$link.'&id_protesto=0');
    $link .= '&id_protesto='.$c->id_protesto;  
    CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>informações do portador</h3>
        <dl>
            <dt>Nome do Portador:</dt>
            <dd class="line1">
                <input type="text" name="portador_nome" id="portador_nome" value="<?= ($ci->portador_nome) ?>" placeholder="Nome do Portador">
            </dd>
            <dt>Portador:</dt>
            <dd>
                <input type="text" name="portador" id="portador"  value="<?= $ci->portador ?>" class="numero" placeholder="Portador">
            </dd>
            <dt>Movimento:</dt>
            <dd>
                <input type="text" name="data_movimento" id="data_movimento" value="<?= invert($ci->data_movimento, '/', 'PHP'); ?>" class="data" placeholder="Movimento">
            </dd>
        </dl>
        <h3>cedente</h3>
        <dl>
            <dt>Agência:</dt>
            <dd>
                <input type="text" name="cedente_agencia" id="cedente_agencia" value="<?= $ci->cedente_agencia ?>" maxlength="15" placeholder="Agência">
            </dd>
            <dt>Nome do Cedente:</dt>
            <dd>
                <input type="text" name="cedente_nome" id="cedente_nome" value="<?= $ci->cedente_nome ?>" placeholder="Nome do Cedente">
            </dd>
        </dl>
        <h3>sacado / credor</h3>
        <dl>
            <dt>Documento:</dt>
            <dd>
                <input type="text" name="sacado_documento" id="sacado_documento" value="<?= $ci->sacado_documento ?>" maxlength="14" placeholder="Documento">
            </dd>
            <dt>Nome do Credor:</dt>
            <dd>
                <input type="text" name="sacado_nome" id="sacado_nome" value="<?= $ci->sacado_nome ?>" placeholder="Nome do Credor">
            </dd>
            <dt>Endereço:</dt>
            <dd>
                <input type="text" name="sacado_endereco" id="sacado_endereco" value="<?= ($ci->sacado_endereco) ?>" placeholder="Endereço">
            </dd>
            <dt>CEP:</dt>
            <dd>
                <input type="text" name="sacado_cep" id="sacado_cep" class="cep" value="<?= ($ci->sacado_cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')">
            </dd>
            <dt>Cidade:</dt>    
            <dd>
                <input type="text" name="sacado_cidade" id="sacado_cidade" value="<?= ($ci->sacado_cidade) ?>" placeholder="Cidade">
            </dd>
            <dt>Estado:</dt>
            <dd>
                <select class="chzn-select" name="sacado_estado" id="sacado_estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $ci->sacado_estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Nosso Número:</dt>
            <dd>
                <input type="text" name="nosso_numero" id="nosso_numero" value="<?= $ci->nosso_numero ?>" maxlength="15" placeholder="Nosso Número">
            </dd>
            <dt>Tipo  Moeda:</dt>
            <dd>
                <input type="text" name="tipo_moeda" id="tipo_moeda" value="<?= $ci->tipo_moeda ?>" placeholder="Tipo  Moeda" class="money">
            </dd>
            <dt>Ag. Central:</dt>
            <dd>
                <input type="text" name="agencia_centralizadora" id="agencia_centralizadora" value="<?= $ci->agencia_centralizadora ?>" maxlength="6" placeholder="Ag. Central">
            </dd>
            <dt>Cód. IBGE:</dt>
            <dd>
                <input type="text" name="ibge_cidade" id="ibge_cidade" value="<?= $ci->ibge_cidade ?>" maxlength="7" placeholder="Cód. IBGE" class="numero">
            </dd> 
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_protesto > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>