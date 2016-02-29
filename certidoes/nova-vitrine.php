<?
$id_meta=1;
$pg = 'paginas';
require($_SERVER['DOCUMENT_ROOT'].'/certidoes/includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
?>
<div id="container">
	<div id="destaque_franquia">
		<div id="imagem_destaque_franquia">
			<?
			$sql = $objQuery->SQLQuery("SELECT bn.id_banners, bn.st_id, bn.nome_imagem, bn.cat_imagem, bn.destaque FROM cp_banners as bn WHERE bn.id_empresa='1' AND bn.st_id='1' ORDER BY bn.id_banners DESC");
			while($res = mysql_fetch_array($sql)){
			?>
			<img src="<?= URL_UPLOAD;?><?= $res['cat_imagem'];?>" alt="<?= $res['nome_imagem'];?>" title="<?= $res['nome_imagem'];?>" width="990" height="320" />
			<?}?>
		</div>
	</div>
	<div class="box-01">
		<div class="nav-01">
			<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">CONHEÇA A UNIDADE DA CARTÓRIO POSTAL <?= $fr->fantasia;?></h1>
			<div class="faixa_h"></div>
			<p>Cada vez mais nos preocupamos com facilidade e comodidade ao adquirirmos produtos e serviços. 
			Com a sensação de não dar tempo para nada e os trabalhos acumulando, perdemos prazos para fechamento de negócios e outros serviços que necessitam de documentos e vias de contratos, que muitas vezes não estão mais conosco.
			<br /><br />

			A Cartório Postal surge para agilizar seus negócios, seja uma simples certidão de nascimento aos mais variados documentos solicitados na hora de comprar um imóvel. 
			São mais de 150 serviços à sua disposição, onde você terá prazo, as melhores condições de pagamento e, claro, tempo para curtir o melhor da vida!
			<br /><br />

			<strong>Você vai receber a certidão digitalmente em sua máquina e posteriormente o físico emitido pelo Órgão competente.</strong></p>
		</div>
		<div class="nav-02">
			<a href="<?= URL_SITE;?>ultimas-noticias-da-cartorio-postal/" title="Inaugurações das unidades da Cartório Postal">
				<img src="<?= URL_IMAGES;?>pages/inauguracao-franquias.png" alt="Inaugurações das unidades da Cartório Postal" title="Inaugurações das unidades da Cartório Postal" width="150" height="204" />
			</a>
		</div>
	</div>
	<div class="box-01">
		<div class="nav-03">
			<h2 style="font-weight: bold; color: #202A72; text-transform: uppercase;">SOLICITE AGORA SUA CERTIDÃO</h2>
			<div class="faixa_h"></div>
				<a href="<?= URL_SITE;?>certidao/" title="Solicite sua Certidão aqui na Cartório Postal">
					<img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-cartorio-postal.png" alt="Solicite sua Certidão aqui na Cartório Postal" title="Solicite sua Certidão aqui na Cartório Postal" width="290" height="219" />
				</a>
		</div>
		<div class="box-02">
			<h3 style="font-weight: bold; color: #202A72; text-transform: uppercase;">SAIBA MAIS SOBRE A FRANQUIA CARTÓRIO POSTAL...</h3>
			<div class="faixa_h"></div>
			<div class="nav-04">
				<a href="<?= URL_SITE;?>franquia-mais-procurada-do-brasil/" title="Saiba mais sobre a franquia mais procurada do Brasil">
					<img src="<?= URL_IMAGES;?>pages/saiba-mais-sobre-a-franquia-mais-procurada-do-brasil.png" alt="saiba mais sobre a franquia mais procurada do brasil" title="Saiba mais sobre a franquia mais procurada do Brasil" />
				</a>
			</div>
			<div class="nav-05">
				<a href="<?= URL_SITE;?>conheca-as-unidades-da-cartorio-postal/" title="Conheça as unidades da Cartório Postal">
					<img src="<?= URL_IMAGES;?>pages/conheca-as-unidades-da-cartorio-postal.png" alt="conheca as unidades da cartorio postal" title="Conheça as unidades da Cartório Postal" />
				</a>
			</div>
			<div class="nav-06">
				<div class="numero_fraquias">
					<div  style="padding: 8px;">
						SOMOS HOJE<br />
						<strong style="font-size: 25px; color: #EFB700;"><?= $u_ativas;?></strong><br />
						LOJAS
					</div>
				</div>
				<img src="<?= URL_IMAGES;?>pages/numero-de-franquias-da-cartorio-postal.png" alt="numero de franquias da cartorio postal" title="Número de franquias da Cartório Postal" />
			</div>
		</div>
	</div>
	<div class="box-01">
		<div class="nav-07">
			<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
				<tr>
					<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
						<h2 style="font-weight: bold; color: #202A72; text-transform: uppercase;">OFERECEMOS PRODUTOS COM ATENDIMENTO PERSONALIZADO PARA:.</h2>
						<div class="faixa_h"></div>
					</td>
				</tr>
				<tr>
					<?
					$loop_cols = 3;
					$i = 1;
					$onde ="";
					if($busca_dados<>''){$onde .= " and (ps.nome_imagem like '%".$busca_dados."%') ";}
					$condicao = "FROM cp_produtos as ps WHERE ps.id_empresa='1' AND ps.st_id='1' AND ps.destaque='1' ORDER BY RAND()";
					$campo = "ps.id_produtos, ps.nome_imagem, ps.destaque, ps.cat_imagem, ps.destaque, ps.st_id";
					$url_busca = $_SERVER['REQUEST_URI'];
					$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
					$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
					$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 6);
					while($list = mysql_fetch_array($query)){
						if($i < $loop_cols){
							echo '
								<td align="center" valign="top" bgcolor="#FFFFFF">
									<img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" alt="'.$list['nome_imagem'].'" width="290" />
								</td>
							';
						}elseif($i == $loop_cols){
							echo '
								<td align="center" valign="top" bgcolor="#FFFFFF">
									<img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" alt="'.$list['nome_imagem'].'" width="290" />
								</td>
								</tr>
								<tr>';
							$i = 0;
						}
					$i++;
					}
					?>
				<tr>
					<td align="right" valign="middle" bgcolor="#FFFFFF" colspan="3">
						<a href="<?= URL_SITE;?>produtos-e-servicos/" title="Clique aqui para conhecer todos nossos produtos e serviços"><img src="<?= URL_IMAGES;?>pages/ver-todos.png" alt="Clique aqui para conhecer todos nossos produtos e serviços" title="Clique aqui para conhecer todos nossos produtos e serviços" /></a>
						<div class="faixa"></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="box-01">
		<div class="nav">
			<div class="nav-08">
				<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
					<tr>
						<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
							<h3 style="font-weight: bold; color: #202A72; text-transform: uppercase;">ÚLTIMAS NOTÍCIAS:.</h3>
							<div class="faixa_h"></div>
						</td>
					</tr>
					<?
					$sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cp_news_nova as ns WHERE ns.st_id='1' ORDER BY ns.id_news DESC LIMIT 4");
					while($res = mysql_fetch_array($sql)){
					?>
					<tr>
						<td><div style="width: 250px; height: 110px; overflow: hidden;"><a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" width="250" /></a></div></td>
						<td align="left" valign="top">
							<div style="padding: 0 10px;">
								<a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>" class="link_titulo_ultima_noticia"><?= $res['titulo_news'];?></a><br /><br />
								<a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>/" title="<?= $res['titulo_news'];?>" class="link_texto_ultima_noticia"><?= $res['texto_chamada'];?></a>
							</div>
						</td>
					</tr>
					<tr>
						<td height="5" colspan="2"></td>
					</tr>
					<?}?>
				</table>
			</div>
			<div class="nav-09">
				<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
					<tr>
						<td align="left" valign="middle" bgcolor="#FFFFFF">
							<span style="font-weight: bold; font-size: 15px; color: #202A72; text-transform: uppercase;">PRINCIPAIS SERVIÇOS:.</span>
							<div class="faixa_h"></div>
							<ul class="marcador_servicos">
								<?= PRINCIPAIS_SERVICOS;?>
							</ul>
							<ul class="marcador_servicos">
								<?= OFERECEMOS_TAMBEM;?>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="box_d">
		<div id="area_plugin_facebook">
			<strong style="color: #202A72;">CURTA A CARTÓRIO POSTAL</strong>
			<div class="faixa_h"></div>
			<div id="plugin_facebook">
				<div id="fb-root"></div>
				<div class="fb-like-box" data-href="https://www.facebook.com/cartoriopostaloficial" data-width="290px" data-height="286px" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="false"></div>
			</div>
		</div>
		<div id="area_plugin_twitter">
			<strong style="color: #202A72;">ÚLTIMAS DO TWITTER - CARTÓRIO POSTAL</strong>
			<div class="faixa_h"></div>
			<div id="plugin_twitter">
				<a class="twitter-timeline" href="https://twitter.com/cartoriopostal" data-widget-id="357574104934674432">Tweets de @cartoriopostal</a>
				<script language="javascript" type="text/javascript">
				!function(d,s,id){
					var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
					if(!d.getElementById(id)){
						js=d.createElement(s);
						js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
						fjs.parentNode.insertBefore(js,fjs);
					}
				}(document,"script","twitter-wjs");
				</script>
			</div>
		</div>
		<div id="area_midia_social">
			<strong style="color: #202A72;">INTERAGINDO COM VOCÊ</strong>
			<div class="faixa_h"></div>
			<a href="https://www.facebook.com/cartoriopostaloficial/app_195646697137509" title="Clique aqui e solicite sua certidão na Cartório Postal através de nossa página no Facebook" class="link_img" target="_blank">
				<img src="<?= URL_IMAGES;?>pages/solicite-sua-certidao-na-cartorio-postal-atraves-de-nossa-pagina-no-facebook.png" alt="clique aqui e solicite sua certidao na cartorio postal atraves de nossa pagina no facebook" title="Clique aqui e solicite sua certidão na Cartório Postal através de nossa página no Facebook" style="margin-top: 5px;" />
			</a>
		</div>
	</div>
</div>
<div id="apDiv_popup">
	<a href="#" onClick="fechar_popup()" title="Clique aqui para fechar o banner"><img src="<?= URL_IMAGES;?>fechar.png" alt="" title="" width="450" /></a><br /><br />
	<a href="http://www.cartoriopostal.com.br/certidoes/noticia/36/workshop-apresentacao-franquias/" title="Workshop Cartório Postal" target="_blank"><img src="<?= URL_IMAGES;?>workshop.png" alt="workshop cartório postal" title="Workshop Cartório Postal" width="450" /></a>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>