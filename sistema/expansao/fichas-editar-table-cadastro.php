<table class="tabela" id="cad0" style="width:800px">
	<tr>
		<td class="tabela_tit" style="width:800px">Cadastro</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'cadastro')?></td>
	</tr>
	<tr>
		<td class="tabela_tit">* Dados Pessoais</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-dados-pessoais.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Endereço</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-endereco.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Último Endereço</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-ultimo-endereco.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Dados Pessoais do Cônjuge se Houver</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-dados-pessoais-conjuge.php'); ?>
		</td>
	</tr>
	<tr>
		<td class="tabela_tit">* Lazer</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-lazer.php'); ?>
		</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'cadastro')?></td>
	</tr>
</table>