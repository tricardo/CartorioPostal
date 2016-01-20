<?
require('header.php');
?>
<div style="margin: 15px;">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<h1 class="tit"><img src="../images/tit/tit_pedido.png" alt="Título" />	Ordem</h1>
		<hr class="tit" />
		<br />

		<table width="100%" cellpadding="4" cellspacing="1"	class="result_tabela">
			<?php
			$p_valor = '<tr>
		<td align="center" width="50" class="result_menu"><b>Ordem</b></td>
		<td class="result_menu"  width="80"><b>DATA</b></td>
		<td class="result_menu" width="120"><b>CPF / CNPJ</b></td>
		<td class="result_menu"><b>Documento de</b></td>
        <td align="center" class="result_menu"><b>Serviço</b></td>
		<td align="center" width="80" class="result_menu"><b>Status</b></td>
		<td align="center" class="result_menu"><b>Atividade</b></td>
        <td align="center" width="80" class="result_menu"><b>Anexo</b></td>
	</tr>';
			$condicao = "from vsites_pedido as p, vsites_pedido_item as pi, vsites_status as s, vsites_atividades as a, vsites_servico as ss where p.id_pedido='".$cliente_login."' and md5(concat(p.id_pedido,p.data)) like '".$cliente_senha."%' and p.id_pedido = pi.id_pedido and pi.id_atividade=a.id_atividade and pi.id_status=s.id_status and pi.id_servico=ss.id_servico order by pi.ordem";
			$campo2 = "(select COUNT(0) as total from vsites_pedido_anexo as pa where pi.id_pedido_item=pa.id_pedido_item and (pa.anexo_nome='Certidão' or pa.anexo_nome='Declaração de Busca' or pa.anexo_nome='Declaração de Busca de Imóveis' or pa.anexo_nome='Instrumento de Protesto' or pa.anexo_nome='Documento do Cliente'  ) group by pa.id_pedido_item) as anexo,";
			$campo = "pi.data_prazo, pi.id_servico, pi.ordem, pi.id_pedido_item, pi.data_atividade, a.atividade, s.status, pi.id_pedido, pi.certidao_devedor, pi.certidao_nome, pi.certidao_matricula, pi.certidao_cpf, pi.certidao_cnpj, pi.inicio, ss.descricao as servico, pi.certidao_devedor, pi.certidao_cidade, pi.certidao_estado, pi.certidao_resultado, pi.operacional";
			pt_register('GET','pagina');
			
			$url_busca = $_SERVER['REQUEST_URI'];
			$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
			$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);

			$query = $objQuery->paginacao( $campo2.$campo , $condicao, $pagina , $url_busca);
			?>
			<tr>
				<td colspan="10" class="barra_busca"><?
				$objQuery->QTDPagina();
				?></td>
			</tr>
			<?
			while($res = mysql_fetch_array($query)){
				$id_pedido_item = $res["id_pedido_item"];
				if($res["certidao_devedor"]<>'')$certidao_devedor = '<br><b>Devedor: </b>'.$res["certidao_devedor"]; else
				$certidao_devedor = '';
				$p_valor .= '<tr>
	<td class="result_celula" align="center">#' . $res["id_pedido"] . '/'.$res["ordem"].'</a></td>
	<td class="result_celula">' . invert($res["inicio"],'/','PHP').'</td>
	<td class="result_celula">' . $res["certidao_cnpj"].$res["certidao_cpf"].'</td>
	<td class="result_celula">' . $res["certidao_nome"].$res["certidao_matricula"].$certidao_devedor.'</td>
	<td class="result_celula" align="center">' . $res["servico"] . '</td>
	<td class="result_celula" align="center">' . $res["status"] . '</td>
	<td class="result_celula" align="center">' . $res["atividade"] . '</td>
	';
				if($res["anexo"]<>''){
					$p_valor .= '<td class="result_celula" align="center"><a href="download.php?id='.$id_pedido_item.'" target="_blank"><img src="../images/botao_print.png" title="Anexo" border="0"/></a></td>';
				} else {
					$p_valor .= '<td class="result_celula" align="center">-</td>';
				}
				$p_valor .= '</tr>';
			}

			echo $p_valor;
			?>
			<tr>
				<td colspan="10" class="barra_busca"><?
				$objQuery->QTDPagina();
				?></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</div>
</body>
</html>