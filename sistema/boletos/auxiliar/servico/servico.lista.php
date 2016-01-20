<h1>Servi&ccedil;os</h1>
<table class="lista">
	<tr>
		<th>id</th>
		<th>servi&ccedil;o</th>
		<th>departamento</th>
		<th>status</th>
	</tr>
	<?php foreach($servicos as $servico){ ?>
		<tr>
			<td>
				<a href="<?php echo $urlBase?>/servico/detalhe/<?php echo $servico->id_servico?>">
				<?php echo $servico->id_servico ?>
				</a>
			</td>
			<td><?php echo $servico?></td>
			<td><?php echo $servico->departamento?></td>
			<td><?php echo $servico->status?></td>
		</tr>
	<?php } ?>
</table>
