<? require('header.php'); 
if($exp_item->acesso == 0) { 
	echo '<br><br><br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
	require('footer.php');
	exit;
} ?>
<div id="topo">
	<h1 class="tit" style="padding-bottom:0;">
		<img src="../images/tit/tit_cliente.png" alt="T�tulo" /> 
		Expans�o de Franquia
		<a href="#" class="topo"><span id="titulo_pagina">Fichas</span> - topo</a>
		<hr class="tit" />
	</h1>
	<table style="width:670px;float:left;margin-top:-22px;margin-left:200px;">
		<tr>
			<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/agenda.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Agenda')">Agenda</a></td>
			<!--
			<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/data-de-cadastro.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Data de Cadastro')">Data de Cadastro</a></td>-->
			<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/direcionamento.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Direcionamento')">Direcionamento</a></td>
			<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/duplicidades.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Duplicidades')">Duplicidades</a></td>
			<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/fichas.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Fichas')">Fichas</a></td>
			<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/relatorio.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Relat�rio')">Relat�rio</a></td>
			<!--<td style="width:20px;text-align:center;font-weight:bold">|</td>
			<td style="text-align:center"><a style="text-decoration:none;font-weight:bold" href="../expansao/relacionamento.php" target="expansao_frame" onclick="$('#titulo_pagina').html('Relacionamento')">Relacionamento</a></td>-->
		</tr>
	</table>	
</div>
<div id="meio">
	<iframe name="expansao_frame" id="expansao_frame" onload="iframeAutoHeight(this)" style="width:100%;height:100%;min-height:100%;border:0" src="../expansao/fichas.php" scrolling="no" frameborder="0"></iframe>
</div>
<? require('footer.php'); ?>