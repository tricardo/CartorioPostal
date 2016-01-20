<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('GET','uf');
pt_register('GET','id');
pt_register('GET','acao');
$dt = new ListaInteressadosDAO();

if($uf == ''){
	echo '<select name="cidade_interesse" id="cidade_interesse" class="form_estilo" style="width:240px;">'."\n";
	echo '<option value=""></option>'."\n";
    echo '</select>'."\n";
} else {
	echo '<select name="cidade_interesse" id="cidade_interesse" class="form_estilo" style="width:240px;">'."\n";
	echo '<option value=""></option>'."\n";
	$e = $dt->buscaCidadeInteresse($acao, $id, $uf);
	foreach($e as $j => $cd){
		echo '<option style="text-transform:uppercase">'.ucwords($cd->cidade_interesse).'</option>'."\n";
	}
    echo '</select>'."\n";
}
?>

