<table class="tabela" id="cad1" style="display:none;width:800px">
	<tr>
		<td class="tabela_tit" style="width:800px">Empresarial</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'empresarial')?></td>
	</tr>
	<tr>
		<td class="tabela_tit">* Experiência com Franquias</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-experiencia-com-franquias.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Histórico Profissional</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-historico-profissional.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Sobre a Franquia Cartório Postal</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-sobre-a-franquia-cp.php'); ?>
		</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'empresarial')?></td>
	</tr>
</table>