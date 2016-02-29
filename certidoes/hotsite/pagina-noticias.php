<?
$id_meta=1;
$pg = 'pagina_news_hotsite';
require('../includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.chave, ns.descricao, ns.fonte, ns.imagem_news, ns.texto_chamada, ns.texto, ns.destaque, ns.escrito, date_format(ns.data, '%d/%m/%Y') as data FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE '".$fr->id_empresa."'=ns.id_empresa AND ns.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' AND ns.id_news='".$id."'");
$objQuery->SQLQuery("UPDATE cp_news_nova as ns SET acesso = acesso+1 WHERE id_news = '$id'");
$res = mysql_fetch_array($sql);
$comentarios = $objQuery->SQLQuery("SELECT count(*) as comentarios FROM cp_comentario_news as cn, cp_news_nova as ns WHERE ns.id_news=cn.id_news AND cn.st_id='1' AND ns.id_news='".$id."'");
$cont_on = mysql_fetch_array($comentarios);
$id_news = $id;
#print_r($_GET);
#exit;
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-imagens-paginas">
			<img src="<?= URL_IMAGES;?>hotsite/canal-de-imprensa.png" alt="Canal de Imprensa" title="Canal de Imprensa" />
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-05">
					<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 20px;">
						<tr>
							<td><span style="font-size: 12px; color: #666666;">Publicado em: <?= $res['data'];?></span></td>
							<td><a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link-voltar">VOLTAR</a></td>
						</tr>
					</table>
					<h1 style="font-size: 35px; font-weight: bold; color: #000000;"><?= $res['titulo_news'];?></h1><br /><br />
					<p style="line-height: 150%; font-size: 18px; color: #666666;"><?= $res['texto_chamada'];?></p>
					<div class="linha_h2"></div>
					<table width="100%" border="0" align="center" cellspacing="2" cellpadding="2" style="margin-top: 20px;">
						<tr>
							<td width="36%"><span style="font-size: 12px; color: #666666;">Fonte: <?= $res['fonte'];?></span></td>
							<td width="21%"><span style="font-size: 12px; color: #666666;">Por: <?= $res['escrito'];?></span></td>
							<td width="3%"><a href="javascript:self.print()" title="Clique aqui para imprimir está notícia"><img src="<?= URL_IMAGES;?>pages/imprimir.gif" alt="clique aqui para imprimir esta noticia" title="Clique aqui para imprimir está notícia" /></a></td>
						</tr>
						<tr>
							<td colspan="2">
								<div id="fb-root"></div>
								<div class="fb-like" data-send="false" data-width="350" data-show-faces="true"></div>
							</td>
							<td>
								<a href="http://www.facebook.com/share.php?u=<?= $url_rede;?>" target="_blank">
								<img src="<?= URL_IMAGES;?>/pages/facebook-share.png" alt="compartilhar no facebook" title="Compartilhar no Facebook" />
								</a>
							</td>
							<td width="4%"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="cartoriopostal" rel="nofollow">Tweetar</a></td>
							<td width="36%">
								<a class="a2a_dd" href="http://www.addtoany.com/share_save?linkurl=<?= $url_rede;?>;linkname=CabideiroCultural"><img src="<?= URL_IMAGES ?>icon/bt_compartilhar.png" alt="Compartilhar" border="0"/></a>
								<script language="javascript" type="text/javascript">
									var a2a_config = a2a_config || {};
									a2a_config.linkname = "Cartório Postal - '".$fr->fantasia."'";
									a2a_config.linkurl = "<?= $url_rede;?>";
									a2a_config.locale = "pt-BR";
									a2a_config.num_services = 8;
									a2a_config.prioritize = ["email", "google_gmail", "live", "myspace", "orkut", "yahoo_mail", "blogger_post"];
								</script>
								<script src="http://static.addtoany.com/menu/page.js" language="javascript" type="text/javascript"></script>
							</td>
						</tr>
					</table>
					<div class="imagem_noticia">
						<img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= str_replace("-"," ",$res['url_amigavel']);?>" title="<?= $res['titulo_news'];?>" width="690" />
					</div>
					<div class="texto-noticia"><?= $res['texto'];?></div>
					<div class="linha_h2"></div>
					<table width="100%" border="0" align="center" cellspacing="2" cellpadding="2" style="margin-top: 20px;">
						<tr>
							<td width="36%"><span style="font-size: 12px; color: #666666;">Fonte: <?= $res['fonte'];?></span></td>
							<td width="21%"><span style="font-size: 12px; color: #666666;">Por: <?= $res['escrito'];?></span></td>
							<td width="3%"><a href="javascript:self.print()" title="Clique aqui para imprimir está notícia"><img src="<?= URL_IMAGES;?>pages/imprimir.gif" alt="clique aqui para imprimir esta noticia" title="Clique aqui para imprimir está notícia" /></a></td>
						</tr>
						<tr>
							<td colspan="2">
								<div id="fb-root"></div>
								<div class="fb-like" data-send="false" data-width="350" data-show-faces="true"></div>
							</td>
							<td>
								<a href="http://www.facebook.com/share.php?u=<?= $url_rede;?>" target="_blank">
								<img src="<?= URL_IMAGES;?>/pages/facebook-share.png" alt="compartilhar no facebook" title="Compartilhar no Facebook" />
								</a>
							</td>
							<td width="4%"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="cartoriopostal" rel="nofollow">Tweetar</a></td>
							<td width="36%">
								<a class="a2a_dd" href="http://www.addtoany.com/share_save?linkurl=<?= $url_rede;?>;linkname=CabideiroCultural"><img src="<?= URL_IMAGES ?>icon/bt_compartilhar.png" alt="Compartilhar" border="0"/></a>
								<script language="javascript" type="text/javascript">
									var a2a_config = a2a_config || {};
									a2a_config.linkname = "Cartório Postal - '".$fr->fantasia."'";
									a2a_config.linkurl = "<?= $url_rede;?>";
									a2a_config.locale = "pt-BR";
									a2a_config.num_services = 8;
									a2a_config.prioritize = ["email", "google_gmail", "live", "myspace", "orkut", "yahoo_mail", "blogger_post"];
								</script>
								<script src="http://static.addtoany.com/menu/page.js" language="javascript" type="text/javascript"></script>
							</td>
						</tr>
					</table>
					<table align="center" width="100" border="0" cellspacing="5" cellpadding="5" bgcolor="#DDDDDD" style="margin-top: 5px;">
					<?
					$loop_cols = 3;
					$i = 1;
					$sql = $objQuery->SQLQuery("SELECT ns.id_news, ci.id_cat_imagem, im.id_imagem, ci.nome_imagem, ci.descricao, ci.url_amigavel, im.imagem, im.st_id FROM cp_news_nova as ns, cp_imagem as im, cp_cat_imagem as ci WHERE ci.id_cat_imagem=ns.id_cat_imagem AND ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND ns.id_news='" .$id. "' ORDER BY im.id_cat_imagem DESC LIMIT 12");
					while($list = mysql_fetch_array($sql)){
						if($i < $loop_cols){
							echo '
								<td align="center" valign="top" bgcolor="#FFFFFF">
									<div class="galeria"><a href="'.URL_UPLOAD.''.$list['imagem'].'" title="'.$list['descricao'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['imagem'].'" alt="'.str_replace("-"," ",$list['url_amigavel']).'" title="'.$list['descricao'].'" width="212" /></a></div>
								</td>
							';
						}elseif($i == $loop_cols){
							echo '
								<td align="center" valign="top" bgcolor="#FFFFFF">
									<div class="galeria"><a href="'.URL_UPLOAD.''.$list['imagem'].'" title="'.$list['descricao'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['imagem'].'" alt="'.str_replace("-"," ",$list['url_amigavel']).'" title="'.$list['descricao'].'" width="212" /></a></div>
								</td>
								</tr>
								<tr>
							';
							$i = 0;
						}
					$i++;
					}
					?>
					</table>
				</div>
				<div class="nav-06">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF">
								<span style="font-weight: bold; font-size: 15px; color: #202A72; text-transform: uppercase;">OUTRAS NOTÍCIAS:.</span>
								<div class="faixa-h"></div>
								<ul>
								<?
								$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.acesso, date_format(ns.data, '%d/%m/%Y') as data FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE '".$fr->id_empresa."'=ns.id_empresa AND ns.st_id='1' AND ns.id_news!='".$id_news."' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY RAND() LIMIT 5");
								while($res = mysql_fetch_array($sql)){
								?>
									<li>
										<table width="100%" border="0" align="center" cellspacing="1" cellpadding="1">
											<tr>
												<td align="center" valign="middle"><div class="imagem-leia-mais-1"><a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['titulo_news'];?>" title="<?= $res['titulo_news'];?>" width="240" /></a></div></td>
											</tr>
											<tr>
												<td align="left" valign="top"><div class="texto-leia-mais-1"><a href="/<?= $fr->id_empresa ?>/<?= $fr->link_estado ?>/<?= $fr->link_cidade ?>/noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>"><?= $res['titulo_news'];?></a></div></td>
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
									<img src="<?= URL_IMAGES;?>pages/faca-seu-pedido.png" alt="solicite sua certidao aqui na cartorio postal" title="Solicite sua Certidão aqui na Cartório Postal" width="250" />
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