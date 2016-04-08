<?php
require("includes.php");

$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
    header('location:pagina-erro.php');
    exit;
}

$arquivoitemDAO = new ArquivoItemDAO();

pt_register('GET','id_arquivo');
$c = Post_StdClass($_GET);


$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->id_arquivo = isset($id_arquivo) ? $id_arquivo : 0;

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';


$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

if($_POST){
    $arquivoitemDAO = new ArquivoItemDAO();
    $cep = new CepDAO();
    $show_msgbox = 1;
    $p = Post_StdClass($_POST);
    $arr1 = array('nome','cpf','cidade','estado');
    pt_register('GET','id_arquivo');
    
    for($j = 0; $j < count($_POST['id_arquivo_item']); $j++){
        $errors1 = 0;
        $msgbox1 = '';
        for($i = 0; $i < count($arr1); $i++){
            if($_POST[$arr1[$i]][$j] == ""){
                $errors++;
                $errors1++;
                $campos.= $arr1[$i].''.$_POST['id_arquivo_item'][$j].';';
                $msgbox.= "preencha este campo!;";
                $msgbox1.= "preencha este campo!;";
            }
        }
        
        if($errors1 == 0){            
            $cpf = $_POST['cpf'][$j];
            if(strlen($cpf) == 14) {
                $valida = validaCPF($cpf);
                if ($valida == 'false') {
                   $errors++;
                   $errors1++;
                   $campos.='cpf'.$_POST['id_arquivo_item'][$j].';';
                   $msgbox.="CPF Inválido, digite corretamente!;";
                   $msgbox1.="CPF Inválido, digite corretamente!;";
                }
            } else {
                $valida = validaCNPJ($cpf);
                if ($valida == 'false') {
                   $errors++;
                   $errors1++;
                   $campos.='cpf'.$_POST['id_arquivo_item'][$j].';';
                   $msgbox.="CNPJ Inválido, digite corretamente!;";
                   $msgbox1.="CNPJ Inválido, digite corretamente!;";
                }
            }
        }
        if($errors > 10){ break; }
        
        if($errors1 == 0){
            $d = new stdClass();
            $d->cidade = $_POST['cidade'][$j];
            $d->estado = $_POST['estado'][$j];
            $dt = $cep->log_import($d);
            if($dt[0]->total==0){
                $errors++;
                $errors1++;
                $campos.='cidade'.$_POST['id_arquivo_item'][$j].';';
                $msgbox.="Cidade ou Estado Inválidos!";
                $msgbox1.="Cidade ou Estado Inválidos!";
            }
        }
        if($errors > 10){ 
            break;
        }
        
        if($errors1 == 0){
            $arquivoitemDAO = new ArquivoItemDAO();
            $ret = $arquivoitemDAO->listaRemessaCPorIDItem($_POST['id_arquivo_item'][$j],$controle_id_empresa);
            if(count($ret) > 0){
                $aItem = new stdClass();
                $aItem->nome= $_POST['nome'][$j];
		$aItem->cpf= $_POST['cpf'][$j];
		$aItem->cidade=$_POST['cidade'][$j];
		$aItem->estado=$_POST['estado'][$j];
		$aItem->erro= $msgbox1;
		$ret2 = $arquivoitemDAO->atualizaArquivoItem($aItem,$ret,$ret->id_arquivo,$_POST['id_arquivo_item'][$j],$controle_id_usuario,$controle_id_empresa);
            } else {
                $errors++;
                $errors1++;
                $campos.='nome'.$_POST['id_arquivo_item'][$j].';';
                $msgbox.="Não foi possível registrar o serviço!";
            }
        }
        
        if($errors > 10){ break; }
        
    }
    if($errors == 0){
        $msgbox .= MsgBox();
    }
}

include('header2.php');
?>
<script>
    menu(3,'bt-06');
    $('#titulo').html('arquivos &rsaquo;&rsaquo; <a href="log-de-importados.php" id="voltar">log de importados</a> &rsaquo;&rsaquo; erros');
    $('#sub-42').css({'font-weight':'bold'});
</script>
<div class="content-list-forms"></div>
<div class="content-list-table">   
<?php $listar = $lista = $arquivoitemDAO->listaRemessaCPorID($c->id_arquivo,$controle_id_empresa); ?>
    <form method="post" id="form1" name="form1" action="?id_arquivo=<?=$id_arquivo?>">
        <div class="buttons2">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href='log-de-importados.php'">
            <input type="button" value="editar &rsaquo;&rsaquo;" onclick="$('#form1').submit()">
        </div>
        <table>
            <thead>
                <tr>
                    <th>nome</th>
                    <th>cpf/cnpj</th>
                    <th>cidade</th>
                    <th class="buttons size150">estado</th>
                    <th>erro</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($listar as $f) { 
                    $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
                <tr <?=TRColor($color)?>>
                    <td><input type="text" id="nome<?=$f->id_arquivo_item?>" name="nome[]" value="<?=utf8_encode($f->certidao_nome)?>"></td>
                    <td><input type="text" id="cpf<?=$f->id_arquivo_item?>" name="cpf[]" class="cpf" value="<?=$f->certidao_cpf?>"></td>
                    <td><input type="text" id="cidade<?=$f->id_arquivo_item?>" name="cidade[]" value="<?=utf8_encode($f->certidao_cidade)?>"></td>
                    <td class="buttons">
                         <select class="chzn-select" name="estado[]" id="estado">
                                <?php $estado = UFs();
                                for($i = 0; $i < count($estado); $i++){ ?>
                                        <option value="<?=$estado[$i]?>" <?=($estado[$i] == $f->certidao_estado) ? 'selected="selected"' : ''?>><?=$estado[$i]?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="id_arquivo_item[]" id="id_arquivo_item<?=$f->id_arquivo_item?>" value="<?=$f->id_arquivo_item?>">
                    </td>
                    <td><?=utf8_encode($f->erro)?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="buttons2">
            <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href='log-de-importados.php'">
            <input type="button" value="editar &rsaquo;&rsaquo;" onclick="$('#form1').submit()">
        </div>
        <script>PaginacaoWidth()</script>
    </form>
</div>
<?php include('footer.php'); ?>