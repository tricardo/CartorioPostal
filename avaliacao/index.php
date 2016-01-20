<? 
if($_GET['fontstyle']<>''){
	// redirecionamento permanente
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://www.cartoriopostal.com.br/avaliacao");
	exit();
}

require('includes/header.php'); ?>

<?
pt_register('POST','submit1');

if($submit1<>''){
	pt_register('POST','periodo_ini');
	pt_register('POST','periodo_term');
	pt_register('POST','franquia');

	setcookie ("c_periodo_ini",$periodo_ini);
	setcookie ("c_periodo_term",$periodo_term);
	setcookie ("c_franquia",$franquia);

	if($submit1<>'') echo '<script>window.location=\'questoes.php\';</script>';
	exit;
}else{
	$periodo_ini	= $_COOKIE['c_periodo_term'];
	$periodo_term	= $_COOKIE['c_periodo_term'];
	$franquia		= $_COOKIE['c_franquia'];
}
?>
<div id="bg"></div>
	<div id="wrapper">
<? require('includes/topo.php'); ?>
	<div id="page">
		<div id="content">
			<div class="post">
			<h1 class="title">PESQUISA DE SATISFAÇÃO | AVALIAÇÃO DO TREINAMENTO</h1>
				<p>Prezando pela excelência em nossos serviços, colocamos esta ferramenta à sua disposição para que você possa nos ajudar a melhorar nosso processo de treinamento de franquias.</p>
				<p>Somente com sua contribuição podemos crescer juntos e cada vez mais!</p>
				<p>Para darmos início, preencha o nome da sua unidade franqueada, fique tranquilo, seus dados serão mantidos em sigilo entre nossos avaliadores, sendo apenas para controle de participantes e média para a amostragem final.</p>
				<p>Para iniciar, preencha corretamente os campos abaixo e clique em OK.</p>
				<form name="form_orcamento1" action="" method="post" enctype="multipart/form-data" class="form_certidao">
					<table border="0" width="99%" cellspacing="1" cellpadding="3">
						<tr>
							<td width="19%" align="right" valign="middle">
								PERÍODO: INÍCIO
							</td>
							<td width="28%" align="left">
								<input name="periodo_ini" type="text" value="<?= $periodo_ini?>" style="width:100%;" onKeyUp="masc_numeros(this,'##/##/####');"/>
							</td>
							<td width="20%" align="right" valign="middle">
								PERÍODO: TÉRMINO
							</td>
							<td width="33%">
								<input name="periodo_term" type="text" value="<?= $periodo_term?>" style="width:100%;" onKeyUp="masc_numeros(this,'##/##/####');"/>
							</td>
						</tr>
						<tr>
							<td align="right" valign="middle">
								FRANQUIA:
							</td>
							<td colspan="3">
								<input name="franquia" type="text" value="<?= $franquia?>" style="width:100%;"/>
							</td>
						</tr>
						<tr>
							<td colspan="4" align="center" valign="middle"><input type="submit" name="submit1" value="OK"/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<!-- end #content -->
		<div id="sidebar">
			<img src="images/imagem_avaliacao.png" border="0" alt="imagem_avaliacao">
		</div>
		<!-- end #sidebar -->
		<div style="clear:both; margin:0;"></div>
	</div>
	<!-- end #page -->


<? require('includes/rodape.php'); ?>