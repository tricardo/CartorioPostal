<?
$id_pagina=3;
$pg = 'paginas_hotsite';
require('../includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-imagens-paginas">
			<img src="<?= URL_IMAGES;?>hotsite/canal-de-imprensa.png" alt="Canal de Imprensa" title="Canal de Imprensa" />
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-03">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
								<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">CANAL DE IMPRENSA:.</h1>
								<div class="faixa-h"></div>
							</td>
						</tr>
						<?
						$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE '".$fr->id_empresa."'=ns.id_empresa AND ns.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY ns.ordem DESC");
						while($res = mysql_fetch_array($sql)){
						?>
						<tr>
							<td><div style="width: 250px; height: 110px; overflow: hidden;"><a href="" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" width="250" /></a></div></td>
							<td align="left" valign="top">
								<div style="padding: 0 10px;">
									<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" class="link-titulo-ultima-noticia"><?= $res['titulo_news'];?></a><br /><br />
									<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" class="link-texto-ultima-noticia"><?= $res['texto_chamada'];?></a>
								</div>
							</td>
						</tr>
						<tr>
							<td height="5" colspan="2"></td>
						</tr>
						<?}?>
					</table>
				</div>
				<div class="nav-04">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF">
								<span style="font-weight: bold; font-size: 15px; color: #202A72; text-transform: uppercase;">NOTÍCIAS MAIS ACESSADAS:.</span>
								<div class="faixa-h"></div>
								<ul>
								<?
								$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.acesso, date_format(ns.data, '%d/%m/%Y') as data FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE '".$fr->id_empresa."'=ns.id_empresa AND ns.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY ns.acesso DESC LIMIT 10");
								while($res = mysql_fetch_array($sql)){
								?>
									<li>
										<table width="100%" border="0" align="center" cellspacing="1" cellpadding="1">
											<tr>
												<td align="center" valign="middle"><div class="imagem-leia-mais"><a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['titulo_news'];?>" title="<?= $res['titulo_news'];?>" width="150" /></a></div></td>
												<td align="left" valign="top"><div class="texto-leia-mais"><a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>"><?= $res['titulo_news'];?></a></div></td>
											</tr>
										</table>
									</li>
								<?}?>
								</ul>
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle">
								<a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/certidao" title="Solicite sua Certidão aqui na Cartório Postal">
									<img src="<?= URL_IMAGES;?>pages/faca-seu-pedido.png" alt="solicite sua certidao aqui na cartorio postal" title="Solicite sua Certidão aqui na Cartório Postal" />
								</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-hotsite.php'); ?>