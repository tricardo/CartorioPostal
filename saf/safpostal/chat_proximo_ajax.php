<?
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

header("Content-type: application/xml; charset=iso-8859-1");
if($safpostal_id_empresa==1){
$sql = $objQuery->SQLQuery("SELECT id_sessao FROM saf_chat_sessao as s WHERE s.status_espera='Aguardando'");
$num = mysql_num_rows($sql);
if($num<>''){
	echo '<a href="?atender=1" title="Clique aqui"><strong>Atender próximo da lista ['.$num.']</strong></a>
	<script type="text/javascript">
	window.blur();
	window.focus();
	</script>';
	#exit;
} else {
	echo '<strong>Sem fila!!!</strong>';
}
?>
<script type="text/javascript">
	var segundos = 0;  
	var minutos = 0;        
	var horas = 0;
	var milis = 0;
	contador_proximo();
</script>
<? } ?>
