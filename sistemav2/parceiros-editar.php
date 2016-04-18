<?php include('header.php'); 

$permissao = verifica_permissao('Parceiro',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$parceiroDAO = new ParceiroDAO();

pt_register('GET','id_afiliado');
$id_afiliado = isset($id_afiliado) ? $id_afiliado : 0;

$c = new stdClass();
if($_POST){ foreach($_POST as $cp => $valor){ $c->$cp = $valor; } }
if($_GET){ foreach($_GET as $cp => $valor){ $c->$cp = $valor; pt_register('GET', $cp); } } 

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$show_msgbox = 1;
$arr = array('status','nome','email','cpf','rg','im','comissao','tel','ramal','tel2','ramal2','fax',
    'outros','site','endereco','numero','complemento','bairro','cep','cidade','estado','observacao');
if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    $arr1 = array('nome','email','cpf','tel','cep','endereco','numero','cidade','bairro','estado');
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
        $ci->id_afiliado= $id_afiliado;
        $ci->conveniado = '';
        $ci->id_pacote = 0;
        $ci = UTF_Encodes($ci, 2);
        if($id_afiliado > 0){
            $parceiroDAO->atualizar($ci,$controle_id_empresa);
            $msgbox .= MsgBox();
        } else {
            $parceiroDAO->inserir($ci,$controle_id_empresa);
            $msgbox .= MsgBox(2);
        }
     }
}

if($errors == 0){   
    if($id_afiliado > 0){
        $ci = UTF_Encodes($parceiroDAO->selectPorId($id_afiliado));
    } else {
        $ci = CriarVar($arr); 
        $ci->parceiro = '';
    }
}?>

<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; parceiros  &rsaquo;&rsaquo; <a href="parceiros-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-11').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('parceiros-editar.php'.$link.'&id_afiliado=0');
    $link .= '&id_afiliado='.$c->id_afiliado;  
    CamposObrigatorios(); ?>  

   <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
    <h3>informações do parceiro</h3>
    <dl>
        <dt>Status:</dt>
        <dd class="line1">
            <select name="status" id="status" class="chzn-select line1">
                <?php $stt = TiposDeStatus();
                foreach($stt AS $st){ ?>
                    <option value="<?=$st['id']?>" <?=($ci->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Nome <span>*</span>:</dt>
        <dd class="line1">
            <input type="text" name="nome" id="nome" class="required" value="<?= ($ci->nome) ?>" required placeholder="Nome">
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
        <dt>IM:</dt>
        <dd>
            <input type="text" name="im" id="im" value="<?= $ci->im ?>" placeholder="IM">
        </dd>
        <dt>Comissão:</dt>
        <dd>
            <input type="text" name="comissao" id="comissao" class="numero" value="<?= $ci->comissao ?>" placeholder="Comissão"> 
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel" id="tel" class="fone required" value="<?= $ci->tel ?>" placeholder="Telefone" required>
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal" id="ramal" value="<?= $ci->ramal ?>" placeholder="Ramal">
        </dd>
        <dt>Telefone:</dt>
        <dd>
            <input type="text" name="tel2" id="tel2" class="fone" value="<?= $ci->tel2 ?>" placeholder="Telefone">
        </dd>
        <dt>Ramal:</dt>
        <dd>
            <input type="text" name="ramal2" id="ramal2" value="<?= $ci->ramal2 ?>" placeholder="Ramal">
        </dd>
        <dt>Fax:</dt>
        <dd>
            <input type="text" name="fax" id="fax" class="fone" value="<?= $ci->fax ?>" placeholder="Fax"> 
        </dd>
        <dt>Outros:</dt>
        <dd>
            <input type="text" name="outros" id="outros" class="fone" value="<?= $ci->outros ?>" placeholder="Outros"> 
        </dd>
        <dt>Site:</dt>
        <dd class="line1"> 
            <input type="text" name="site" id="site" value="<?= utf8_decode($ci->site) ?>" placeholder="Site">
        </dd>
    </dl>
    <h3>endereço do parceiro</h3>
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
        <dt>Observação:</dt>
        <dd class="line1 txta-h">
            <textarea name="observacao" id="observacao" placeholder="Observação"><?= str_replace('<br />', "\n", ($ci->observacao)); ?></textarea><br /><br />
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="<?=($id_afiliado > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
   </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>
