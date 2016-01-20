<?
require('header.php');
$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

?>
<div id="topo">
<h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" />Log de arquivos</h1>
<a href="#" class="topo">topo</a>
<hr class="tit" />
</div>
<div id="meio">
<table border="0" height="100%" width="100%">
	<tr>
		<td valign="top">
		<center>
		<table width="650" class="result_tabela" cellpadding="4"
			cellspacing="1">
			<tr>
				<td class="tabela_tit"><strong>ID </strong></td>
				<td class="tabela_tit"><strong>Cliente </strong></td>
				<td class="tabela_tit"><strong>Data </strong></td>
				<td class="tabela_tit"><strong>Erros </strong></td>
				<td class="tabela_tit"><strong>Excel </strong></td>
			</tr>
			<?
			$arquivoitemDAO = new ArquivoItemDAO();
			$lista = $arquivoitemDAO->listaRemessaC($controle_id_empresa);
			$p_valor = '';
			foreach($lista as $l){
				$p_valor .= '
					<tr>
						<td class="result_celula"> '.$l->id_arquivo.'</td>
						<td class="result_celula"> '.$l->nome.'</td>
						<td class="result_celula"> '.invert($l->data,'/','PHP').'</td>
						<td class="result_celula"> <a href="pedido_remessa_cc.php?id_arquivo='.$l->id_arquivo.'">'.$l->erros.'</a></td>
						<td class="result_celula"> <a href="gera_remessa_c.php?id_arquivo='.$l->id_arquivo.'" target="_blank">Download</a></td>
					</tr>';
			}
			echo $p_valor;
			?>
		</table>
		</center>
		</td>
	</tr>
</table>
</div>
			<?php
			require('footer.php');
			?>