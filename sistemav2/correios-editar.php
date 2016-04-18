<?php include('header.php'); 

if($controle_id_empresa != 1){
    if($controle_id_usuario != 1){
        header('location:pagina-erro.php');
        exit;
    }
}

$correioDAO = new CorreioDAO();
$empresaDAO = new EmpresaDAO();

pt_register('GET','id_correio');


#
$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_empresa = isset($c->id_empresa) ? $c->id_empresa : '';;
$c->id_correio = $id_correio;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) ? '&busca='.$c->busca : '';
$link .= strlen($c->id_empresa) ? '&id_empresa='.$c->id_empresa : '';

$arr = array('pagina','id_correio','id_empresa','nome','status','data_carta',
    'tel','fax','endereco','bairro','cep','cidade','estado','f_cadastro');

if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    $arr1 = array('nome');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if($errors == 0 AND $id_empresa == 0){
        $valida = validaCNPJ($cpf);
        if($valida=='false'){
            $errors++;
            $campos.='id_empresa;';
            $msgbox.="selecione uma unidade!;";
        }
    }
    
    if($errors == 0){
        $ci->id_agcorreios = $id_correio;
        $ci = UTF_Encodes($ci, 2);
        if($id_correio > 0){
            $ci->data_cartaz =  ($ci->data_cartaz != '') ? invert($ci->data_cartaz, '-', 'SQL') : '0000-00-00';
            $correioDAO->atualizar($ci,$id_correio);
            $msgbox .= MsgBox();
        } else {
            $correioDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
    }
    
}

if($errors == 0){   
    if($id_correio > 0){   
        $ci = UTF_Encodes($correioDAO->selectPorId($id_correio, $controle_id_empresa));
    } else {
        $ci = CriarVar($arr); 
        $ci->data_cartaz = '0000-00-00';
    }
}

?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; correios &rsaquo;&rsaquo; <a href="correios-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-14').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('correios-editar.php'.$link.'&id_correio=0');
    $link .= '&id_correio='.$c->id_correio;  
    CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>informações do correio</h3>
        <dl>
            <dt>Unidade:</dt>
            <dd class="line1">
                <select name="id_empresa" id="id_empresa" class="chzn-select required line1">
                    <option value="0" <?php if($ci->id_empresa=='0') echo 'selected="selected"'; ?>>Unidade</option>
                    <?php 
                    $empresas = $empresaDAO->listarTodasFranquias();
                    $p_valor = '';
                    foreach($empresas as $emp){
                        $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                        if(isset($ci->id_empresa)){
                            $p_valor .= ($ci->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                        }
                        $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                    }
                    echo $p_valor; ?>
                </select>
            </dd>
            <dt>Nome  <span>*</span>:</dt>
            <dd class="line1">
                <input type="text" name="nome" id="nome" class="required" value="<?= ($ci->nome) ?>" placeholder="Nome" required>
            </dd>
            <dt>Status:</dt>
            <dd>
                <select name="status" id="status" class="chzn-select">
                    <?php $stt = TiposDeStatus(7);
                    foreach($stt AS $st){ ?>
                        <option value="<?=$st['id']?>" <?=($ci->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Data Cartaz:</dt>
            <dd>
                <input type="text" name="data_cartaz" id="data_carta" class="data" value="<?= invert($ci->data_cartaz,'/','PHP') ?>" placeholder="Data Cartaz"> 
            </dd>
            <dt>Telefone:</dt>
            <dd>
                <input type="text" name="tel" id="tel" class="fone" value="<?= $ci->tel ?>" placeholder="Telefone">
            </dd>
            <dt>Fax:</dt>
            <dd>
                <input type="text" name="fax" id="fax" class="fone" value="<?= $ci->fax ?>" placeholder="Fax"> 
            </dd>
        </dl>
        <h3>endereço do correio</h3>
        <dl>
            <dt>Endereço:</dt>
            <dd class="line1">
                <input type="text" name="endereco" id="endereco" value="<?= ($ci->endereco) ?>" placeholder="Endereço">
            </dd>
            <dt>Bairro:</dt>
            <dd>
                <input type="text" name="bairro" id="bairro" value="<?= ($ci->bairro) ?>" placeholder="Bairro">
            </dd>
            <dt>CEP:</dt>
            <dd>
                <input type="text" name="cep" id="cep" class="cep" value="<?= ($ci->cep) ?>" placeholder="CEP" onkeyup="BuscaCep(this.id, 1, '')">
            </dd>
            <dt>Cidade:</dt>    
            <dd>
                <input type="text" name="cidade" id="cidade" value="<?= ($ci->cidade) ?>" placeholder="Cidade">
            </dd>
            <dt>Estado:</dt>
            <dd>
                <select class="chzn-select" name="estado" id="estado">
                    <?php $estado = UFs();
                    for($i = 0; $i < count($estado); $i++){ ?>
                            <option value="<?=$estado[$i]?>" <?=($estado[$i] == $ci->estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                    <?php } ?>
                </select>
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_correio > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
        <script>
        preencheCampo();
        </script>
</div>
<?php include('footer.php'); ?>