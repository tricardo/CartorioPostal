<? require('topo.php'); ?>
<div style="height:600px">
	<script>
	function carrega_calendar(mes,ano){
		document.getElementById('calendario_even').innerHTML = '';
		ajaxGet("agenda-processo-mes.php?mes="+mes+"&ano="+ano,document.getElementById("calendario_mes"), true);
		ajaxGet("agenda-processo.php?mes="+mes+"&ano="+ano,document.getElementById("calendario"), true);
		
	}

	function carrega_evento(dia,mes,ano){
		document.getElementById('calendario_even').innerHTML = '';
		$('#calendario li').removeClass('atual');
		$('#dia'+dia).addClass('atual');
		ajaxGet("agenda-processo-even.php?dia="+dia+"&mes="+mes+"&ano="+ano,document.getElementById("calendario_even"), true);
	}
	</script>
	<div id="calendario_mes"></div>
	<div id="calendario"></div>
	<div id="calendario_even"></div>
	<script>
		<? $mes=date('m'); $ano=date('Y'); 
		if($c->busc_agenda == 1){
			echo "carrega_calendar('".$c->mes."','".$c->ano."');\n";
			echo "carrega_evento('".$c->dia."','".$c->mes."','".$c->ano."');parent.document.getElementById('expansao_frame').style.height='2000px'";
		} else{
			echo "carrega_calendar('".$mes."','".$ano."');";
		} ?>
	</script>	
</div>
<? require('rodape.php'); ?>