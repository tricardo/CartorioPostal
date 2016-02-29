<?
$pg = 'hotsite';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-franquia">
			<div id="imagem-destaque-franquia">
				<?
				$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', bn.id_banners, bn.st_id, bn.nome_imagem, bn.cat_imagem, bn.destaque FROM cartorio_banco2.vsites_user_empresa as ue, cp_banners as bn WHERE '".$fr->id_empresa."'=bn.id_empresa AND bn.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY bn.id_banners DESC");
				while($res = mysql_fetch_array($sql)){
				?>
				<img src="<?= URL_UPLOAD;?><?= $res['cat_imagem'];?>" alt="<?= $res['nome_imagem'];?>" title="<?= $res['nome_imagem'];?>" width="990" height="320" />
				<?}?>
			</div>
		</div>
		<div class="box-01">
			<div class="nav-01">
				<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">CONHEÇA A UNIDADE DA CARTÓRIO POSTAL <?= $fr->fantasia;?></h1>
				<div class="faixa-h"></div>
				<p>Cada vez mais nos preocupamos com facilidade e comodidade ao adquirirmos produtos e serviços.<br />
				Com mais de 18 anos de atuação no mercado, e uma rede de franquias que supera <?= $n_fraquias = $n_fraquias[0]->total;?> unidades espalhadas por todo o Brasil, a Cartório Postal é a empresa pioneira em consultoria e assessoria documental.<br /><br />
				<?
				if($fr->id_empresa==1) echo ' <strong>A Matriz</strong> '; 
					else echo '<strong>A Unidade</strong> ';
					echo '<strong>'.$fr->fantasia.'</strong>';
				if($fr->data_hotsite<>'' and $fr->data_hotsite!='0000-00-00') echo ' está em operação desde '. invert($fr->data_hotsite,'/','PHP') .' e ';
				?>
				apresenta um mix relacionados à intermediação entre pessoas e órgãos públicos (cartórios e todas outras entidades), com abrangência nacional e internacional direcionados para pessoas físicas e jurídicas.</p>
			</div>
		</div>
		<div class="box-02">
			<div class="nav">
				<div class="nav-02">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
								<h2 style="font-weight: bold; color: #202A72; text-transform: uppercase;">OFERECEMOS PRODUTOS COM ATENDIMENTO PERSONALIZADO PARA</h2>
								<div class="faixa-h"></div>
							</td>
						</tr>
						<tr>
							<?
							$loop_cols = 3;
							$i = 1;
							$onde ="";
							if($busca_dados<>''){$onde .= " and (ps.nome_imagem like '%".$busca_dados."%') ";}
							$condicao = "FROM cartorio_banco2.vsites_user_empresa as ue, cp_produtos as ps WHERE '".$fr->id_empresa."'=ps.id_empresa AND ps.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY RAND()";
							$campo = "'".$fr->id_empresa."', ps.id_produtos, ps.nome_imagem, ps.cat_imagem, ps.destaque, ps.st_id";
							$url_busca = $_SERVER['REQUEST_URI'];
							$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
							$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
							$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 6);
							while($list = mysql_fetch_array($query)){
								if($i < $loop_cols){
									echo '
										<td align="center" valign="top" bgcolor="#FFFFFF">
											<a href="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" alt="'.$list['nome_imagem'].'" width="290" /></a>
										</td>
									';
								}elseif($i == $loop_cols){
									echo '
										<td align="center" valign="top" bgcolor="#FFFFFF">
											<a href="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" alt="'.$list['nome_imagem'].'" width="290" /></a>
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
								<a href="" title=""><img src="<?= URL_IMAGES;?>pages/ver-todos.png" alt="Clique aqui para conhecer todos nossos produtos e serviços" title="Clique aqui para conhecer todos nossos produtos e serviços" /></a>
								<div class="faixa"></div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-03">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
								<h3 style="font-weight: bold; color: #202A72; text-transform: uppercase;">ÚLTIMAS NOTÍCIAS:.</h3>
								<div class="faixa-h"></div>
							</td>
						</tr>
						<?
						$sql = $objQuery->SQLQuery("SELECT '".$fr->id_empresa."', ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.ordem FROM cartorio_banco2.vsites_user_empresa as ue, cp_news_nova as ns WHERE '".$fr->id_empresa."'=ns.id_empresa AND ns.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY ns.ordem DESC LIMIT 4");
						while($res = mysql_fetch_array($sql)){
						?>
						<tr>
							<td><div style="width: 250px; height: 110px; overflow: hidden;"><a href="" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" width="250" /></a></div></td>
							<td align="left" valign="top">
								<div style="padding: 0 10px;">
									<a href="" title="<?= $res['titulo_news'];?>" class="link_titulo_ultima_noticia"><?= $res['titulo_news'];?></a><br /><br />
									<a href="" title="<?= $res['titulo_news'];?>" class="link_texto_ultima_noticia"><?= $res['texto_chamada'];?></a>
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
								<span style="font-weight: bold; font-size: 15px; color: #202A72; text-transform: uppercase;">PRINCIPAIS SERVIÇOS:.</span>
								<div class="faixa-h"></div>
								<ul class="marcador-servicos">
									<?= PRINCIPAIS_SERVICOS;?>
								</ul>
								<ul class="marcador-servicos">
									<?= OFERECEMOS_TAMBEM;?>
								</ul>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="box-03">
			<div class="nav">
				<div class="nav-01">
					<h4 style="font-weight: bold; color: #202A72; text-transform: uppercase;">REGIÃO DE ATENDIMENTO DESSA UNIDADE:.</h4>
					<div class="faixa-h"></div>
					<?
					if($fr->id_empresa==1) echo '<span style="font: bold 15px/150% Arial; text-align: justify; color: #666666;">A Matriz da Cartório Postal é responsável pelo atendimento dessa região.</span><br />';
					else {
						echo '<span style="font: bold 15px/150% Arial; text-align: justify; color: #666666;">Essa unidade é responsável pelo atendimento dos clientes que residem nas seguintes regiões:</span><br />';
						$fr_cidades = $empresaDAO->listaEmpresaCidade($fr->id_empresa);
						$p_valor='';
						foreach($fr_cidades as $frc){
							$p_valor .= '<li>'.$frc->estado.' - '.$frc->cidade.'</li>';
						}
						echo '<ul class="franquia-cidade">'.$p_valor.'</ul>';
					}?>
				</div>
				<div class="nav-02">
					<table width="100%" border="0" align="left" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF">
								<h5 style="font-weight: bold; color: #202A72; text-transform: uppercase;">GALERIA DE FOTOS - <?= str_replace("Cartório Postal - ","",$fr->fantasia) ?></h5>
								<div class="faixa-h" style="margin-bottom: 5px;"></div>
								<?
								$lgaleria = $siteDAO->selecionaFranquiaGaleriaPorId($fr->id_empresa);
								if($lgaleria[0]->imagem<>''){
									$p_valor = '<ul class="franquia-galeria">';
									foreach($lgaleria as $l){
										$p_valor .= '
										<li>
											<a href="'.URL_UPLOAD.''.$l->imagem.'" title="'.$l->descricao.'" rel="shadowbox[vocation]">
												<img src="'.URL_UPLOAD.''.$l->imagem.'" alt="'.str_replace("-"," ",$l->url_amigavel).'" title="'.$l->nome_imagem.'" width="220"/>
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
						<tr>
							<td align="right" valign="middle">
								<a href="" title=""><img src="<?= URL_IMAGES;?>pages/ver-todos.png" alt="Clique aqui para conhecer todos nossos produtos e serviços" title="Clique aqui para conhecer todos nossos produtos e serviços" /></a>
								<div class="faixa"></div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-hotsite.php'); ?>