<table class="tabela" id="cad2" style="display:none;width:800px">
	<tr>
		<td class="tabela_tit" style="width:800px">Bancário</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'bancario')?></td>
	</tr>
	<tr>
		<td class="tabela_tit">* Informações Adicionais</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-informacoes-adicionais.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Referências Bancárias</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-referencias-bancarias.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Demonstrativo de Rendimento</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-demonstrativo-de-recebimento.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Bens de Consumo</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-bens-de-consumo.php'); ?>
		</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'bancario')?></td>
	</tr>
</table>