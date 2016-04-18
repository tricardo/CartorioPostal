<?php include('header.php'); 

$permissao = verifica_permissao('Conta',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$contaDAO = new ContaDAO();

pt_register('GET','id_conta');
$id_conta = isset($id_conta) ? $id_conta : 0;

$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor; pt_register('GET', $cp); } } 

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$show_msgbox = 1;
$arr = array('status','id_banco','sigla','agencia','conta');
if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }

    $arr1 = array('sigla','agencia','conta');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
     if($errors == 0){
        
        $ci = UTF_Encodes($ci, 2);
        $ci->id_empresa= $controle_id_empresa;
        $ci->id_conta = $id_conta;
        if($id_conta > 0){
            $contaDAO->atualizar($ci);
            $msgbox .= MsgBox();
        } else {
            $contaDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
     }
}

if($errors == 0){   
    if($id_conta > 0){
        $ci = UTF_Encodes($contaDAO->selectPorId($id_conta, $controle_id_empresa));
    } else {
        $ci = CriarVar($arr); 
        $ci->conta = '';
    }
}?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; contas  &rsaquo;&rsaquo; <a href="contas-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-50').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('contas-editar.php'.$link.'&id_conta=0');
    $link .= '&id_conta='.$c->id_conta;  
    CamposObrigatorios(); ?>  

   <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
    <h3>informações do conta</h3>
    <dl>
        <dt>Banco <span>*</span>:</dt>
        <dd class="line1">
            <select name="id_banco" id="id_banco" class="chzn-select required line1">
                    <?php 
                    $bancoDAO = new BancoDAO();
                    foreach($bancoDAO->listar() as $f){ ?>
                    <option value="<?=$f->id_banco;?>"<?=($ci->id_banco==$f->id_banco)?'selected="selected"':''?>><?=utf8_encode($f->banco); ?></option>
                    <?php }?>
            </select>
        </dd>
        <dt>Sigla <span>*</span>:</dt>
        <dd>
            <input type="text" name="sigla" id="sigla" class="required" value="<?= ($ci->sigla) ?>" required placeholder="Sigla" <?=$id_conta > 0 ? ' readonly="readonly"' : ''?>>
        </dd>
        <dt>Agência <span>*</span>:</dt>
        <dd> 
            <input type="text" name="agencia" id="agencia" class="required" value="<?= utf8_decode($ci->agencia) ?>" required placeholder="Agência">
        </dd>
        <dt>Conta <span>*</span>:</dt>
        <dd>
            <input type="text" name="conta" id="conta" class="required" value="<?= $ci->conta ?>" required placeholder="Conta">
        </dd>
        <dt>Status:</dt>
        <dd>
            <select name="status" id="status" class="chzn-select">
                <?php $stt = TiposDeStatus(5);
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($ci->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_conta > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
   </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>
