<?php include('header.php'); 

$permissao = verifica_permissao('Cartorio',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' OR $controle_id_empresa != 1){
    header('location:pagina-erro.php');
    exit;
}

$cartorioDAO = new CartorioDAO();
$bancoDAO = new BancoDAO();
$empresaDAO = new EmpresaDAO();

pt_register('GET','id_cartorio');

if($id_cartorio > 0){
    #$cartorio = $cartorioDAO->selectPorIdEmpresa($id_cartorio, $controle_id_empresa);
}

#
$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->atribuicao = isset($c->atribuicao) ? $c->atribuicao : '';
$c->estado = isset($c->estado) ? $c->estado : '';
$c->cidade = isset($c->cidade) ? $c->cidade : '';
$c->id_cartorio = $id_cartorio;

$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->atribuicao) ? '&atribuicao='.$c->atribuicao : '';
$link .= strlen($c->estado) ? '&estado='.$c->estado : '';
$link .= strlen($c->cidade) ? '&cidade='.$c->cidade : '';

$arr = array('pagina','id_cartorio','status','ftipo','id_empresa','nome','fantasia',
    'email','cpf','rg','contato','site','tel','ramal','tel2','ramal2','fax','cel','comarca',
    'distrito','atribuicao','valor_busca','valor_certidao','endereco','numero','complemento','bairro',
    'cep','cidade','estado','id_banco','agencia','conta','favorecido','obs','f_cadastro');


if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    $arr1 = array('nome','fantasia');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if($errors == 0 AND strlen($cpf) > 0){
        $valida = validaCNPJ($cpf);
        if($valida=='false'){
            $errors++;
            $campos.='cpf;';
            $msgbox.="CNPJ Inválido, digite corretamente!;";
        }
    }
    
    if($errors == 0){
        $ci->id_franquia = $ci->id_empresa;
        $ci->id_cartorio = $id_cartorio;
        $ci->tipo        = strlen($ci->cpf) > 0 ? 'cnpj' : '';
        $ci->id_usuario_edit = $controle_id_usuario;
        $ci->banco = $ci->id_banco;
        $ci = UTF_Encodes($ci, 2);
        if($id_cartorio > 0){
            $cartorioDAO->atualizar($ci);
            $msgbox .= MsgBox();
        } else {
            $cartorioDAO->inserir($ci);
            $msgbox .= MsgBox(2);
        }
    }
    
}

if($errors == 0){   
    if($id_cartorio > 0){     
        $ci = UTF_Encodes($cartorioDAO->selectPorId($id_cartorio));
        $ci->id_franquia = $ci->id_empresa;
    } else {
        $ci = CriarVar($arr); 
        $ci->valor_busca = '0.00';
        $ci->valor_certidao = '0.00';
        $ci->id_franquia = 0;
    }
}?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; cartórios  &rsaquo;&rsaquo; <a href="cartorios-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-13').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('cartorios-editar.php'.$link.'&id_cartorio=0');
    $link .= '&id_cartorio='.$c->id_cartorio;  
    CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>informações do cartório</h3>
        <dl>
            <dt>Status:</dt>
            <dd>
                <select name="status" id="status" class="chzn-select">
                    <?php $stt = TiposDeStatus(5);
                    foreach($stt AS $st){ ?>
                        <option value="<?=$st['id']?>" <?=($ci->status==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Tipo:</dt>
            <dd>
                <select name="ftipo" id="ftipo" class="chzn-select">
                    <?php $stt = TiposDeStatus(6);
                    foreach($stt AS $st){ ?>
                        <option value="<?=$st['id']?>" <?=($ci->ftipo==$st['id'])?'selected="selected"':''?>><?=$st['texto']?></option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Unidade:</dt>
            <dd class="line1">
                <select name="id_empresa" id="id_empresa" class="chzn-select line1">
                        <option value="0" <?php if($ci->id_empresa=='0') echo 'selected="selected"'; ?>>Unidade</option>
                        <?php 
                        $empresas = $empresaDAO->listarTodas();
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
            <dt>Fantasia <span>*</span>:</dt>
            <dd class="line1"> 
                <input type="text" name="fantasia" id="fantasia" class="required" value="<?= ($ci->fantasia) ?>" required placeholder="Fantasia"> 
            </dd>
            <dt>E-mail:</dt>
            <dd class="line1"> 
                <input type="text" name="email" id="email" class="email" value="<?= utf8_decode($ci->email) ?>" <?=($controle_id_usuario == 1) ? '' : 'readonly="readonly"'?> placeholder="E-mail">
            </dd>
            <dt>CNPJ:</dt>
            <dd>
                <input type="text" name="cpf" id="cpf" class="cpf" value="<?= $ci->cpf ?>" placeholder="CNPJ">
            </dd>
            <dt>IE:</dt>
            <dd>
                <input type="text" name="rg" id="rg" value="<?= $ci->rg ?>" placeholder="IE">
            </dd>
             <dt>Contato:</dt>
            <dd>
                <input type="text" name="contato" id="contato" value="<?= ($ci->contato) ?>" placeholder="Contato">
            </dd>
            <dt>Site:</dt>
            <dd> 
                <input type="text" name="site" id="site" value="<?= utf8_decode($ci->site) ?>" placeholder="Site">
            </dd>
            <dt>Telefone:</dt>
            <dd>
                <input type="text" name="tel" id="tel" class="fone" value="<?= $ci->tel ?>" placeholder="Telefone">
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
            <dt>Celular:</dt>
            <dd>
                <input type="text" name="cel" id="cel" class="fone" value="<?= $ci->cel ?>" placeholder="Celular"> 
            </dd>
            <dt>Comarca:</dt>
            <dd>
                <input type="text" name="comarca" id="comarca" value="<?= $ci->comarca ?>" placeholder="Comarca"> 
            </dd>
            <dt>Distrito:</dt>
            <dd>
                <input type="text" name="distrito" id="distrito" value="<?= $ci->distrito ?>" placeholder="Distrito"> 
            </dd>
            <dt>Atribuição:</dt>
            <dd class="line1">
                <select name="atribuicao" id="atribuicao" class="chzn-select line1">
                    <?php $atribuicoes = $cartorioDAO->listaAtribuicoes();
                    foreach($atribuicoes as $atr){
                        echo '<option value="'.$atr->id_atribuicao.'" '.
                        (($c->atribuicao==$atr->id_atribuicao)?' selected="selected"':'').'>';
                        echo utf8_encode($atr->atribuicao).'</option>';
                    }
                    ?>
		</select>
            </dd>
            
            <dt>Valor Busca:</dt>
            <dd>
                <input type="text" name="valor_busca" id="valor_busca" class="money" value="<?= $ci->valor_busca ?>" placeholder="Valor Busca"> 
            </dd>
            <dt>Valor Certidão:</dt>
            <dd>
                <input type="text" name="valor_certidao" id="valor_certidao" class="money" value="<?= $ci->valor_certidao ?>" placeholder="Valor Certidão"> 
            </dd>
        </dl>
        <h3>endereço do cartório</h3>
        <dl>
            <dt>Endereço:</dt>
            <dd class="line1">
                <input type="text" name="endereco" id="endereco" value="<?= ($ci->endereco) ?>" placeholder="Endereço">
            </dd>
            <dt>Número:</dt>
            <dd>
                <input type="text" name="numero" id="numero" value="<?= ($ci->numero) ?>" placeholder="Número">
            </dd>
            <dt>Complemento:</dt>
            <dd>
                <input type="text" name="complemento" id="complemento" value="<?= ($ci->complemento) ?>" placeholder="Complemento">
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
        </dl>
        <h3>informações bancárias</h3>
        <dl>
            <dt>Banco:</dt>
            <dd class="line1">
                <select name="id_banco" id="id_banco" class="chzn-select line1">
                    <option value="0">Banco</option>
                    <?php $listar = UTF_Encodes($bancoDAO->listar());
                    foreach ($listar as $f) { ?>
                    <option value="<?= $f->id_banco; ?>"<?= ($ci->id_banco == $f->id_banco) ? 'selected="selected"' : '' ?>>
                        <?= ($f->banco); ?>
                    </option>
                    <?php } ?>
                </select>
            </dd>
            <dt>Cód. Banco:</dt>
            <dd>
                <input type="text" name="cod_banco" id="cod_banco" value="<?= ($ci->cod_banco) ?>" placeholder="Cód. Banco">
            </dd>
            <dt>Agência:</dt>
            <dd>
                <input type="text" name="agencia" id="agencia" value="<?= ($ci->agencia) ?>" maxlength="15" placeholder="Agência">
            </dd>
            <dt>Conta Corrente:</dt>
            <dd>
                <input type="text" name="conta" id="conta" value="<?= ($ci->conta) ?>" maxlength="15" placeholder="Conta Corrente">
            </dd>
            <dt>Favorecido:</dt>
            <dd>
                <input type="text" name="favorecido" id="favorecido" value="<?= ($ci->favorecido) ?>" maxlength="255" placeholder="Favorecido">
            </dd>
        </dl>
        <h3>outras informações</h3>
        <dl>
            <dt>Observações:</dt>
            <dd class="line1 txta-h">
                <textarea name="obs" id="obs" placeholder="Observaçoes"><?= str_replace('<br />', "\n", ($ci->obs)); ?></textarea>
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="<?=($id_cartorio > 0) ? 'editar' : 'inserir'?> &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>