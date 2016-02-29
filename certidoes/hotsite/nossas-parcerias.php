<?
$id_pagina=2;
$pg = 'paginas_hotsite';
require('../includes/url.php');
require_once(URL_SITE_INCLUDE.'header-hotsite.php');
?>
<div id="area-container">
	<div id="container">
		<div id="destaque-imagens-paginas">
			<img src="<?= URL_IMAGES;?>hotsite/nossas-parcerias.png" alt="Nossas Parcerias" title="Nossas Parcerias" />
		</div>
		<div class="box-01">
			<div class="nav">
				<div class="nav-02">
					<table width="100%" border="0" align="left" cellspacing="5" cellpadding="5" bgcolor="#FFFFFF">
						<tr>
							<td align="left" valign="middle" colspan="3" bgcolor="#FFFFFF">
								<h5 style="font-weight: bold; color: #202A72; text-transform: uppercase;">NOSSAS PARCERIAS:.</h5>
								<div class="faixa-h" style="margin-bottom: 5px;"></div>
							</td>
						</tr>
						<tr>
							<?
							$loop_cols = 3;
							$i = 1;
							$onde ="";
							if($busca_dados<>''){$onde .= " and (ps.nome_imagem like '%".$busca_dados."%') ";}
							$condicao = "FROM cartorio_banco2.vsites_user_empresa as ue, cp_parcerias as ps WHERE '".$fr->id_empresa."'=ps.id_empresa AND ps.st_id='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY ps.id_parcerias DESC";
							$campo = "'".$fr->id_empresa."', ps.id_parcerias, ps.nome_imagem, ps.cat_imagem, ps.destaque, ps.st_id";
							$url_busca = $_SERVER['REQUEST_URI'];
							$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
							$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
							$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 600);
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
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer-hotsite.php'); ?>