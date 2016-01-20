<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?
	require_once("../includes/classQuery.php");
	require_once('../includes/global.inc.php');
	require_once('../includes/meta_tag.php');
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="shortcut icon" href="../images/icone.gif" />
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/popup.css" rel="stylesheet" type="text/css" />
	<link href="../css/jtable.css" rel="stylesheet" type="text/css" />
	<link href="../css/jphotogrid.css" rel="stylesheet" type="text/css" media="screen" /> 
	<!--[if IE]>
		<link href="<?= URL_SITE ?>css/jphotogrid.ie.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]--> 
	<script type="text/javascript" src="../js/js.js"></script>
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jcirculo/jquery.min.js"></script>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
	  {lang: 'pt-BR'}
	</script>
	<!--dock fish menu -->
	<? 
	#somente na pagina inicial
	if($pg==''){
	?>
		<!-- slide show --> 
		<link rel="stylesheet" href="../css/coin-slider-styles.css" type="text/css">
		<script type="text/javascript" src="../js/coin-slider.min.js"></script>
		<script>
		$(document).ready(function(){
			$('#banner_home').coinslider({ width:668,height:189,hoverPause: true });
		});
		</script>
	<?
	}
	?>
	<!-- Organização de tabelas -->
	<script type="text/javascript" src="../js/jtable/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="../js/jtable/jquery.tablesorter.pager.js" ></script>
	<!-- Galeria de fotos -->
	<script src="<?= URL_SITE ?>js/jgaleria/jphotogrid.js"></script>
	<script src="<?= URL_SITE ?>js/jgaleria/setup.js"></script>
	<!--dock menu JS options -->
	<script type="text/javascript" src="../js/interface.js"></script>
</head>
<body>
<div id="bg"></div>
	<div id="wrapper">
	<div id="header">
		<div id="header_e"></div>
		<div id="logo">
			<a href="."><img src="../images/logo1.png" alt="Cartório Postal"></a>
		</div>
		<div id="header_d"></div>

		<!-- end #logo -->
	</div>
<!-- end #header -->

	<div id="page">
		<div id="content">
			<div class="post">
			<h1 class="title">PERÍODO DE AVALIAÇÃO</h1>
				<?
				include("pChart/pData.class");
				include("pChart/pChart.class");
				$id = $_GET['id'];
				$data = $_GET['data'];
				if($id=='') $id=1;

				?>
				<div id="grafico">
				<form name="periodo" method="GET" action="">
				<b>Período da Avaliação: </b>
				<?= $data.'<br><br>' ?>

				<select name="data">
				<?
				$sql = $objQuery->SQLQuery("SELECT periodo_ini FROM site_avaliacao as a GROUP BY a.periodo_ini order by a.periodo_ini");
				$p_valor = '';
				$cont='';
				while($res = mysql_fetch_array($sql)){
					if($cont=='' and $data=='') $data=$res['periodo_ini'];
					$p_valor.='<option value="'.$res['periodo_ini'].'" ';
					if($res['periodo_ini']==$data) $p_valor .= ' selected ';
					$p_valor.='>'.$res['periodo_ini'].'</option>';
					$cont++;
				}
				echo $p_valor;
				?>
				</select>
				<input type="submit" name="Buscar">
				</form>
				<?

				$sql = $objQuery->SQLQuery("SELECT count(0) as total, t.id_treinador, t.treinador, 
											GROUP_CONCAT(DISTINCT a.performance ORDER BY a.performance DESC SEPARATOR '<br>- ') as performance, 
											GROUP_CONCAT(DISTINCT a.nova_participacao ORDER BY a.nova_participacao DESC SEPARATOR '<br>- ') as nova_participacao, 
											GROUP_CONCAT(DISTINCT a.criticas ORDER BY a.criticas DESC SEPARATOR '<br>- ') as criticas, 
											GROUP_CONCAT(DISTINCT a.elogios ORDER BY a.elogios DESC SEPARATOR '<br>- ') as elogios, 
											GROUP_CONCAT(DISTINCT a.eficiencia ORDER BY a.eficiencia DESC SEPARATOR '<br>- ') as eficiencia, 
											sum(questao1) as questao1, sum(questao2) as questao2, sum(questao3) as questao3, sum(questao4) as questao4, sum(questao5) as questao5, sum(questao6) as questao6, sum(questao7) as questao7, sum(questao8) as questao8 
											FROM site_treinadores as t, site_avaliacao as a WHERE a.id_treinador=t.id_treinador and a.periodo_ini='".$data."' GROUP BY a.id_treinador, a.periodo_ini order by t.treinador");
				while($res = mysql_fetch_array($sql)){
					$questao1 			= $res['questao1']/$res['total'];
					$questao2 			= $res['questao2']/$res['total'];
					$questao3			= $res['questao3']/$res['total'];
					$questao4 			= $res['questao4']/$res['total'];
					$questao5 			= $res['questao5']/$res['total'];
					$questao6 			= $res['questao6']/$res['total'];
					$questao7 			= $res['questao7']/$res['total'];
					$questao8 			= $res['questao8']/$res['total'];
					$questao = ((float)($questao1)+(float)($questao2)+(float)($questao3)+(float)($questao4)+(float)($questao5)+(float)($questao6)+(float)($questao7)+(float)($questao8))/8;
					$questao_total = ((float)($questao)+(float)($questao_total))/2;
					$performance 		= $res['performance'];
					$nova_participacao 	= $res['nova_participacao'];
					$criticas 			= $res['criticas'];
					$elogios 			= $res['elogios'];
					$eficiencia 		= $res['eficiencia'];
					$treinador 			= $res['treinador'];
					echo '<h1>'.$treinador.' - Analisado por '.$res['total'].' pessoas</h1>';
					// Dataset definition
					$DataSet = new pData;

					$DataSet->AddPoint(array(0,$questao1,$questao2,$questao3,$questao4,$questao5,$questao6,$questao7,$questao8,10),$treinador);
					$DataSet->AddAllSeries();
					$DataSet->SetAbsciseLabelSerie();
					$DataSet->SetSerieName("Nota","Serie1");
					#$DataSet->SetSerieName("February","Serie2");

					// Initialise the graph
					$Test = new pChart(700,230);
					$Test->setFontProperties("Fonts/tahoma.ttf",8);
					$Test->setGraphArea(50,30,585,200);
					$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
					$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
					$Test->drawGraphArea(255,255,255,TRUE);
					$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
					$Test->drawGrid(4,TRUE,230,230,230,50);

					// Draw the 0 line
					$Test->setFontProperties("Fonts/tahoma.ttf",6);
					$Test->drawTreshold(0,143,55,72,TRUE,TRUE);

					// Draw the bar graph
					$Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());

					// Finish the graph
					$Test->setFontProperties("Fonts/tahoma.ttf",8);
					$Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
					$Test->setFontProperties("Fonts/tahoma.ttf",10);
					$Test->drawTitle(50,22,$res['treinador'],50,50,50,585);
					$Test->Render("example".$res['id_treinador'].".png");
					?>
					<img src="example<?=$res['id_treinador'] ?>.png" alt="<?=$res['id_treinador'] ?>" width="670"/>
					<b>Média: </b> <?= number_format($questao,2); ?>
					<br><br><b>Questões</b><br>
					<label style="color:#0000FF">Pergunta 1: O Treinamento foi eficiente?</label> <?= number_format($questao1,2) ?><br>
					<label style="color:#0000FF">Pergunta 2: Parte teórica foi condizente com a parte prática?</label> <?= number_format($questao2,2) ?><br>
					<label style="color:#0000FF">Pergunta 3: Parte prática foi suficiente para seu aprendizado?</label> <?= number_format($questao3,2) ?><br>
					<label style="color:#0000FF">Pergunta 4: O conteúdo foi suficiente para seu aprendizado?</label> <?= number_format($questao4,2) ?><br>
					<label style="color:#0000FF">Pergunta 5: Carga Horária foi adequada?</label> <?= number_format($questao5,2) ?><br>
					<label style="color:#0000FF">Pergunta 6: O instrutor soube tirar as dúvidas com clareza?</label> <?= number_format($questao6,2) ?><br>
					<label style="color:#0000FF">Pergunta 7: Como foi sua participação no treinamento?</label> <?= number_format($questao7,2) ?><br>
					<label style="color:#0000FF">Pergunta 8: Sala de treinamento estava adequada para o aprendizado?</label> <?= number_format($questao8,2) ?><br><br>

					<label style="color:#0000FF">Quais suas atitudes para melhorar sua performance profissional?</label><br>- <? echo $performance ?><br><br>
					<label style="color:#0000FF">Se você participasse novamente deste treinamento, o que faria de diferente?</label><br>- <? $nova_participacao ?><br><br>
					<label style="color:#0000FF">Críticas e pontos a melhorar em nosso treinamento:</label><br>- <? echo $criticas ?><br><br>
					<label style="color:#0000FF">Elogios e sugestões:</label><br>- <? echo $elogios ?><br><br>
					<label style="color:#0000FF">Pensando em eficiência, o que poderia ser melhorado para o próximo treinamento?</label><br>- <? echo $eficiencia ?>

				<? } ?>
				<h1>Média total do treinamento: <?= number_format($questao_total,2,',','') ?></h1>
				<!--<br><br><a href="javascript:history.back()" title="Clique aqui">Anteiror</a> | <a href="?id=<?= $id+1?>&data=<?= $data ?>" title="Clique aqui">Próximo</a>-->

				<?

				#$sql = $objQuery->SQLQuery("SELECT t.id_treinador, t.treinador, 
				#							a.performance,
				#							a.nova_participacao,
				#							a.criticas, 
				#							a.elogios, 
				#							a.eficiencia, 
				#							questao1,questao2,questao3,questao4,questao5,questao6,questao7,questao8 
				#							FROM site_treinadores as t, site_avaliacao as a WHERE a.id_treinador=t.id_treinador and a.periodo_ini='".$data."' order by t.treinador");
				#while($res = mysql_fetch_array($sql)){
				#echo $res['treinador'];
				?>
				<!--	<br><br><b>Questões</b><br>
					<label style="color:#0000FF">Pergunta 1: O Treinamento foi eficiente?</label> <?= number_format($res['questao1'],2) ?><br>
					<label style="color:#0000FF">Pergunta 2: Parte teórica foi condizente com a parte prática?</label> <?= number_format($res['questao2'],2) ?><br>
					<label style="color:#0000FF">Pergunta 3: Parte prática foi suficiente para seu aprendizado?</label> <?= number_format($res['questao3'],2) ?><br>
					<label style="color:#0000FF">Pergunta 4: O conteúdo foi suficiente para seu aprendizado?</label> <?= number_format($res['questao4'],2) ?><br>
					<label style="color:#0000FF">Pergunta 5: Carga Horária foi adequada?</label> <?= number_format($res['questao5'],2) ?><br>
					<label style="color:#0000FF">Pergunta 6: O instrutor soube tirar as dúvidas com clareza?</label> <?= number_format($res['questao6'],2) ?><br>
					<label style="color:#0000FF">Pergunta 7: Como foi sua participação no treinamento?</label> <?= number_format($res['questao7'],2) ?><br>
					<label style="color:#0000FF">Pergunta 8: Sala de treinamento estava adequada para o aprendizado?</label> <?= number_format($res['questao8'],2) ?><br><br>
				-->
				<?
				#}
				?>
				</div>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<img src="../images/imagem_avaliacao.png" border="0" alt="imagem_avaliacao">
		</div>
		<!-- end #sidebar -->
		<div style="clear:both; margin:0;"></div>
	</div>
	<!-- end #page -->


<? require('../includes/rodape.php'); ?>