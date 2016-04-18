<?php include('header.php'); 

$permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' OR $controle_id_empresa != 1){
    header('location:pagina-erro.php');
    exit;
}

$safDAO = new SafDAO();
$empresaDAO = new EmpresaDAO();



#
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

$arr = array('id_empresa','id_categoria');
for($i = 1; $i <= 5; $i++){
    $titulo = 'titulo'.$i;
    $c->$titulo = isset($c->$titulo) ? $c->$titulo : '';
    $arr[] = $titulo;
}

if($_FILES){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    $arr1 = array('titulo1');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    
    if(isset($_FILES['arquivo1'])){
        $err = ErrorFiles($_FILES['arquivo1']['error']);
        if(!is_numeric($err)){
            $errors++;
            $campos.= 'arquivo1;';
            $msgbox.= $err.";";
        } elseif($errors == 0) {
            preg_match("/\.(sql|jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|rar|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp|cdr){1}$/i", $_FILES['arquivo1']["name"], $ext);
            if(count($ext) > 0){
                $arq = array(1);
                for($i = 2; $i <= 5; $i++){
                    if(isset($_FILES['arquivo'.$i])){
                        $err = ErrorFiles($_FILES['arquivo'.$i]['error']);
                        if(is_numeric($err)){
                            $arq[] = $i;    
                        }
                    }
                }

                $config = array();   
                $config["tamanho"] = 999999;                
                $config["largura"] = 3000;
                $config["altura"]  = 3000;
                $file_path = 'ftp_upload/';

                for($i = 0; $i < count($arq); $i++){
                    // Pega extensão do file_anexo
                    preg_match("/\.(sql|jpeg|jpg|png|gif|bmp|csv|pdf|msword|zip|rar|doc|docx|xls|xlsx|ppt|pptx|ods|odt|odp|cdr){1}$/i", $_FILES['arquivo'.$arq[$i]]["name"], $ext);
                    if(count($ext) > 0){
                        // Gera um nome único para a imagem
                        $nome = $controle_id_empresa.'.'.$controle_id_usuario.'.'.md5(uniqid(time()));
                        $imagem_nome = $nome . "." . $ext[1];
                        // Caminho de onde a imagem ficará
                        $imagem_dir = $file_path.$imagem_nome;
                        // Faz o upload da imagem
                        if(move_uploaded_file($_FILES['arquivo'.$arq[$i]]["tmp_name"], $imagem_dir)){
                            $tt = 'titulo'.$arq[$i];
                            $ci->arquivo = $imagem_nome;
                            $ci->titulo  = strlen($ci->$tt) > 0 ? $ci->$tt : $nome;
                            $ci->extensao= $ext[1];
                         #print_r($ci); exit;
                             $safDAO->inserirDonwload($ci);
                        }
                    }
                }
                $msgbox .= MsgBox(2);
            }
        }
    } else {
        $err = ErrorFiles(4);
        $errors++;
        $campos.= 'arquivo1;';
        $msgbox.= $err.";";
    }

    
}

if($errors == 0){   
    $ci = CriarVar($arr); 
}?>
<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; downloads  &rsaquo;&rsaquo; <a href="downloads.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-06').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('downloads-editar.php'.$link.'&id_download=0');
  
    CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>arquivos para download</h3>
        <dl>
            <dt>Unidade:</dt>
            <dd>
                <select name="id_empresa" id="id_empresa" class="chzn-select">
                        <option value="0" <?php if($c->id_empresa=='') echo 'selected="selected"'; ?>>Unidade</option>
                        <?php 
                        $empresas = $empresaDAO->listarTodas();
                        $p_valor = '';
                        foreach($empresas as $emp){
                            $p_valor .= '<option value="'.$emp->id_empresa.'" ';
                            $p_valor .= ($ci->id_empresa==$emp->id_empresa)?' selected="selected"':'';
                            $p_valor .= '>'.str_ireplace('Cartório Postal - ','',  utf8_encode($emp->fantasia)).'</option>';
                        }
                        echo $p_valor; ?>
                </select>
            </dd>
            <dt>Categoria:</dt>
            <dd>
                <select name="id_categoria" id="id_categoria" class="chzn-select">
                    <?php $departamentos = $safDAO->CategoriaFTP();
                    $p_valor = '';
                    foreach($departamentos as $dep){
                        $p_valor .= '<option value="'.$dep->id_ftp_categoria.'" ';
                        $p_valor .= ($ci->id_categoria==$dep->id_ftp_categoria)?' selected="selected"':'';
                        $p_valor .= '>'.utf8_encode($dep->ftp_categoria).'</option>';
                    }
                    echo $p_valor;
                    ?>
                </select>
            </dd>
            <?php for($i = 1; $i <= 5; $i++){ 
                $titulo = 'titulo'.$i; ?>
                <dt>Título <?=$i?>:</dt>
                <dd>
                    <input type="text" <?=$i == 1 ? 'class="required" required' : ''?> name="titulo<?=$i?>" id="titulo<?=$i?>" placeholder="Título <?=$i?>" value="<?=$ci->$titulo?>">
                </dd>
                <dt>Arquivo <?=$i?>:</dt>
                <dd>
                    <input type="file" <?=$i == 1 ? 'class="required" required' : ''?> name="arquivo<?=$i?>" id="arquivo<?=$i?>" placeholder="Arquivo">
                </dd>
            <?php } ?>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
    </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>