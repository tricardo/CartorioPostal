<?php
$propostas = $propostaDAO->buscaPorIdCompra($id_compra);
?>
<form method="post" name="aprovar_proposta">
<table border="0" height="100%" width="650" class="tabela">
	<tr>
		<td colspan="4" class="tabela_tit">Propostas</td>
	</tr>
	<tr>
		<td class="tabela_tit">Fornecedor</td>
		<td class="tabela_tit">Valor</td>
		<td class="tabela_tit"></td>
		<td class="tabela_tit">Arquivo</td>
	</tr>
	<?php foreach($propostas as $p){?>
		<tr>
			<td><?php echo $p->fornecedor?></td>
			<td align="right">R$ <?php echo $p->valor ?></td>
			<td>
				<input type="checkbox" name="aprovada" 
				value="<?=$p->id_proposta?>" class="form_estilo aprova"
				<?=($p->aprovada)?'checked="checked"':''?>
				alt="<?=$p->id_compra?>"/>
			</td>
			<td>
				<a href="<?=$p->arquivo ?>" target="_blank">
					<img border="0" title="Anexo" src="../images/botao_print.png" >
				</a>
			</td>
		</tr>
	<?php } ?>
</table>
</form>
<br/>
<script>
	$(document).ready(function() {
	   $(".aprova").click(function(){
			//$.ajaxSetup ({cache: true});
			var id_proposta = $(this).attr('value');
			var id_compra = $(this).attr('alt');
			var aprovada = $(this).attr('checked');
			$.ajax({
				url: "compra_edit.php",
				context: document.body,
				type: "POST",
				data:{"submit_aprova":true,
					"id_proposta":id_proposta,
					"id_compra":id_compra,
					"aprovada":aprovada},
		    	error: function(resp){alert("erro "+resp.statusText);},
		    	success: function(){ if(aprovada) alert('Proposta aprovada');}
	    	});
	   });
	});
</script>