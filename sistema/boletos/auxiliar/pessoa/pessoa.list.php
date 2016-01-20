<? if(count($pessoas)>0){ ?>
	<div id="pessoaListaPag" class="lista">
	<ul>
	<? foreach($pessoas as $i=>$pessoa){  ?>
		<li class="cor<?=$i%2?>">
			<?if($busca=='orcamento'){ ?>
				<a href="javascript:void(0);" onclick="populaOrcamento('cliente',<?=$pessoa->id ?>, '<?=$pessoa ?>')"><img alt="editar" src="<?=$baseUrl?>/img/icones/add.gif"></a>
			<? }elseif($busca=='empresa'){ ?>
				<a href="javascript:void(0);" onclick="addEmpresa(<?=$pessoa->id ?>, '<?=$pessoa ?>')" onmouseover="Tip('<?php echo $pessoa."|".$pessoa->cnpj; ?>')" onmouseout="UnTip()">
					<img alt="editar" src="<?=$baseUrl?>/img/icones/add.gif">
				</a>
			<? }else{?>
				<a href="<?=$oficinaUrlBase.'/pessoa/detalhe/'.$pessoa->getUsuario() ?>" class="edit">editar</a>
				<!--a href="<?=$oficinaUrlBase?>/pessoa/email/<?=$pessoa->usuario ?>" 
							class="lightwindow" 
							title="Envio de email"
params="lightwindow_type=external,lightwindow_width=500,lightwindow_height=400,lightwindow_left=500" -->
				<a href="<?=$oficinaUrlBase.'/pessoa/email/'.$pessoa->getUsuario();?>" class="email">enviar email</a>
			<? }?>
			
			[<?=$pessoa->getRelacionamentos() ?>]
			<?=$pessoa ?> 

		</li>
	<? } ?>
	</ul>
	</div>
<? } ?>