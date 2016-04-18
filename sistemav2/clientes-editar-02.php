<?php
$arr = array('descricao');

if(isset($_GET['excluir_anexo']) AND is_numeric($_GET['excluir_anexo'])){
    $clienteDAO->excluirAnexo($_GET['excluir_anexo'], $controle_id_empresa);
    $exc_anexo = 1;
    $msgbox .= MsgBox(3);
}

if($_POST AND isset($_POST['f_anexo'])){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    
    if ($descricao == "") {
        $errors++;
        $campos.='descricao;';
        $msgbox.= "preencha este campo!;";
    }
    
    if(!isset($_FILES['anexo']) OR strlen($_FILES['anexo']['name']) == 0){
        $errors++;
        $campos.='anexo;';
        $msgbox.= "selecione um arquivo!;";
    }
    
    if($errors == 0){
        $config = array();
	$config["tamanho"] = 999999;
	$config["largura"] = 1024;
	$config["altura"]  = 1024;
        $file_anexo        = $_FILES['anexo'];
        $error_image = valida_upload_pdf($file_anexo, $config);
        if ($error_image){
            $errors++;
            $campos.='anexo;';
            $msgbox.= 'Arquivo em formato inválido! O arquivo deve ser jpg, jpeg, bmp, gif, pdf ou png.';#str_replace('<br>', '', $error_image).";";
        }
     
        if($errors == 0){
            $file_path = "anexos_cliente/".date("Ym")."/";
            if(!is_dir($file_path)) mkdir($file_path);
            if($file_anexo['name']){
                preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
                $imagem_nome = $id_cliente.'_'.$controle_id_usuario.md5(uniqid(time())) . "." . $ext[1];
                $imagem_dir = $file_path.$imagem_nome;
                move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
            }
        }
        
        if($errors == 0){
            $a = new stdClass();
            $a->descricao = $descricao;
            $a->anexo = $imagem_dir;
            $a->id_cliente = $id_cliente;
            $a->id_empresa = $controle_id_empresa;
            $clienteDAO->inserirAnexo($a);
            $msgbox .= MsgBox(2);
        }
    }
   
}
$fld = date('Y-m-d') <= $data_init_cp ? 'anexos_cliente/' : '../sistema/anexos_cliente/';
?>
<form enctype="multipart/form-data" method="post" id="form2" action="<?=$link?>&opcoes_form=2">
    <h3>arquivos anexos</h3>
    <dl>
        <dt>Anexo <span>*</span>:</dt>
        <dd>
            <input type="text" name="descricao" id="descricao" value="" required placeholder="Anexo" class="required">
        </dd>
        <dt>Arquivo <span>*</span>:</dt>
        <dd>
            <input type="file" name="anexo" id="anexo" class="required" required placeholder="Arquivo">
        </dd>
        <div class="buttons">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            <input type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_anexo">
        </div>
    </dl>
    <?php
    $anexos = $clienteDAO->buscaAnexosCli($id_cliente, $controle_id_empresa);
    if(count($anexos) > 0){ ?>
    <h3>anexos</h3>
    <dl class="box">
         <table class="table1">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th class="size100">Arquivo</th>
                        <th class="size100">Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $color = '#FFFEEE';
                foreach ($anexos as $anexo) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                    <tr <?=TRColor($color)?>>
                        <td><?= utf8_encode($anexo->descricao) ?></td>
                        <td class="size100">
                            <a href="<?= $fld.$anexo->anexo ?>" target="_blank">
                                <img src="images/bt-download.png" >
                            </a>
                        </td>
                        <td class="size100">
                            <a href="<?=$link?>&opcoes_form=2&excluir_anexo=<?= $anexo->id_cliente_anexo ?>">
                                <img src="images/bt-del.png">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
         </table>
    </dl>
    <?php } ?>
</form>
