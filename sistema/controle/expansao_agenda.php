<?php require('header.php'); ?>

<div id="topo">
<?php
$permissao = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$c      = new stdClass();
$ficha  = new ExpansaoFichaDAO();
$lista  = new ExpansaoListaInteressadosDAO();
$status = new ExpansaoStatusDAO();
foreach($_POST as $cp => $valor){ $c->$cp = $valor; }

if($c->usuario > 0 and $c->duplicidade==''){
	if($c->id_ficha){
		for($i = 0; $i < count($c->id_ficha); $i++){
			$sql = $ficha->direcionaUsuario($c->id_ficha[$i], $c->usuario);
		}
	} else {
		//$msg = '<div style="padding:8px; color:#FF0000;">Você deve selecionar um consultor e pelo menos 1 interessado.</div>';
	}
}

if($c->usuario > 0 and $c->duplicidade==''){
	if($c->id_ficha){
		for($i = 0; $i < count($c->id_ficha); $i++){
			$sql = $ficha->direcionaUsuario($c->id_ficha[$i], $c->usuario);
		}
	} else {
		//$msg = '<div style="padding:8px; color:#FF0000;">Você deve selecionar um consultor e pelo menos 1 interessado.</div>';
	}
} else {
	if($c->duplicidade!='' and $c->id_ficha){
		for($i = 0; $i < count($c->id_ficha); $i++){
			$sql = $ficha->cancelaFicha($c->id_ficha[$i], $controle_id_usuario);
			
		}
	}
}


$c->acao = 1;
$t = 60;
$mostrar = 1;

if($c->lim){ 
	$c->lim1 = ($c->lim * $t) - $t; 
	$c->lim2 = $t - 1;
} else {
	$c->lim1 = 0; 
	$c->lim2 = $t;
	$c->lim  = 1;
}
$c->id_usuario = $controle_id_usuario;

?>
<h1 class="tit"><img src="../images/tit/tit_cliente.png" alt="Título" />Expansão de Franquia</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<link href="../css/calendar.css" rel="stylesheet" type="text/css" />
<script>
function carrega_calendar(mes,ano){
	ajaxGet("../carrega_combo/eventos_process.php?mes="+mes+"&ano="+ano,document.getElementById("calendario"), true);
	ajaxGet("../carrega_combo/eventos_process_mes.php?mes="+mes+"&ano="+ano,document.getElementById("calendario_mes"), true);
}

function carrega_evento(dia,mes,ano){
	$('#calendario li').removeClass('atual');
	$('#dia'+dia).addClass('atual');
	ajaxGet("../carrega_combo/eventos_process_even.php?dia="+dia+"&mes="+mes+"&ano="+ano,document.getElementById("calendario_even"), true);
}
</script>
	<div id="calendario_mes"></div>
	<div id="calendario"></div>
	<div id="calendario_even"></div>
	<script>
		<? 
		$mes=date('m');
		$ano=date('Y');
		?>
		carrega_calendar('<?= $mes ?>','<?= $ano ?>');
	</script>		

</div>
<?php
require('footer.php');
?>