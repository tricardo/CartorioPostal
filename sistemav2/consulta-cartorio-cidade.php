<?php
require("includes/verifica_logado_controle.inc.php");

$CartorioDAO = new CartorioDAO();

$atribuicao = isset($_POST['atribuicao']) ? $_POST['atribuicao'] : '';
$estado     = isset($_POST['estado']) ? $_POST['estado'] : '';
$cidade     = isset($_POST['cidade']) ? $_POST['cidade'] : '';
$cid_valor  = isset($_POST['cid_valor']) ? trim($_POST['cid_valor']) : '';
$cont       = 0;
$listar = $CartorioDAO->carregar_cartorio_cidade($atribuicao, $estado);

echo '<option value="">Cidade</option>';
foreach($listar AS $data){
    $ci = utf8_encode(ucwords(strtolower(trim($data->cidade))));
    $ci = str_replace("\'", "´", $ci);
    $checked = '';
    if(strtolower($cid_valor) == strtolower($ci)){
        $checked = ' checked="checked"';
        $chk = $ci;
    }
    echo '<option value="'.$ci.'"'.$checked.'>'.$ci.'</option>';
} ?>
<script>
    $('#<?=$cidade?>').trigger('chosen:updated');
<?php if(isset($chk)){
    echo "$('#".$cidade."_chosen a.chosen-single span').html('".$chk."');";    
}?>
</script>
