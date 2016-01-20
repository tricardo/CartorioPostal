	<div id="footer">
		<div id="texto_rodape">
			
			<?
			if($fr->tel)
				echo 'Atendimento '.$fr->fantasia.' - <strong>'.$fr->tel;
			else
				echo 'Central de Atendimento  <strong>(11) 3103-0800';
			?></strong><br>
			Copyright© 2011. Cartório Postal. Todos os Direitos Reservados.
			<a href="#">Política de Privacidade</a><br>Desenvolvido por <a href="http://www.canaldosprofissionais.com.br" target="_blank" title="Clique aqui"><strong>CANAL DOS PROFISSIONAIS</strong></a>
		</div>
	</div>
<!-- end #footer -->
<?
#	<script type="text/javascript">
#		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
#		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
#
#		try {
#		var pageTracker = _gat._getTracker("UA-11318282-1");
#		pageTracker._trackPageview();
#	</script>
#
?>

</body>
</html>