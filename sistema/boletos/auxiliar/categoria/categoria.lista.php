<script type="text/javascript" language="javascript" src="<?=$urlBase ?>/especjs/categoria.lista"></script>
<div class="lista" id="lista">
	<h1>Categorias</h1>
	<ul>
		<? foreach($categorias as $i=>$categoria){ ?>
			<li>
				<a href="<?=$urlBase ?>/categoria/excluir/<?=$categoria->id ?>" class="excluir">X</a>
				<a href="<?=$urlBase ?>/categoria/detalhe/<?=$categoria->id ?>">
				<?=$categoria?>
				</a>
				<ul>
					<?foreach($categoria->subCategorias as $subCategoria){ ?>
						<li>
							<a href="<?=$urlBase ?>/categoria/excluir/<?=$subCategoria->id ?>" class="excluir">X</a>
							<a href="<?=$urlBase ?>/categoria/detalhe/<?=$subCategoria->id ?>">
							<?=$subCategoria ?>
							</a>
						</li>
					<? } ?>
				</ul>
			</li>
		<? } ?>
	</ul>
</div>
