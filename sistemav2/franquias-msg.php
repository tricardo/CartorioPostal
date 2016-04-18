<?php include('header.php'); 
        
    $permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
        header('location:pagina-erro.php');
        exit;
    }
    $permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
    
    $empresaDAO = new EmpresaDAO();
    $empresaMensagemDAO = new EmpresaMensagemDAO();
    
    #vars
    pt_register('GET','id');   
    pt_register('GET','pagina');
    pt_register('GET','pagina2');
    pt_register('GET','busca');
    pt_register('GET','status');
        
    #
    $link = '';
    $link .= (isset($pagina)) ? '?pagina='.$pagina : '?pagina=1';
    $link .= (isset($pagina2)) ? '&pagina2='.$pagina2 : '&pagina2=1';
    $link .= (isset($busca) AND strlen($busca) > 0) ? '&busca='.$busca : '';
    $link .= (isset($status) AND strlen($status) > 0) ? '&status='.$status : ''; 
    $link .= (isset($id)) ? '&id='.$id : '&id=0';
    $show_msgbox = 0;
    $arr   = new stdClass(); 
    
   
    $empresa = $empresaDAO->selectPorId($id);
    
    if($_POST){
        $show_msgbox = 1;
        if(date('Y-m-d') <= $data_init_cp){
            $file_path = '../sistema/anexos_franquia/';
        } else {
            $file_path = 'anexos_franquia/';
        }
        
        pt_register('POST','mensagem');
        
        $config = array();
	$config["tamanho"] = 999999;
	$config["largura"] = 1024;
	$config["altura"]  = 1024;

	$file_anexo = isset($_FILES["file_anexo"]) ? $_FILES["file_anexo"] : FALSE;
	
	if($file_anexo['name']<>''){
            $err = valida_upload_pdf($file_anexo, $config);
            if(strlen($err) > 0){
                $errors++;
                $campos.='arquivo;';
                $msgbox.= $err.";";
            }
	}
        
        
        $m = new stdClass();
	$m->mensagem = $mensagem;
	$m->id_empresa = $id;
	$m->id_usuario = $controle_id_usuario;

	if($m->mensagem==""){
            $errors++;
            $campos.='mensagem;';
            $msgbox.= "digite a mensagem!;";
	}
        
        if($errors==0) {
            $m->anexo = '';
            if($file_anexo['name']){
                preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext);
                $imagem_nome = $controle_id_usuario.$id.md5(uniqid(time())) . "." . $ext[1];
                $imagem_dir = $file_path.$imagem_nome;
                move_uploaded_file($file_anexo["tmp_name"], $imagem_dir);
                $m->anexo = $imagem_nome;
            }
            $empresaMensagemDAO->inserir($m);
            $msgbox .= MsgBox(2);
        }
    }
    
    
    ?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; franquias &rsaquo;&rsaquo; <a href="franquias-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-08').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3><?=  utf8_encode($empresa->fantasia)?></h3>
        <dl>
            <dt>Arquivo:</dt>
            <dd class="line1">
                <input type="file" name="file_anexo" id="file_anexo" placeholder="Arquivo {.doc, .xls, .pdf, .png, .jpg, .jpeg e .gif}">
            </dd>
            <dt>Mensagem <span>*</span> :</dt>
            <dd class="txta-h">
                <textarea class="required" name="mensagem" id="mensagem" placeholder="Mensagem" required></textarea>
            </dd>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                <input type="submit" value="enviar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_msg">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<div class="content-list-table"> 
    <?php $listar = $empresaMensagemDAO->listar($id,(isset($busca) ? $busca : ''),(isset($pagina2) ? $pagina2 : 1));
    if(count($listar) > 0){ ?>
        <div class="paginacao">
            <?php $empresaMensagemDAO->QTDPagina(); ?>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons size100">data</th>
                    <th>usuário</th>
                    <th class="buttons size100">anexo</th>
                    <th>mensagem</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  ?>
                <tr <?=TRColor($color)?>>
                    <td class="buttons size100"><?= $f->data?></td>
                    <td><?= $f->autor?></td>
                    <td class="buttons size100"><?php 
                    if($f->anexo<>''){
			echo '<a href="franquias-msg-anexo.php?id='.$f->id_mensagem.'" target="_blank"><img src="images/bt-message.png"></a>';
                    } else {
                        echo '-';
                    }
                    ?></td>
                    <td><?= utf8_encode(str_replace("\n","<br>",  utf8_decode($f->mensagem))) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="paginacao">
            <?php $empresaMensagemDAO->QTDPagina(); ?>
        </div>
        <script>PaginacaoWidth()</script>
    <?php } ?>
</div>
<?php include('footer.php'); ?>