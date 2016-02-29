<?
$id_meta=127;
$pg = 'certidao_parceria';
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require_once(URL_SITE_INCLUDE.'header-parceria-u.php');
?>
<div id="container-parceria">
	<div class="box-01-parceria">
		<div class="nav-parceria">
			<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">SOLICITE SUA CERTIDÃO AGORA</h1>
			<div class="faixa-h-parceria"></div>
		</div>
	</div>
	<div class="box-01-parceria">
		<div class="nav-parceria">
				<?if($servico_desc==""){ echo ""?>
				<?}else{?>
				<?= '<p>'.$servico_desc.'</p><br /><br />'; ?>
				<?}?>
			<div class="nav-07-parceria">
				<? require_once ('certidao-servico-u.php'); ?>
			</div>
			<div class="nav-08-parceria">
				<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
					<tr>
						<td align="right" valign="middle" bgcolor="#FFFFFF">
							<a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" class="link_voltar">VOLTAR PARA PÁGINA ANTERIOR</a>
						</td>
					</tr>
					<tr>
						<td align="right" valign="middle" bgcolor="#FFFFFF">
							<a href="<?= URL_SITE;?>parceria-unilever-quem-somos/" title="Saiba mais sobre a Cartório Postal"><img src="<?= URL_IMAGES;?>pages/saiba-mais-sobre-a-cartorio-postal.png" alt="saiba mais sobre a cartorio postal" title="Saiba mais sobre a Cartório Postal" width="280" /></a>
						</td>
					</tr>
					<tr>
						<td align="right" valign="middle" bgcolor="#FFFFFF">
							<a href="<?= URL_SITE;?>parceria-unilever-contato/" title="Entre em contato Conosco"><img src="<?= URL_IMAGES;?>pages/entre-em-contato-conosco.png" alt="entre em contato conosco" title="Entre em contato Conosco" width="280" /></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-u.php'); ?>