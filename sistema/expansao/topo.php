<? ob_start();
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistecart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>

	<!-- Inicio -->
	<link href="../js/box_movel2/inettuts.css" rel="stylesheet"	type="text/css" />
	<link rel="shortcut icon" href="../images/icone.gif" />

	<!-- Geral -->
	<style type="text/css">
		@import url(../css/style.css);
		@import url(../css/help.css);
		@import url(../css/calendar.css);		
	</style>

	<script	src="../js/jquery.js" type="text/javascript"></script> 
	<script src="../js/box_movel2/jquery-1.2.6.min.js" type="text/javascript"></script>
	<script src="../js/ajax.js" language="javascript"></script> 
	<script	src="../js/interface.js" type="text/javascript"></script> 
	<script	src="../js/maskedinput.js" type="text/javascript"></script>
	<script	src="../js/jquery-mask-money.js" type="text/javascript"></script>
	<script src="../js/js.js" language="javascript"></script> 

	<!-- tooltip - HELP -->
	<script	src="../js/jtip.js" type="text/javascript"></script> 

	<!-- efeito de abas -->
	<link rel="stylesheet" href="../css/jquery.tabs.css" type="text/css" media="print, projection, screen">
		<script	src="../js/abas/jquery.tabs.pack.js" type="text/javascript"></script> 

		<!-- jquery models -->
		<link href="../css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
		<script	src="../js/jquery.alerts.js" type="text/javascript"></script> 

		<script	type="text/javascript">
			$(function() {
				$('#container-hotsite').tabs({ fxSlide: false, fxFade: false, fxSpeed: 'normal' });
			});
		</script> 
		<!-- fim do efeito de abas --> 

		<script>
			$(function(){                
				$(".menuv li.submenu").each(function(){
					var el = $('#' + $(this).attr('id') + ' ul:eq(0)');
				
					$(this).hover(function(){
						el.show();
					}, function(){
						el.hide();
					});
				});
			
				$(".menuh li.subv").each(function(){
					var el = $('#' + $(this).attr('id') + ' ul:eq(0)');
				
					$(this).hover(function(){
						el.show();
					}, function(){
						el.hide();
					});
				});
			});
		</script>
</head>
<body><?
$expansao = new ExpansaoDAO();
$strings  = new StringsDAO();
$expansaos= new ExpansaoStatusDAO();
$c        = new stdClass();
$c->c_id_usuario = $controle_id_usuario;
$c->c_nome     = $controle_nome; 

$exp_item = $expansao->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);
if($exp_item->acesso == 0 and $controle_id_empresa != 1){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	require('rodape.php');
	exit;
}

if((isset($_GET)) || (isset($_POST))){
    if(isset($_GET)){
        foreach($_GET as $cp => $valor){ $c->$cp = $strings->html_entities('', $valor); }
    }
    if(isset($_POST)){
        foreach($_POST as $cp => $valor){ $c->$cp = $strings->html_entities('', $valor); }
    }
} 
switch($c->pg_clk){
	case 'direcionamento': $voltar = 'direcionamento.php'; break;
	case 'duplicidades': $voltar = 'duplicidade.php'; break;
	default: $voltar = 'fichas.php';
} ?>