<? if($acao=="atualizar"){ ?>
<div id="menuVeiculo" class="submenu">
	<? if($usuario->funcionario>=1){ ?>
		<a href="javascript:void(0);" onclick="requisicao('orcamento/cadastrar/orc/idVeiculo/<?=$veiculo->id?>/idCliente/<?=$veiculo->idProprietario?>')">		
		+ orcamento
		</a>
	<?}?>
	<a href="javascript:void(0);" onclick="requisicao('orcamento/listar/a/idVeiculo/<?=$veiculo->id?>/idCliente/<?=$veiculo->idProprietario?>')">		
	listar orcamento
	</a>	
</div>
<? } ?>