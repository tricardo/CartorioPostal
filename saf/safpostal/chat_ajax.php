<?
require( "../includes/verifica_logado_safpostal.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
header("Content-type: application/xml; charset=iso-8859-1");
pt_register('POST','assunto');
pt_register('POST','retorno');
pt_register('POST','form');

$id_sessao = $_SESSION['safpostal_id_sessao'];
$sql = $objQuery->SQLQuery("SELECT c.*, uu.nome, ue.fantasia FROM saf_chat as c, saf_chat_sessao as s, vsites_user_usuario as uu, vsites_user_empresa as ue WHERE c.id_sessao='".$id_sessao."' and c.id_sessao=s.id_sessao and (s.id_usuario='".$safpostal_id_usuario."' or s.id_moderador='".$safpostal_id_usuario."') and c.id_usuario=uu.id_usuario and uu.id_empresa=ue.id_empresa order by chat_data desc limit 5");
$num = mysql_num_rows($sql);
if($num==''){
	echo "Esse chamado já foi encerrado!".$id_sessao;
	#exit;
}
if($assunto<>''){
	$sql2 = $objQuery->SQLQuery("insert into saf_chat (id_usuario,chat_data,assunto,id_sessao) values ('".$safpostal_id_usuario."',NOW(),'".$assunto."','".$id_sessao."')");
	echo '<b>'.$safpostal_fantasia.'<br>'.$safpostal_nome.'<br><br></b>'.$assunto.'<hr>';
}
while($res = mysql_fetch_array($sql)){
	echo '<b>'.$res['fantasia'].'<br>'.$res['nome'].'<br><br></b>'.$res['assunto'].'<hr>';
}
?>
<script type="text/javascript">
	var segundos = 0;  
	var minutos = 0;        
	var horas = 0;
	var milis = 0;
	contador();
</script>
	