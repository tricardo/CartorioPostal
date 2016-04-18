<?php include('header.php'); 

$permissao = verifica_permissao('Mala Direta', $controle_id_departamento_p, $controle_id_departamento_s);
if ($controle_id_empresa != 1 AND $permissao != TRUE) {
    header('location:pagina-erro.php');
    exit;
}

$safDAO = new SafDAO();
$empresaDAO = new EmpresaDAO();

$id_comunicado = 0;


#
$c = Post_StdClass($_GET);
$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';


$link = '';
$link .= '?pagina='.$c->pagina;
$link .= strlen($c->busca) ? '&busca='.$c->busca : '';

$arr = array('texto','assunto','assinatura','id_empresa');

if($_POST){
    $ci = Post_StdClass($_POST);
    for($i = 0; $i < count($arr); $i++){
        pt_register('POST', $arr[$i]);
    }
    $arr1 = array('texto','assunto');
    for($i = 0; $i < count($arr1); $i++){
        if($$arr1[$i] == ""){
            $errors++;
            $campos.= $arr1[$i].';';
            $msgbox.= "preencha este campo!;";
        }
    }
    if($errors == 0){
        $ci->id_usuario = $controle_id_usuario;
        $ci->texto .= strlen($ci->assinatura) > 0 ? '<div class="assinatura"><img src="'.MyURL.'assinaturas/'.$ci->assinatura.'" style="width:353px; height:157px"></div>' : '';
        print_r($ci);
        exit;
        $id = $safDAO->inserirMalaDireta($ci);
        $msgbox .= MsgBox(2);
        
        $listar = $safDAO->ListUserDepto($ci);
        $email = array();
        foreach($listar AS $f){
            $email[] = $f->email;
        }
        if(count($email) > 0){
            if(PRODUCAO == 0){
                set_time_limit(0);
                require("includes/maladireta/config.inc.php");
                require("includes/maladireta/class.Email.php");
                include("includes/maladireta/class.PHPMailer.php");
                error_reporting(1);
                $mailer = new SMTPMailer();
          
                $AddBCC = implode(';',$email).';ti@cartoriopostal.com.br';
                $Subject = 'Comunicado '.$id.' - '.$ci->assunto;
									                                                                        
                if(!isset($_SESSION['username_send_mail']) OR $_SESSION['username_send_mail'] != $id){
                    $mailer->SEND('Mala Direta', lista_emails('mala_direta'), '', $AddBCC, '', $Subject, $ci->texto);
                    $_SESSION['username_send_mail'] = $id;
                }

            }
        }
    }
    
}

if($errors == 0){   
    $ci = CriarVar($arr); 
}

?>
<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; comunicados &rsaquo;&rsaquo; <a href="comunicados.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-05').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    AddRegistro('comunicados-editar.php'.$link.'&id_comunicado=0');
    CamposObrigatorios(); ?> 
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>informações do comunicado</h3>
        <dl>
            <dt>Assunto <span>*</span>:</dt>
            <dd class="line1">
                <input type="text" name="assunto" id="assunto" class="required" value="<?= ($ci->assunto) ?>" required placeholder="Assunto">
            </dd>
            <dt>Unidade:</dt>
            <dd class="line1">
                <select name="id_empresa" id="id_empresa" class="chzn-select line1">
                        <option value="0" <?php if($ci->id_empresa=='0') echo 'selected="selected"'; ?>>Todas</option>
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
            <dt>Assinaturas de E-mail:</dt>
            <dd class="line1">
                <select name="assinatura" id="assinatura" class="chzn-select line1">
                    <option value="">Assinaturas de E-mail</option>
                    <?php
                    $p_valor = '';
                    foreach (assinaturas() as $f) {
                        $p_valor.='<option value="' . $f['id'] . '"';
                        if ($ci->assinatura == $f['id'])
                            $p_valor.=' selected="select" ';
                        $p_valor.='>' . $f['texto'] . '</option>';
                    }
                    echo $p_valor;
                    ?>
                </select>
           </dd>
            <dt>Texto <span>*</span></dt>   
            <dd class="txt-ckeditor">
                <textarea name="texto" id="texto" placeholder="Texto" class="required ckeditor" required><?= str_replace('<br />', "\n", ($ci->texto)); ?></textarea><br /><br />
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="inserir &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
            </div>
        </dl>
        <script>
        preencheCampo();
        </script>
</div>
<?php include('footer.php'); ?>