<?php include('header.php'); 


$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao2 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);


if($permissao == 'FALSE'){
    header('location:pagina-erro.php');
    exit;
}

$expansaoDAO = new ExpansaoDAO();
$expansaoStatusDAO = new ExpansaoStatusDAO();

pt_register('GET','opcoes_form');
pt_register('GET','id_ficha');
$id_ficha = isset($id_ficha) ? $id_ficha : 0;
$opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
$show_msgbox = 0;

$ci = Post_StdClass($_GET);
$ci->id_ficha = $id_ficha;
$ci->consultor = isset($ci->consultor) ? $ci->consultor : '';
$ci->nome = isset($ci->nome) ? $ci->nome : '';
$ci->id_status = isset($ci->id_status) ? $ci->id_status : '';
$ci->uf = isset($ci->uf) ? $ci->uf : '';
$ci->cidade = isset($ci->cidade) ? $ci->cidade : '';
$ci->mes = isset($ci->mes) ? $ci->mes : '';
$ci->ano = isset($ci->ano) ? $ci->ano : '';
$ci->pagina = isset($ci->pagina) ? $ci->pagina : 1;
$ci->pg = isset($ci->pg) ? $ci->pg : '';


#
$link = '';
$link .= (isset($ci->pagina)) ? '?pagina='.$ci->pagina : '?pagina=1';
$link .= (isset($ci->busca) AND strlen($ci->busca) > 0) ? '&busca='.$ci->busca : '';

?>

<script>
    menu(3,'bt-03');
    $('#titulo').html('expansão &rsaquo;&rsaquo; fichas &rsaquo;&rsaquo; <a href="expansao-fichas-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-21').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php 
    if($id_ficha > 0){ ?>
        
         <div class="opcoes">
            <label>selecione uma opção: </label>
            <select onchange="opcoesForm(this.value)" id="opcoes_form">
                <option value="1"<?=$opcoes_form == 1 ? ' selected="selected"' : ''?>>Informações do Candidato</option>
                <option value="2"<?=$opcoes_form == 2 ? ' selected="selected"' : ''?>>Informações Empresariais</option>
                <option value="3"<?=$opcoes_form == 3 ? ' selected="selected"' : ''?>>Infoprmações Bancárias</option>
                <option value="4"<?=$opcoes_form == 4 ? ' selected="selected"' : ''?>>Informações Jurídicas</option>
                <option value="5"<?=$opcoes_form == 5 ? ' selected="selected"' : ''?>>Histórico</option>
            </select>
        </div>
    <?php 
    } 
    AddRegistro('expansao-fichas-editar.php'.$link.'&id_ficha=0');
        $link .= '&id_ficha='.$ci->id_ficha; 
    CamposObrigatorios(); 
    
    if($_GET AND isset($_GET['excluir']) AND $_GET['excluir'] == 1 AND isset($_GET['id_arquivo']) AND $_GET['id_arquivo'] > 0){
        $expansaoDAO->list_form_del_anexo($id_ficha, $_GET['id_arquivo'], $controle_id_usuario);
        $msgbox .= MsgBox();
    }

    if($_POST){
        $ci = UTF_Encodes(Post_StdClass($_POST),2);
        $ci->id_ficha = $id_ficha;
        if(isset($ci->f_cadastro)){ $expansaoDAO->list_form_edit(1, $ci); }
        elseif(isset($ci->f_empresarial)){ $expansaoDAO->list_form_edit(2, $ci); }
        elseif(isset($ci->f_bancaria)){ $expansaoDAO->list_form_edit(3, $ci); }
        elseif(isset($ci->f_juridica)){ $expansaoDAO->list_form_edit(4, $ci); }
        elseif(isset($ci->f_historico)){ $expansaoDAO->list_form_edit(5, $ci); }


        if($id_ficha > 0){
            $msgbox .= MsgBox();
        } else {
            $msgbox .= MsgBox(2);
        }

    } 
    $c = $expansaoDAO->list_forms($ci->id_ficha);
    $c = UTF_Encodes($c[0]); 
    $travar = ($id_ficha > 0) ? TravaFormExp($c->id_status) : '';
    
    include('expansao-fichas-editar-01.php');
    if($id_ficha > 0){
        include('expansao-fichas-editar-02.php');
        include('expansao-fichas-editar-03.php');
        include('expansao-fichas-editar-04.php');
        include('expansao-fichas-editar-05.php');
    }
    ?>
    <script>
        opcoesForm(<?=$opcoes_form?>);
        preencheCampo();
    </script>
    <?php if(isset($_POST['f_anexo']) OR isset($exc_anexo)){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(<?=($_POST) ? 1 : (isset($exc_anexo) ? 1 : 0)?>,<?=$errors?>,'<?=$ciampos?>','<?=$msgbox?>');
        </script>
    <?php
    }
    $errors=0;
    $ciampos='';
    $msgbox='';
    ?>
</div>
<?php include('footer.php'); ?>