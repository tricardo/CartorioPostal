
<table class="tabela" id="cad4" style="display:none;width:800px">
	<tr>
		<td class="tabela_tit" style="width:800px">Jurídico</td>
	</tr>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'juridico');?></td>
	</tr>
	<tr>
		<td class="tabela_tit">* Informativo</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<? include('fichas-editar-div-informativo.php'); ?>
		</td>
	</tr>
	<?if($c->id_status == 13){?>
	<tr>
		<td class="tabela_tit">* Criar a franquia</td>
	</tr>
	<tr>
		<td class="busca1 tabela_tit_campos">
			<?if(isset($erro_finaliza_processo)){?>
				<span style="color:#FF0000;font-weight:bold">Você deve preencher os campos obrigatórios (*) para continuar.</span><br /><br />
			<?}?>
			Para criar a franquia, verifique se todos os dados estão preenchidos corretamente.<br /><br />
			Clique em <a href="fichas-editar.php?id_ficha=<?=$c->id_ficha?>&aba=4&finaliza_processo=1" style="background-color:#FFCC00;font-weight:bold;text-transform:uppercase;">finalizar</a>, para criar a franquia.
		</td>
	</tr>
	<?}?>
	<?$arquivos = $expansao->listaAnexo($c->id_ficha);
	if(count($arquivos) > 0){?>
	<tr>
		<td class="tabela_tit">* Arquivos Anexados</td>
	</tr>
	<tr>
		<td>
			<table class="result_tabela" cellpadding="4" cellspacing="1" width="100%">
				<tr>
					<td class="result_menu"><b>Tipo do Arquivo</b></td>
					<td class="result_menu"><b>Arquivo</b></td>
					<td class="result_menu"><b>Usuário</b></td>
					<td class="result_menu" style="text-align:center; width:100px"><b>Excluir</b></td>
				</tr>
				<?foreach($arquivos as $b => $res){ ?>
				<tr>
					<td class="result_celula">
						<? $expansao->tipo_upload(1,$res->tipo_upload); ?>
					</td>
					<td class="result_celula">
						<a href="<?=$res->arquivo?>" target="_blank"><?=$res->nome?></a>
					</td>
					<td class="result_celula"><?=$res->consultor?></td>
					<td class="result_celula" class="result_menu" style="text-align:center;">
						<? $excluir = 0; if($c->c_id_usuario == 1){ $excluir = 1; } 
						if($c->c_id_usuario == $res->id_usuario && $excluir == 0){ $excluir = 1; }
						if($excluir == 1){?>
						<a href="fichas-editar.php?id_ficha=<?=$c->id_ficha?>&aba=4&excluir_arquivo=1&id_arquivo=<?=$res->id_anexo?>">
							<img src="../images/botao_editar.png" />
						</a>
						<? } ?>
					</td>
				</tr>
				<? } ?>
			</table>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td style="text-align:center"><?criarBotao($executar_alteracoes, $c->id_status, 'juridico');?></td>
	</tr>
</table>