<?
$id_pagina=1;
$pg = 'paginas_hotsite';
require('../includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-imagens-paginas">
			<img src="<?= URL_IMAGES;?>hotsite/produtos-e-servicos.png" alt="Produtos e serviços" title="Produtos e serviços" />
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-03">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF" colspan="4">
								<h1 style="font-weight: bold; color: #202A72; text-transform: uppercase;">PRODUTOS E SERVIÇOS:.</h1>
								<div class="faixa-h"></div>
							</td>
						</tr>
						<tr>
							<?
							$loop_cols = 2;
							$i = 1;
							$onde ="";
							if($busca_dados<>''){$onde .= " and (ps.nome_imagem like '%".$busca_dados."%') ";}
							$condicao = "FROM cartorio_banco2.vsites_user_empresa as ue, cp_produtos as ps WHERE '".$fr->id_empresa."'=ps.id_empresa AND ps.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY ps.id_produtos DESC";
							$campo = "'".$fr->id_empresa."', ps.id_produtos, ps.nome_imagem, ps.cat_imagem, ps.destaque, ps.st_id";
							$url_busca = $_SERVER['REQUEST_URI'];
							$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
							$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
							$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 60);
							while($list = mysql_fetch_array($query)){
								if($i < $loop_cols){
									echo '
										<td align="center" valign="top" bgcolor="#FFFFFF">
											<a href="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" alt="'.$list['nome_imagem'].'" width="270" /></a>
										</td>
									';
								}elseif($i == $loop_cols){
									echo '
										<td align="center" valign="top" bgcolor="#FFFFFF">
											<a href="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['cat_imagem'].'" title="'.$list['nome_imagem'].'" alt="'.$list['nome_imagem'].'" width="270" /></a>
										</td>
										</tr>
										<tr>';
									$i = 0;
								}
							$i++;
							}
							?>
						<tr>
					</table>
				</div>
				<div class="nav-04">
					<table width="100%" border="0" align="center" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" bgcolor="#FFFFFF">
								<span style="font-weight: bold; font-size: 15px; color: #202A72; text-transform: uppercase;">VEJA TAMBÉM:.</span>
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
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-hotsite.php'); ?>