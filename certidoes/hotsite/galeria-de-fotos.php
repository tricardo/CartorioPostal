<?
$id_pagina=4;
$pg = 'paginas_hotsite';
require('../includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-imagens-paginas">
			<img src="<?= URL_IMAGES;?>hotsite/galeria-de-fotos.png" alt="Acesse nossa Galeria de Fotos" title="Acesse nossa Galeria de Fotos" />
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-02">
					<table width="100%" border="0" align="left" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF">
								<h5 style="font-weight: bold; color: #202A72; text-transform: uppercase;">GALERIA DE FOTOS:.</h5>
								<div class="faixa-h" style="margin-bottom: 5px;"></div>
								<?
								$lgaleria = $siteDAO->selecionaFranquiaGaleriaPorIdH($fr->id_empresa);
								if($lgaleria[0]->imagem<>''){
									$p_valor = '<ul class="franquia-galeria">';
									foreach($lgaleria as $l){
										$p_valor .= '
										<li>
											<a href="'.URL_UPLOAD.''.$l->imagem.'" title="'.$l->descricao.'" rel="shadowbox[vocation]">
												<img src="'.URL_UPLOAD.''.$l->imagem.'" alt="'.str_replace("-"," ",$l->url_amigavel).'" title="'.$l->descricao.'" width="220"/>
											</a>
										</li>';
									}
									echo $p_valor.'</ul>';
								} else {
									echo 'Nenhuma foto da unidade foi encontrada';
								}
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-hotsite.php'); ?>