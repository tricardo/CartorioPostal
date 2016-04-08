<?php 
@ini_set("memory_limit",'500M');
set_time_limit(1000);
include('header.php'); 

$permissao = verifica_permissao('Pedido Import Cart',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    
    $file_import = isset($_FILES["file_import"]) ? $_FILES["file_import"] : FALSE;
    
    if($file_import['name']<>''){  
        $error_image = valida_upload_txt($file_import);
        if ($error_image){
            $errors=1;
            $big_msg_box = $error_image;
        }
    } else {       
        $errors=1;
        $big_msg_box = "Selecione o arquivo de importação!;";
    }
    
    if($errors!=1) {
        if($file_import['name']<>''){
            $file_path = "retorno/";
            // Pega extensão do file_import
            preg_match("/\.(txt|ret){1}$/i", $file_import["name"], $ext);
            // Gera um nome único para a imagem
            $imagem_nome = str_replace('.ret','',$file_import["name"]).$controle_id_usuario.'_'.md5(uniqid(time())) . "." . $ext[1];
            // Caminho de onde a imagem ficará
            $imagem_dir = $file_path.$imagem_nome;
            // Faz o upload da imagem
            move_uploaded_file($file_import["tmp_name"], $imagem_dir);
            $file_import_name = $imagem_nome;
        } else {
            $file_import_name = $file_import_name_imp;
        }
        require("retorno-do-cartorio-import.php");
        if ($errors) {
            $big_msg_box = $error;
		
	}
	if ($done) {
            $big_msg_box = '<h3>Arquivo importado com sucesso!</h3>
		<h3>As ordens em vermelho não foram atualizadas: '.$ordens.'</h3>';
	}
    }
}

?>

<script>
    menu(3,'bt-06');
    $('#titulo').html('arquivos &rsaquo;&rsaquo; retorno do cartório');
    $('#sub-40').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php CamposObrigatorios(); ?>  

   <form enctype="multipart/form-data" method="post">
    <h3>informações</h3>
    <dl>
        <dt>Arquivo <span>*</span>:</dt>
        <dd class="line1">
            <input type="file" name="file_import" id="file_import" class="required" required placeholder="Arquivo">
        </dd>
        <div class="buttons">
            <input type="submit" value="importar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
   </form>
    <script>
        preencheCampo();
    </script>
</div>
<?php include('footer.php'); ?>
